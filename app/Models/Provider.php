<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'adapter_class',
        'status',
        'priority',
        'timeout_ms',
        'commission_model',
        'is_active',
        'last_health_state',
        'last_health_check_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_health_check_at' => 'datetime',
        'priority' => 'integer',
        'timeout_ms' => 'integer',
    ];

    public function credentials(): HasMany
    {
        return $this->hasMany(ProviderCredential::class);
    }

    public function activeCredential(): HasOne
    {
        return $this->hasOne(ProviderCredential::class)->latestOfMany();
    }

    public function providerLocations(): HasMany
    {
        return $this->hasMany(ProviderLocation::class);
    }

    public function providerSearches(): HasMany
    {
        return $this->hasMany(ProviderSearch::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function outboundClicks(): HasMany
    {
        return $this->hasMany(OutboundClick::class);
    }
}
