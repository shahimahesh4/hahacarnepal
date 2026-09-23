<?php

namespace App\Domain\Providers\Contracts;

use App\Domain\Providers\DTOs\AttributionData;
use App\Domain\Providers\DTOs\NormalizedOffer;
use App\Domain\Providers\DTOs\ProviderHealth;
use App\Domain\Providers\DTOs\ProviderSearchResult;
use App\Domain\Search\Data\SearchCriteria;
use App\Models\Offer;

interface CarRentalProvider
{
    /**
     * Fetch real-time or sandbox car-rental offers matching criteria.
     */
    public function search(SearchCriteria $criteria): ProviderSearchResult;

    /**
     * Refresh a specific offer to check if it is still available and current price.
     */
    public function refresh(string $providerOfferId, SearchCriteria $criteria): ?NormalizedOffer;

    /**
     * Build the safe outbound affiliate referral URL with tracking sub-IDs.
     */
    public function buildRedirectUrl(Offer $offer, AttributionData $attribution): string;

    /**
     * Perform an active health and latency check.
     */
    public function healthCheck(): ProviderHealth;
}
