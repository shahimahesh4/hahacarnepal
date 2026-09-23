<?php

namespace App\Domain\Providers\DTOs;

class ProviderSearchResult
{
    /**
     * @param NormalizedOffer[] $offers
     */
    public function __construct(
        public bool $success,
        public array $offers = [],
        public int $latencyMs = 0,
        public ?int $httpStatus = 200,
        public ?string $errorMessage = null
    ) {}
}
