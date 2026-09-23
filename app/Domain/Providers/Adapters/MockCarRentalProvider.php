<?php

namespace App\Domain\Providers\Adapters;

use App\Domain\Providers\Contracts\CarRentalProvider;
use App\Domain\Providers\DTOs\AttributionData;
use App\Domain\Providers\DTOs\NormalizedOffer;
use App\Domain\Providers\DTOs\ProviderHealth;
use App\Domain\Providers\DTOs\ProviderSearchResult;
use App\Domain\Search\Data\SearchCriteria;
use App\Models\Offer;
use App\Models\Provider;
use Carbon\Carbon;

class MockCarRentalProvider implements CarRentalProvider
{
    protected ?Provider $providerModel = null;

    public function __construct(?Provider $provider = null)
    {
        $this->providerModel = $provider;
    }

    public function search(SearchCriteria $criteria): ProviderSearchResult
    {
        $startTime = microtime(true);
        $days = $criteria->rentalDays();

        $vehicleTemplates = [
            [
                'name' => 'Suzuki Swift or similar',
                'category' => 'ECONOMY',
                'seats' => 5,
                'bags' => 2,
                'doors' => 4,
                'transmission' => 'manual',
                'base_daily' => 350000, // Rs. 3,500
                'image' => 'https://images.unsplash.com/photo-1590362891988-f77804702088?auto=format&fit=crop&w=1200&h=750&q=85',
                'suppliers' => [
                    ['name' => 'Kathmandu Wheels', 'rating' => 9.0, 'pickup' => 'terminal'],
                    ['name' => 'Avis Nepal', 'rating' => 8.8, 'pickup' => 'terminal'],
                    ['name' => 'Nepal Overland Express', 'rating' => 8.5, 'pickup' => 'shuttle'],
                ],
            ],
            [
                'name' => 'Hyundai Grand i10 or similar',
                'category' => 'MINI',
                'seats' => 4,
                'bags' => 1,
                'doors' => 4,
                'transmission' => 'manual',
                'base_daily' => 280000, // Rs. 2,800
                'image' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=1200&h=750&q=85',
                'suppliers' => [
                    ['name' => 'Everest Tour Fleet', 'rating' => 8.7, 'pickup' => 'terminal'],
                    ['name' => 'Kathmandu Wheels', 'rating' => 9.0, 'pickup' => 'terminal'],
                ],
            ],
            [
                'name' => 'Hyundai Creta or similar',
                'category' => 'COMPACT',
                'seats' => 5,
                'bags' => 3,
                'doors' => 5,
                'transmission' => 'automatic',
                'base_daily' => 550000, // Rs. 5,500
                'image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1200&h=750&q=85',
                'suppliers' => [
                    ['name' => 'Himalayan Car Rental', 'rating' => 9.3, 'pickup' => 'terminal'],
                    ['name' => 'Pokhara Drive Co.', 'rating' => 9.1, 'pickup' => 'terminal'],
                    ['name' => 'Avis Nepal', 'rating' => 8.8, 'pickup' => 'shuttle'],
                ],
            ],
            [
                'name' => 'Mahindra Scorpio 4WD or similar',
                'category' => 'SUV',
                'seats' => 7,
                'bags' => 4,
                'doors' => 5,
                'transmission' => 'manual',
                'base_daily' => 750000, // Rs. 7,500
                'image' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=1200&h=750&q=85',
                'suppliers' => [
                    ['name' => 'Himalayan Car Rental', 'rating' => 9.3, 'pickup' => 'terminal'],
                    ['name' => 'Pokhara Drive Co.', 'rating' => 9.1, 'pickup' => 'terminal'],
                    ['name' => 'Kathmandu Wheels', 'rating' => 9.0, 'pickup' => 'terminal'],
                ],
            ],
            [
                'name' => 'Toyota Hilux 4x4 Double Cab',
                'category' => 'FULLSIZE',
                'seats' => 5,
                'bags' => 4,
                'doors' => 4,
                'transmission' => 'automatic',
                'base_daily' => 1050000, // Rs. 10,500
                'image' => 'https://images.unsplash.com/photo-1559416523-140ddc3d238c?auto=format&fit=crop&w=1200&h=750&q=85',
                'suppliers' => [
                    ['name' => 'Avis Nepal', 'rating' => 8.9, 'pickup' => 'terminal'],
                    ['name' => 'Nepal Overland Express', 'rating' => 8.6, 'pickup' => 'shuttle'],
                ],
            ],
            [
                'name' => 'Toyota HiAce Tourist Commuter',
                'category' => 'VAN',
                'seats' => 12,
                'bags' => 6,
                'doors' => 4,
                'transmission' => 'manual',
                'base_daily' => 950000, // Rs. 9,500
                'image' => 'https://images.unsplash.com/photo-1542282088-72c9c27ed0cd?auto=format&fit=crop&w=1200&h=750&q=85',
                'suppliers' => [
                    ['name' => 'Himalayan Car Rental', 'rating' => 9.2, 'pickup' => 'terminal'],
                    ['name' => 'Everest Tour Fleet', 'rating' => 8.7, 'pickup' => 'terminal'],
                ],
            ],
            [
                'name' => 'Toyota Land Cruiser Prado TX',
                'category' => 'LUXURY',
                'seats' => 7,
                'bags' => 5,
                'doors' => 5,
                'transmission' => 'automatic',
                'base_daily' => 1800000, // Rs. 18,000
                'image' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=1200&h=750&q=85',
                'suppliers' => [
                    ['name' => 'Himalayan Car Rental', 'rating' => 9.4, 'pickup' => 'terminal'],
                    ['name' => 'Avis Nepal', 'rating' => 9.0, 'pickup' => 'terminal'],
                ],
            ],
        ];

        $offers = [];
        $offerCounter = 1;

        foreach ($vehicleTemplates as $template) {
            foreach ($template['suppliers'] as $supplier) {
                // Generate slight price variance per supplier
                $multiplier = match ($supplier['name']) {
                    'Everest Tour Fleet' => 0.94,
                    'Nepal Overland Express' => 0.97,
                    'Kathmandu Wheels' => 1.0,
                    'Pokhara Drive Co.' => 1.02,
                    'Avis Nepal' => 1.05,
                    'Himalayan Car Rental' => 1.08,
                    default => 1.0,
                };

                $dailyPriceMinor = (int) round($template['base_daily'] * $multiplier);
                $totalPriceMinor = $dailyPriceMinor * $days;

                $externalId = 'MOCK_' . md5($template['name'] . $supplier['name'] . $criteria->hash());

                $offers[] = new NormalizedOffer(
                    externalOfferId: $externalId,
                    vehicleCategoryCode: $template['category'],
                    vehicleName: $template['name'],
                    vehicleImageUrl: $template['image'],
                    vehicleGroup: $template['category'],
                    transmission: $template['transmission'],
                    seats: $template['seats'],
                    doors: $template['doors'],
                    bags: $template['bags'],
                    hasAc: true,
                    supplierName: $supplier['name'],
                    supplierLogoUrl: null,
                    supplierRating: (float) $supplier['rating'],
                    pickupType: $supplier['pickup'],
                    pickupLocationName: $criteria->pickupLocation->name,
                    totalPriceMinor: $totalPriceMinor,
                    dailyPriceMinor: $dailyPriceMinor,
                    currency: $criteria->currency,
                    originalTotalPriceMinor: $totalPriceMinor,
                    originalCurrency: $criteria->currency,
                    exchangeRate: 1.0,
                    taxIncluded: true,
                    feesIncluded: true,
                    mileagePolicy: 'unlimited',
                    fuelPolicy: 'full_to_full',
                    cancellationPolicy: 'free_cancellation',
                    cancellationDeadline: $criteria->pickupDatetime->copy()->subHours(48),
                    depositMinor: 25000, // $250 deposit
                    deepLinkUrl: "https://demo-booking.hahacar.com/checkout?offer_id={$externalId}",
                    expiresAt: Carbon::now()->addHours(2),
                    isSponsored: ($offerCounter === 1) // first result demo commercial boost
                );

                $offerCounter++;
            }
        }

        $latency = (int) round((microtime(true) - $startTime) * 1000);

        return new ProviderSearchResult(
            success: true,
            offers: $offers,
            latencyMs: $latency,
            httpStatus: 200
        );
    }

