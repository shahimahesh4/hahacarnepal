<?php

namespace Database\Seeders;

use App\Domain\Providers\Adapters\MockCarRentalProvider;
use App\Models\Provider;
use App\Models\ProviderCredential;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        $provider = Provider::updateOrCreate(
            ['slug' => 'hahacar-mock'],
            [
                'name' => 'Hahacar Global Rental Network',
                'adapter_class' => MockCarRentalProvider::class,
                'status' => 'active',
                'priority' => 1,
                'timeout_ms' => 3000,
                'commission_model' => 'cpc',
                'is_active' => true,
                'last_health_state' => 'healthy',
                'last_health_check_at' => now(),
            ]
        );

        ProviderCredential::updateOrCreate(
            ['provider_id' => $provider->id, 'environment' => 'sandbox'],
            [
                'api_key' => encrypt('mock_api_key_8923487293'),
                'api_secret' => encrypt('mock_secret_98234789234'),
                'endpoint_url' => 'https://sandbox-api.hahacar.local/v1',
                'allowed_domains' => [
                    'demo-booking.hahacar.com',
                    'mock-partner.hahacar.local',
                    'partner.therentalcars.test',
                    'localhost',
                    '127.0.0.1',
                ],
                'config' => [
                    'default_currency' => 'USD',
                    'cache_ttl_minutes' => 30,
                    'enable_sandbox_jitter' => true,
                ],
                'rotated_at' => now(),
            ]
        );
    }
}
