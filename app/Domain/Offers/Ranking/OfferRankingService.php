<?php

namespace App\Domain\Offers\Ranking;

use App\Domain\Providers\DTOs\NormalizedOffer;

class OfferRankingService
{
    /**
     * Calculate and assign ranking scores to an array of normalized offers.
     *
     * @param NormalizedOffer[] $offers
     * @return array<string, float> Map of externalOfferId => rankingScore (0.0 to 100.0)
     */
    public function rank(array $offers): array
    {
        if (empty($offers)) {
            return [];
        }

        $minPrice = PHP_INT_MAX;
        $maxPrice = 0;

        foreach ($offers as $offer) {
            if ($offer->totalPriceMinor < $minPrice) {
                $minPrice = $offer->totalPriceMinor;
            }
            if ($offer->totalPriceMinor > $maxPrice) {
                $maxPrice = $offer->totalPriceMinor;
            }
        }

        $scores = [];

        foreach ($offers as $offer) {
            // 1. Price score (0 to 100) - lowest price gets 100
            $priceScore = 100.0;
            if ($maxPrice > $minPrice) {
                $priceScore = (1.0 - (($offer->totalPriceMinor - $minPrice) / ($maxPrice - $minPrice))) * 100.0;
            }

            // 2. Terms completeness (0 to 100)
            $termsScore = 0.0;
            if (!empty($offer->mileagePolicy)) $termsScore += 20.0;
            if (!empty($offer->fuelPolicy)) $termsScore += 20.0;
            if ($offer->depositMinor >= 0) $termsScore += 20.0;
            if ($offer->taxIncluded) $termsScore += 20.0;
            if ($offer->feesIncluded) $termsScore += 20.0;

            // 3. Supplier quality (0 to 100)
            $supplierScore = min(100.0, max(0.0, ($offer->supplierRating / 10.0) * 100.0));

            // 4. Cancellation flexibility (0 to 100)
            $cancellationScore = match ($offer->cancellationPolicy) {
                'free_cancellation' => 100.0,
                'flexible' => 70.0,
                default => 30.0,
            };

            // 5. Freshness (0 to 100)
            $freshnessScore = 100.0;

            // 6. Capped commercial adjustment (0 to 100, capped at 5% of total score)
            $commercialAdjustment = $offer->isSponsored ? 100.0 : 0.0;

            // Formula: 0.45 price + 0.15 terms + 0.15 supplier + 0.10 cancellation + 0.10 freshness + 0.05 commercial
            $finalScore = (0.45 * $priceScore)
                + (0.15 * $termsScore)
                + (0.15 * $supplierScore)
                + (0.10 * $cancellationScore)
                + (0.10 * $freshnessScore)
                + (0.05 * $commercialAdjustment);

            $scores[$offer->externalOfferId] = round($finalScore, 4);
        }

        return $scores;
    }
}
