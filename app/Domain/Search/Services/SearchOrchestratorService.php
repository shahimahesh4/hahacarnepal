<?php

namespace App\Domain\Search\Services;

use App\Domain\Offers\Ranking\OfferRankingService;
use App\Domain\Providers\Adapters\MockCarRentalProvider;
use App\Domain\Search\Data\SearchCriteria;
use App\Models\Offer;
use App\Models\Provider;
use App\Models\ProviderSearch;
use App\Models\Search;
use App\Models\VehicleCategory;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SearchOrchestratorService
{
    public function __construct(
        protected OfferRankingService $rankingService
    ) {}

    public function orchestrate(SearchCriteria $criteria, ?string $sessionId = null, ?int $userId = null, ?array $attribution = null): Search
    {
        $criteriaHash = $criteria->hash();

        // 1. Check for recent valid search within cache TTL (15 minutes)
        $cachedSearch = Search::where('criteria_hash', $criteriaHash)
            ->where('created_at', '>=', Carbon::now()->subMinutes(15))
            ->where('status', 'completed')
            ->whereHas('offers')
            ->with(['offers.vehicleCategory', 'pickupLocation', 'dropoffLocation'])
            ->latest()
            ->first();

        if ($cachedSearch) {
            return $cachedSearch;
        }

        $overallStart = microtime(true);

        // 2. Create Search record
        $search = Search::create([
            'uuid' => (string) Str::uuid(),
            'session_id' => $sessionId,
            'user_id' => $userId,
            'pickup_location_id' => $criteria->pickupLocation->id,
            'dropoff_location_id' => $criteria->dropoffLocation->id,
            'pickup_datetime' => $criteria->pickupDatetime,
            'dropoff_datetime' => $criteria->dropoffDatetime,
            'driver_age' => $criteria->driverAge,
            'currency' => $criteria->currency,
            'locale' => $criteria->locale,
            'criteria_hash' => $criteriaHash,
            'status' => 'pending',
            'provider_count' => 0,
            'result_count' => 0,
            'duration_ms' => 0,
            'attribution' => $attribution,
            'expires_at' => Carbon::now()->addHours(2),
        ]);

        // 3. Resolve active providers
        $activeProviders = Provider::where('is_active', true)->orderBy('priority')->get();

        // If no providers in DB yet, create or fallback to default mock provider
        if ($activeProviders->isEmpty()) {
            $mockProvider = Provider::firstOrCreate(
                ['slug' => 'hahacar-mock'],
                [
                    'name' => 'Hahacar Direct Mock Network',
                    'adapter_class' => MockCarRentalProvider::class,
                    'status' => 'active',
                    'priority' => 1,
                    'timeout_ms' => 3000,
                    'commission_model' => 'cpc',
                    'is_active' => true,
                    'last_health_state' => 'healthy',
                    'last_health_check_at' => now(),
                ]
            );
            $activeProviders = collect([$mockProvider]);
        }

        $allRawOffers = [];
        $providerCount = 0;

        foreach ($activeProviders as $providerModel) {
            $providerCount++;
            $adapterClass = $providerModel->adapter_class;
            
            if (!class_exists($adapterClass)) {
                $adapterClass = MockCarRentalProvider::class;
            }

            /** @var \App\Domain\Providers\Contracts\CarRentalProvider $adapter */
            $adapter = new $adapterClass($providerModel);

            $searchStart = microtime(true);
            try {
                $result = $adapter->search($criteria);
                $latency = (int) round((microtime(true) - $searchStart) * 1000);

                ProviderSearch::create([
                    'search_id' => $search->id,
                    'provider_id' => $providerModel->id,
                    'request_hash' => $criteriaHash,
                    'status' => $result->success ? 'success' : 'error',
                    'latency_ms' => $latency,
                    'http_status' => $result->httpStatus,
                    'error_message' => $result->errorMessage,
                    'result_count' => count($result->offers),
                ]);

                if ($result->success) {
                    foreach ($result->offers as $offer) {
                        $allRawOffers[] = [
                            'provider_id' => $providerModel->id,
                            'offer' => $offer,
                        ];
                    }
                }
            } catch (\Throwable $e) {
                $latency = (int) round((microtime(true) - $searchStart) * 1000);
                ProviderSearch::create([
                    'search_id' => $search->id,
                    'provider_id' => $providerModel->id,
                    'request_hash' => $criteriaHash,
                    'status' => 'error',
                    'latency_ms' => $latency,
                    'http_status' => 500,
                    'error_message' => $e->getMessage(),
                    'result_count' => 0,
                ]);
            }
        }

        // 4. Deduplicate offers by fingerprint
        $deduplicatedOffers = [];
        $seenFingerprints = [];

        foreach ($allRawOffers as $item) {
            /** @var \App\Domain\Providers\DTOs\NormalizedOffer $normalizedOffer */
            $normalizedOffer = $item['offer'];
            $fingerprint = $normalizedOffer->calculateFingerprint($criteria->pickupLocation->id);

            if (!isset($seenFingerprints[$fingerprint])) {
                $seenFingerprints[$fingerprint] = true;
                $deduplicatedOffers[] = $item;
            }
        }

        // 5. Calculate transparent ranking scores
        $offersForRanking = array_map(fn($item) => $item['offer'], $deduplicatedOffers);
        $rankingScores = $this->rankingService->rank($offersForRanking);

        // Preload vehicle categories
        $categories = VehicleCategory::all()->keyBy('code');

        // 6. Persist offer snapshots
        foreach ($deduplicatedOffers as $item) {
            $providerId = $item['provider_id'];
            /** @var \App\Domain\Providers\DTOs\NormalizedOffer $off */
            $off = $item['offer'];

            $category = $categories->get(strtoupper($off->vehicleCategoryCode));
            if (!$category) {
                $category = VehicleCategory::firstOrCreate(
                    ['code' => strtoupper($off->vehicleCategoryCode)],
                    ['name' => ucfirst(strtolower($off->vehicleCategoryCode)), 'sipp_code' => 'CDAR']
                );
                $categories->put(strtoupper($off->vehicleCategoryCode), $category);
            }

            $score = $rankingScores[$off->externalOfferId] ?? 50.0;
            $fingerprint = $off->calculateFingerprint($criteria->pickupLocation->id);

            Offer::create([
                'uuid' => (string) Str::uuid(),
                'search_id' => $search->id,
                'provider_id' => $providerId,
                'external_offer_id' => $off->externalOfferId,
                'fingerprint' => $fingerprint,
                'vehicle_category_id' => $category->id,
                'vehicle_name' => $off->vehicleName,
                'vehicle_image_url' => $off->vehicleImageUrl,
                'vehicle_group' => $off->vehicleGroup,
                'transmission' => $off->transmission,
                'seats' => $off->seats,
                'doors' => $off->doors,
                'bags' => $off->bags,
                'has_ac' => $off->hasAc,
                'supplier_name' => $off->supplierName,
                'supplier_logo_url' => $off->supplierLogoUrl,
                'supplier_rating' => $off->supplierRating,
                'pickup_type' => $off->pickupType,
                'pickup_location_name' => $off->pickupLocationName,
                'total_price_minor' => $off->totalPriceMinor,
                'daily_price_minor' => $off->dailyPriceMinor,
                'currency' => $off->currency,
                'original_total_price_minor' => $off->originalTotalPriceMinor,
                'original_currency' => $off->originalCurrency,
                'exchange_rate' => $off->exchangeRate,
                'tax_included' => $off->taxIncluded,
                'fees_included' => $off->feesIncluded,
                'mileage_policy' => $off->mileagePolicy,
                'fuel_policy' => $off->fuelPolicy,
                'cancellation_policy' => $off->cancellationPolicy,
                'cancellation_deadline' => $off->cancellationDeadline,
                'deposit_minor' => $off->depositMinor,
                'ranking_score' => $score,
                'is_sponsored' => $off->isSponsored,
                'deep_link_payload' => $off->deepLinkUrl,
                'expires_at' => $off->expiresAt ?? Carbon::now()->addHours(2),
            ]);
        }

        // 7. Update Search record
        $totalDuration = (int) round((microtime(true) - $overallStart) * 1000);
        $search->update([
            'status' => 'completed',
            'provider_count' => $providerCount,
            'result_count' => count($deduplicatedOffers),
            'duration_ms' => $totalDuration,
        ]);

        return $search->load(['offers.vehicleCategory', 'offers.provider', 'pickupLocation', 'dropoffLocation']);
    }
}
