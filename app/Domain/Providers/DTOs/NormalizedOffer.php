<?php

namespace App\Domain\Providers\DTOs;

use Carbon\Carbon;

class NormalizedOffer
{
    public function __construct(
        public string $externalOfferId,
        public string $vehicleCategoryCode,
        public string $vehicleName,
        public ?string $vehicleImageUrl,
        public ?string $vehicleGroup,
        public string $transmission, // automatic, manual
        public int $seats,
        public int $doors,
        public int $bags,
        public bool $hasAc,
        public string $supplierName,
        public ?string $supplierLogoUrl,
        public float $supplierRating,
        public string $pickupType, // terminal, shuttle, meet_greet
        public ?string $pickupLocationName,
        public int $totalPriceMinor,
        public int $dailyPriceMinor,
        public string $currency = 'USD',
        public int $originalTotalPriceMinor = 0,
        public string $originalCurrency = 'USD',
        public float $exchangeRate = 1.0,
        public bool $taxIncluded = true,
        public bool $feesIncluded = true,
        public string $mileagePolicy = 'unlimited', // unlimited, limited
        public string $fuelPolicy = 'full_to_full', // full_to_full, same_to_same, prepaid
        public string $cancellationPolicy = 'free_cancellation', // free_cancellation, flexible, non_refundable
        public ?Carbon $cancellationDeadline = null,
        public int $depositMinor = 20000,
        public ?string $deepLinkUrl = null,
        public ?Carbon $expiresAt = null,
        public bool $isSponsored = false
    ) {}

    public function calculateFingerprint(int $locationId): string
    {
        $priceBand = (int) round($this->totalPriceMinor / 1000); // 10-dollar bins
        $parts = [
            strtolower($this->supplierName),
            $locationId,
            strtoupper($this->vehicleCategoryCode),
            strtolower($this->transmission),
            strtolower($this->mileagePolicy),
            strtolower($this->fuelPolicy),
            strtolower($this->cancellationPolicy),
            $priceBand,
        ];

        return hash('sha256', implode('|', $parts));
    }
}
