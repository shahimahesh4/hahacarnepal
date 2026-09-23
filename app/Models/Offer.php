<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'search_id',
        'provider_id',
        'external_offer_id',
        'fingerprint',
        'vehicle_category_id',
        'vehicle_name',
        'vehicle_image_url',
        'vehicle_group',
        'transmission',
        'seats',
        'doors',
        'bags',
        'has_ac',
        'supplier_name',
        'supplier_logo_url',
        'supplier_rating',
        'pickup_type',
        'pickup_location_name',
        'total_price_minor',
        'daily_price_minor',
        'currency',
        'original_total_price_minor',
        'original_currency',
        'exchange_rate',
        'tax_included',
        'fees_included',
        'mileage_policy',
        'fuel_policy',
        'cancellation_policy',
        'cancellation_deadline',
        'deposit_minor',
        'ranking_score',
        'is_sponsored',
        'deep_link_payload',
        'expires_at',
    ];

    protected $casts = [
        'has_ac' => 'boolean',
        'tax_included' => 'boolean',
        'fees_included' => 'boolean',
        'is_sponsored' => 'boolean',
        'total_price_minor' => 'integer',
        'daily_price_minor' => 'integer',
        'original_total_price_minor' => 'integer',
        'deposit_minor' => 'integer',
        'supplier_rating' => 'decimal:1',
        'exchange_rate' => 'decimal:4',
        'ranking_score' => 'decimal:4',
        'cancellation_deadline' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function search(): BelongsTo
    {
        return $this->belongsTo(Search::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function vehicleCategory(): BelongsTo
    {
        return $this->belongsTo(VehicleCategory::class);
    }

    public function outboundClicks(): HasMany
    {
        return $this->hasMany(OutboundClick::class);
    }

    public function getTotalPriceFormattedAttribute(): string
    {
        if ($this->currency === 'NPR') {
            return 'Rs. ' . number_format($this->total_price_minor / 100);
        }
        return '$' . number_format($this->total_price_minor / 100, 2);
    }

    public function getDailyPriceFormattedAttribute(): string
    {
        if ($this->currency === 'NPR') {
            return 'Rs. ' . number_format($this->daily_price_minor / 100);
        }
        return '$' . number_format($this->daily_price_minor / 100, 2);
    }

    public function getDepositFormattedAttribute(): string
    {
        if ($this->currency === 'NPR') {
            return 'Rs. ' . number_format($this->deposit_minor / 100);
        }
        return '$' . number_format($this->deposit_minor / 100, 2);
    }
}