    public function refresh(string $providerOfferId, SearchCriteria $criteria): ?NormalizedOffer
    {
        $result = $this->search($criteria);
        foreach ($result->offers as $offer) {
            if ($offer->externalOfferId === $providerOfferId) {
                return $offer;
            }
        }
        return $result->offers[0] ?? null;
    }

    public function buildRedirectUrl(Offer $offer, AttributionData $attribution): string
    {
        $baseUrl = "https://demo-booking.hahacar.com/reserve";
        $params = [
            'offer_id' => $offer->external_offer_id,
            'vehicle' => $offer->vehicle_name,
            'supplier' => $offer->supplier_name,
            'pickup' => $offer->search->pickupLocation->iata_code ?? $offer->search->pickupLocation->city,
            'from' => $offer->search->pickup_datetime->format('Y-m-d_H:i'),
            'to' => $offer->search->dropoff_datetime->format('Y-m-d_H:i'),
            'sub_id' => $attribution->subId ?? 'hahacar_web',
            'utm_source' => $attribution->utmSource ?? 'hahacar',
            'utm_medium' => $attribution->utmMedium ?? 'metasearch',
            'utm_campaign' => $attribution->utmCampaign ?? 'car_rental',
        ];

        return $baseUrl . '?' . http_build_query($params);
    }

    public function healthCheck(): ProviderHealth
    {
        return new ProviderHealth(
            status: 'healthy',
            latencyMs: 45,
            message: 'Mock Provider Sandbox API responsive'
        );
    }
}
