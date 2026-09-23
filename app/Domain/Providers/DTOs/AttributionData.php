<?php

namespace App\Domain\Providers\DTOs;

class AttributionData
{
    public function __construct(
        public ?string $subId = null,
        public ?string $utmSource = null,
        public ?string $utmMedium = null,
        public ?string $utmCampaign = null,
        public ?string $sessionId = null,
        public ?string $referrer = null
    ) {}
}
