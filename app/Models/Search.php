<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Search extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'session_id',
        'user_id',
        'pickup_location_id',
        'dropoff_location_id',
        'pickup_datetime',
        'dropoff_datetime',
        'driver_age',
        'currency',
        'locale',
        'criteria_hash',
        'status',
        'provider_count',
        'result_count',
        'duration_ms',
        'attribution',
        'expires_at',
    ];

    protected $casts = [
        'pickup_datetime' => 'datetime',
        'dropoff_datetime' => 'datetime',
        'expires_at' => 'datetime',
        'driver_age' => 'integer',
        'provider_count' => 'integer',
        'result_count' => 'integer',
        'duration_ms' => 'integer',
        'attribution' => 'array',
    ];

    public function pickupLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'pickup_location_id');
    }

    public function dropoffLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'dropoff_location_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    public function getRentalDurationDaysAttribute(): int
    {
        $hours = $this->pickup_datetime->diffInHours($this->dropoff_datetime);
        return max(1, (int) ceil($hours / 24));
    }
}
