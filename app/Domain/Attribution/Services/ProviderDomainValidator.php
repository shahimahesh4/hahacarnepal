<?php

namespace App\Domain\Attribution\Services;

use App\Models\Provider;

class ProviderDomainValidator
{
    /**
     * Default allowed hostnames for redirects across providers.
     */
    protected array $globalAllowedDomains = [
        'demo-booking.hahacar.com',
        'mock-partner.hahacar.local',
        'partner.therentalcars.test',
        'localhost',
        '127.0.0.1',
    ];

    public function isAllowed(string $url, ?Provider $provider = null): bool
    {
        $parsed = parse_url($url);
        $host = strtolower($parsed['host'] ?? '');

        if (empty($host)) {
            return false;
        }

        if (in_array($host, $this->globalAllowedDomains, true)) {
            return true;
        }

        if ($provider) {
            $credential = $provider->activeCredential;
            if ($credential && !empty($credential->allowed_domains)) {
                $allowed = array_map('strtolower', (array) $credential->allowed_domains);
                if (in_array($host, $allowed, true)) {
                    return true;
                }
            }
        }

        return false;
    }
}
