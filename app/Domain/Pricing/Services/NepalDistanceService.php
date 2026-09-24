<?php

namespace App\Domain\Pricing\Services;

use App\Models\Location;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NepalDistanceService
{
    /**
     * Known highway route distance matrix across major Nepal hubs (in Kilometers)
     */
    protected static array $routeDistanceMatrix = [
        'kathmandu_pokhara' => 200,
        'kathmandu_chitwan' => 155,
        'kathmandu_lumbini' => 290,
        'kathmandu_nagarkot' => 32,
        'kathmandu_bhaktapur' => 16,
        'kathmandu_dhulikhel' => 30,
        'kathmandu_biratnagar' => 380,
        'kathmandu_nepalgunj' => 520,
        'kathmandu_janakpur' => 225,
        'kathmandu_mustang' => 375,
        'pokhara_chitwan' => 145,
        'pokhara_lumbini' => 195,
        'pokhara_mustang' => 175,
        'pokhara_bandipur' => 75,
        'chitwan_lumbini' => 135,
        'chitwan_biratnagar' => 320,
        'lumbini_nepalgunj' => 230,
    ];

    /**
     * Get configured rate per KM for a fuel type from dynamic backend Settings.
     */
    public static function getRatePerKmForFuelType(string $fuelType): int
    {
        $normalized = strtolower(trim($fuelType));

        return match ($normalized) {
            'petrol' => (int) Setting::get('rate_per_km_petrol', 250),
            'diesel' => (int) Setting::get('rate_per_km_diesel', 250),
            'electric', 'ev' => (int) Setting::get('rate_per_km_electric', 70),
            'hybrid' => (int) Setting::get('rate_per_km_hybrid', 160),
            default => 250,
        };
    }

    /**
     * Estimate driving distance in kilometers between two locations or city names.
     */
    public static function estimateDistanceKm(string $pickup, string $dropoff): int
    {
        if (trim(strtolower($pickup)) === trim(strtolower($dropoff))) {
            return 50; // Local city day trips / sightseeing
        }

        $mode = Setting::get('location_provider_mode', 'manual');
        $apiKey = Setting::get('google_maps_api_key', '');

        // If Google Maps API mode is active and API key is present, attempt live Distance Matrix query
        if ($mode === 'google_maps' && !empty($apiKey)) {
            $googleKm = static::getGoogleDistanceMatrixKm($pickup, $dropoff, $apiKey);
            if ($googleKm !== null && $googleKm > 0) {
                return $googleKm;
            }
        }

        // Fallback to static Nepal distance matrix
        $pickupCity = static::extractCity($pickup);
        $dropoffCity = static::extractCity($dropoff);

        if ($pickupCity === $dropoffCity) {
            return 60; // Intra-city / valley touring
        }

        $key1 = "{$pickupCity}_{$dropoffCity}";
        $key2 = "{$dropoffCity}_{$pickupCity}";

        if (isset(static::$routeDistanceMatrix[$key1])) {
            return static::$routeDistanceMatrix[$key1];
        }

        if (isset(static::$routeDistanceMatrix[$key2])) {
            return static::$routeDistanceMatrix[$key2];
        }

        return 120; // Default estimate
    }

    /**
     * Query Google Maps Distance Matrix API in real-time
     */
    public static function getGoogleDistanceMatrixKm(string $origin, string $destination, string $apiKey): ?int
    {
        try {
            $response = Http::timeout(3)->get('https://maps.googleapis.com/maps/api/distancematrix/json', [
                'origins' => $origin . ', Nepal',
                'destinations' => $destination . ', Nepal',
                'key' => $apiKey,
                'units' => 'metric',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['rows'][0]['elements'][0]['status']) && $data['rows'][0]['elements'][0]['status'] === 'OK') {
                    $distanceMeters = $data['rows'][0]['elements'][0]['distance']['value'] ?? 0;
                    if ($distanceMeters > 0) {
                        return (int) round($distanceMeters / 1000);
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Google Distance Matrix API request failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Extract normalized city key from location string.
     */
    public static function extractCity(string $locationStr): string
    {
        $loc = strtolower($locationStr);

        if (str_contains($loc, 'kathmandu') || str_contains($loc, 'ktm') || str_contains($loc, 'thamel') || str_contains($loc, 'kalanki') || str_contains($loc, 'patan') || str_contains($loc, 'tribhuvan')) {
            return 'kathmandu';
        }
        if (str_contains($loc, 'pokhara') || str_contains($loc, 'pkr') || str_contains($loc, 'lakeside')) {
            return 'pokhara';
        }
        if (str_contains($loc, 'chitwan') || str_contains($loc, 'bharatpur') || str_contains($loc, 'sauraha') || str_contains($loc, 'bhr')) {
            return 'chitwan';
        }
        if (str_contains($loc, 'lumbini') || str_contains($loc, 'bhairahawa') || str_contains($loc, 'bwa')) {
            return 'lumbini';
        }
        if (str_contains($loc, 'nagarkot')) {
            return 'nagarkot';
        }
        if (str_contains($loc, 'bhaktapur')) {
            return 'bhaktapur';
        }
        if (str_contains($loc, 'dhulikhel')) {
            return 'dhulikhel';
        }
        if (str_contains($loc, 'biratnagar') || str_contains($loc, 'bir')) {
            return 'biratnagar';
        }
        if (str_contains($loc, 'nepalgunj') || str_contains($loc, 'kep')) {
            return 'nepalgunj';
        }
        if (str_contains($loc, 'janakpur')) {
            return 'janakpur';
        }
        if (str_contains($loc, 'mustang') || str_contains($loc, 'jomsom') || str_contains($loc, 'muktinath')) {
            return 'mustang';
        }
        if (str_contains($loc, 'bandipur')) {
            return 'bandipur';
        }

        return preg_replace('/[^a-z0-9]/', '', $loc);
    }

    /**
     * Calculate price for distance trip vs daily rental
     */
    public static function calculateTripPrice(
        string $pricingType,
        int $dailyRate,
        int $totalDays,
        int $ratePerKm,
        int $distanceKm
    ): int {
        if ($pricingType === 'distance') {
            return max(1000, $ratePerKm * $distanceKm);
        }

        return max(1000, $dailyRate * $totalDays);
    }
}
