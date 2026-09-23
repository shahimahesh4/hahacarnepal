<?php

namespace App\Domain\Search\Data;

use App\Models\Location;
use Carbon\Carbon;

class SearchCriteria
{
    public function __construct(
        public Location $pickupLocation,
        public Location $dropoffLocation,
        public Carbon $pickupDatetime,
        public Carbon $dropoffDatetime,
        public int $driverAge = 30,
        public string $currency = 'NPR',
        public string $locale = 'en'
    ) {}

    public function hash(): string
    {
        $payload = [
            'pickup' => $this->pickupLocation->id,
            'dropoff' => $this->dropoffLocation->id,
            'pickup_datetime' => $this->pickupDatetime->format('Y-m-d H:i'),
            'dropoff_datetime' => $this->dropoffDatetime->format('Y-m-d H:i'),
            'driver_age' => $this->driverAge,
            'currency' => strtoupper($this->currency),
        ];

        return hash('sha256', json_encode($payload));
    }

    public function rentalDays(): int
    {
        $hours = $this->pickupDatetime->diffInHours($this->dropoffDatetime);
        return max(1, (int) ceil($hours / 24));
    }
}
