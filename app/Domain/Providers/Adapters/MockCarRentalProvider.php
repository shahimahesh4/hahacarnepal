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
                'name' => 'Mahindra Scorpio 4WD S11',
                'category' => 'SUV',
                'seats' => 7,
                'bags' => 4,
                'doors' => 5,
                'transmission' => 'manual',
                'base_daily' => 550000, // Rs. 5,500
                'image' => '/images/vehicles/scorpio.jpg',
                'suppliers' => [
                    ['name' => 'Himalayan Car Rental', 'rating' => 9.4, 'pickup' => 'terminal'],
                    ['name' => 'Kathmandu Wheels', 'rating' => 9.1, 'pickup' => 'terminal'],
                    ['name' => 'Pokhara Drive Co.', 'rating' => 9.0, 'pickup' => 'terminal'],
                ],
            ],
            [
                'name' => 'Suzuki Swift VXI',
                'category' => 'ECONOMY',
                'seats' => 5,
                'bags' => 2,
                'doors' => 4,
                'transmission' => 'manual',
                'base_daily' => 280000, // Rs. 2,800
                'image' => '/images/vehicles/swift.jpg',
                'suppliers' => [
                    ['name' => 'Kathmandu Wheels', 'rating' => 9.1, 'pickup' => 'terminal'],
                    ['name' => 'Pokhara Drive Co.', 'rating' => 8.9, 'pickup' => 'shuttle'],
                    ['name' => 'Nepal Overland Express', 'rating' => 8.7, 'pickup' => 'terminal'],
                ],
            ],
            [
                'name' => 'Toyota HiAce Tourist Commuter (14 Seats)',
                'category' => 'VAN',
                'seats' => 14,
                'bags' => 8,
                'doors' => 4,
                'transmission' => 'manual',
                'base_daily' => 800000, // Rs. 8,000
                'image' => '/images/vehicles/hiace.jpg',
                'suppliers' => [
                    ['name' => 'Himalayan Car Rental', 'rating' => 9.4, 'pickup' => 'terminal'],
                    ['name' => 'Everest Tour Fleet', 'rating' => 9.2, 'pickup' => 'terminal'],
                    ['name' => 'Annapurna Safari Fleets', 'rating' => 8.9, 'pickup' => 'shuttle'],
                ],
            ],
            [
                'name' => 'Hyundai Creta SX',
                'category' => 'COMPACT',
                'seats' => 5,
                'bags' => 3,
                'doors' => 5,
                'transmission' => 'automatic',
                'base_daily' => 420000, // Rs. 4,200
                'image' => '/images/vehicles/creta.jpg',
                'suppliers' => [
                    ['name' => 'Himalayan Car Rental', 'rating' => 9.3, 'pickup' => 'terminal'],
                    ['name' => 'Pokhara Drive Co.', 'rating' => 9.0, 'pickup' => 'terminal'],
                    ['name' => 'Kathmandu Wheels', 'rating' => 8.8, 'pickup' => 'shuttle'],
                ],
            ],
            [
                'name' => 'Toyota Hilux 4x4 Double Cab',
                'category' => 'FULLSIZE',
                'seats' => 5,
                'bags' => 5,
                'doors' => 4,
                'transmission' => 'manual',
                'base_daily' => 750000, // Rs. 7,500
                'image' => '/images/vehicles/hilux.jpg',
                'suppliers' => [
                    ['name' => 'Annapurna Safari Fleets', 'rating' => 9.3, 'pickup' => 'terminal'],
                    ['name' => 'Nepal Overland Express', 'rating' => 8.9, 'pickup' => 'shuttle'],
                ],
            ],
            [
                'name' => 'Hyundai Grand i10 Nios',
                'category' => 'MINI',
                'seats' => 4,
                'bags' => 2,
                'doors' => 4,
                'transmission' => 'manual',
                'base_daily' => 250000, // Rs. 2,500
                'image' => '/images/vehicles/swift.jpg',
                'suppliers' => [
                    ['name' => 'Kathmandu Wheels', 'rating' => 9.0, 'pickup' => 'terminal'],
                    ['name' => 'Everest Tour Fleet', 'rating' => 8.8, 'pickup' => 'terminal'],
                ],
            ],
            [
                'name' => 'BYD Atto 3 EV (Electric SUV)',
                'category' => 'INTERMEDIATE',
                'seats' => 5,
                'bags' => 3,
                'doors' => 5,
                'transmission' => 'automatic',
                'base_daily' => 480000, // Rs. 4,800
                'image' => '/images/vehicles/byd_atto3.jpg',
                'suppliers' => [
                    ['name' => 'Kathmandu Wheels', 'rating' => 9.2, 'pickup' => 'terminal'],
                    ['name' => 'Pokhara Drive Co.', 'rating' => 9.1, 'pickup' => 'terminal'],
                ],
            ],
            [
                'name' => 'Toyota Land Cruiser Prado TX',
                'category' => 'LUXURY',
                'seats' => 7,
                'bags' => 5,
                'doors' => 5,
                'transmission' => 'automatic',
                'base_daily' => 1500000, // Rs. 15,000
                'image' => '/images/vehicles/prado.jpg',
                'suppliers' => [
                    ['name' => 'Himalayan Car Rental', 'rating' => 9.5, 'pickup' => 'terminal'],
                    ['name' => 'Annapurna Safari Fleets', 'rating' => 9.3, 'pickup' => 'terminal'],
                ],
            ],
        ];

        $offers = [];
        $offerCounter = 1;

        foreach ($vehicleTemplates as $template) {
            foreach ($template['suppliers'] as $supplier) {
                // Generate slight price variance per supplier
                $multiplier = match ($supplier['name']) {
                    'Everest Tour Fleet' => 0.95,
                    'Nepal Overland Express' => 0.98,
                    'Kathmandu Wheels' => 1.0,
                    'Pokhara Drive Co.' => 1.02,
                    'Annapurna Safari Fleets' => 1.04,
                    'Himalayan Car Rental' => 1.06,
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
                    depositMinor: 200000, // Rs. 2,000 security deposit
                    deepLinkUrl: "https://demo-booking.hahakar.com/checkout?offer_id={$externalId}",
                    expiresAt: Carbon::now()->addHours(2),
                    isSponsored: ($offerCounter === 1)
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
        $baseUrl = "https://demo-booking.hahakar.com/reserve";
        $params = [
            'offer_id' => $offer->external_offer_id,
            'vehicle' => $offer->vehicle_name,
            'supplier' => $offer->supplier_name,
            'pickup' => $offer->search->pickupLocation->iata_code ?? $offer->search->pickupLocation->city,
            'from' => $offer->search->pickup_datetime->format('Y-m-d_H:i'),
            'to' => $offer->search->dropoff_datetime->format('Y-m-d_H:i'),
            'sub_id' => $attribution->subId ?? 'hahakar_web',
            'utm_source' => $attribution->utmSource ?? 'hahakar',
            'utm_medium' => $attribution->utmMedium ?? 'direct',
            'utm_campaign' => $attribution->utmCampaign ?? 'nepal_rentals',
        ];

        return $baseUrl . '?' . http_build_query($params);
    }

    public function healthCheck(): ProviderHealth
    {
        return new ProviderHealth(
            status: 'healthy',
            latencyMs: 35,
            message: 'Nepal Fleet Provider Engine responsive'
        );
    }
}
