<?php

namespace App\Domain\Providers\DTOs;

class ProviderHealth
{
    public function __construct(
        public string $status, // healthy, degraded, down
        public int $latencyMs,
        public ?string $message = null
    ) {}

    public function isHealthy(): bool
    {
        return $this->status === 'healthy';
    }
}
