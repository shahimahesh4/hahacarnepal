<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PriceAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'email',
        'user_id',
        'pickup_location_id',
        'dropoff_location_id',
        'pickup_datetime',
        'dropoff_datetime',
        'criteria_hash',
        'currency',
        'threshold_type',
        'threshold_value',
        'frequency',
        'last_best_price_minor',
        'status',
        'verify_token_hash',
        'manage_token_hash',
        'consent_version',
        'consented_at',
        'last_checked_at',
        'last_notified_at',
        'next_check_at',
        'expires_at',
    ];

    protected $casts = [
        'pickup_datetime' => 'datetime',
        'dropoff_datetime' => 'datetime',
        'consented_at' => 'datetime',
        'last_checked_at' => 'datetime',
        'last_notified_at' => 'datetime',
        'next_check_at' => 'datetime',
        'expires_at' => 'datetime',
        'threshold_value' => 'decimal:2',
        'last_best_price_minor' => 'integer',
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

    public function runs(): HasMany
    {
        return $this->hasMany(PriceAlertRun::class);
    }

    public function getLastBestPriceFormattedAttribute(): ?string
    {
        if (!$this->last_best_price_minor) {
            return null;
        }

        if ($this->currency === 'NPR') {
            return 'Rs. ' . number_format($this->last_best_price_minor / 100);
        }

        return '$' . number_format($this->last_best_price_minor / 100, 2);
    }
}
