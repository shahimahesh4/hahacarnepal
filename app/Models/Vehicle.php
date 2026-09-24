<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_profile_id',
        'category',
        'make',
        'model',
        'year',
        'plate_number',
        'seating_capacity',
        'luggage_capacity',
        'transmission',
        'fuel_type',
        'has_ac',
        'has_4wd',
        'daily_rate',
        'rate_per_km',
        'provides_driver',
        'allows_self_drive',
        'vehicle_photo_path',
        'bluebook_photo_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'seating_capacity' => 'integer',
            'luggage_capacity' => 'integer',
            'has_ac' => 'boolean',
            'has_4wd' => 'boolean',
            'daily_rate' => 'integer',
            'rate_per_km' => 'integer',
            'provides_driver' => 'boolean',
            'allows_self_drive' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function driverProfile(): BelongsTo
    {
        return $this->belongsTo(DriverProfile::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getEffectiveRatePerKmAttribute(): int
    {
        if ($this->rate_per_km && $this->rate_per_km > 0) {
            return (int) $this->rate_per_km;
        }

        return \App\Domain\Pricing\Services\NepalDistanceService::getRatePerKmForFuelType($this->fuel_type ?? 'diesel');
    }

    public function getFormattedRatePerKmAttribute(): string
    {
        return 'Rs. ' . number_format($this->effective_rate_per_km) . '/km';
    }

    public function getFuelBadgeAttribute(): string
    {
        $fuel = strtolower($this->fuel_type ?? 'diesel');

        return match ($fuel) {
            'electric', 'ev' => '⚡ Electric EV',
            'petrol' => '⛽ Petrol',
            'diesel' => '🛢️ Diesel',
            'hybrid' => '🔋 Hybrid',
            default => ucfirst($fuel),
        };
    }

    public function calculatePriceForDistance(int $distanceKm): int
    {
        return max(1000, $this->effective_rate_per_km * max(1, $distanceKm));
    }

    public function getFormattedDailyRateAttribute(): string
    {
        return 'Rs. ' . number_format($this->daily_rate);
    }

    public function getTitleAttribute(): string
    {
        return "{$this->make} {$this->model}";
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'suv_4wd' => '4WD Mountain SUV',
            'compact_suv' => 'Compact SUV',
            'tourist_van' => 'Tourist Commuter Van',
            'sedan' => 'Comfort Sedan',
            'hatchback' => 'City Hatchback',
            'luxury_suv' => 'Premium Luxury 4WD',
            default => ucfirst(str_replace('_', ' ', $this->category)),
        };
    }
}
