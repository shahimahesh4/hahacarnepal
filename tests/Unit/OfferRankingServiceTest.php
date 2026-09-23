<?php

namespace Tests\Unit;

use App\Domain\Offers\Ranking\OfferRankingService;
use App\Domain\Providers\DTOs\NormalizedOffer;
use PHPUnit\Framework\TestCase;

class OfferRankingServiceTest extends TestCase
{
    public function test_ranking_scores_are_calculated_correctly(): void
    {
        $rankingService = new OfferRankingService();

        $cheapOffer = new NormalizedOffer(
            externalOfferId: 'OFFER_1',
            vehicleCategoryCode: 'ECONOMY',
            vehicleName: 'Toyota Yaris',
            vehicleImageUrl: null,
            vehicleGroup: 'ECONOMY',
            transmission: 'automatic',
            seats: 5,
            doors: 4,
            bags: 2,
            hasAc: true,
            supplierName: 'Enterprise',
            supplierLogoUrl: null,
            supplierRating: 9.0,
            pickupType: 'terminal',
            pickupLocationName: 'Kathmandu Airport',
            totalPriceMinor: 10000, // $100
            dailyPriceMinor: 2500,
            taxIncluded: true,
            feesIncluded: true,
            mileagePolicy: 'unlimited',
            fuelPolicy: 'full_to_full',
            cancellationPolicy: 'free_cancellation'
        );

        $expensiveOffer = new NormalizedOffer(
            externalOfferId: 'OFFER_2',
            vehicleCategoryCode: 'ECONOMY',
            vehicleName: 'Toyota Yaris',
            vehicleImageUrl: null,
            vehicleGroup: 'ECONOMY',
            transmission: 'automatic',
            seats: 5,
            doors: 4,
            bags: 2,
            hasAc: true,
            supplierName: 'Budget',
            supplierLogoUrl: null,
            supplierRating: 7.5,
            pickupType: 'shuttle',
            pickupLocationName: 'Kathmandu Airport',
            totalPriceMinor: 20000, // $200
            dailyPriceMinor: 5000,
            taxIncluded: true,
            feesIncluded: true,
            mileagePolicy: 'limited',
            fuelPolicy: 'full_to_full',
            cancellationPolicy: 'non_refundable'
        );

        $scores = $rankingService->rank([$cheapOffer, $expensiveOffer]);

        $this->assertArrayHasKey('OFFER_1', $scores);
        $this->assertArrayHasKey('OFFER_2', $scores);
        $this->assertGreaterThan($scores['OFFER_2'], $scores['OFFER_1']);
    }
}
