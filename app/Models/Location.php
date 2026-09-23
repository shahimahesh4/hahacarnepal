<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'iata_code',
        'city',
        'country',
        'country_code',
        'latitude',
        'longitude',
        'timezone',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function providerLocations(): HasMany
    {
        return $this->hasMany(ProviderLocation::class);
    }

    public function pickupSearches(): HasMany
    {
        return $this->hasMany(Search::class, 'pickup_location_id');
    }

    public function dropoffSearches(): HasMany
    {
        return $this->hasMany(Search::class, 'dropoff_location_id');
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->iata_code ? "{$this->city} ({$this->iata_code}) - {$this->name}" : "{$this->city} - {$this->name}";
    }
}
