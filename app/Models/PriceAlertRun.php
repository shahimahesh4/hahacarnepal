<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceAlertRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_alert_id',
        'previous_price_minor',
        'new_price_minor',
        'decision',
        'status',
        'error_details',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'previous_price_minor' => 'integer',
        'new_price_minor' => 'integer',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function priceAlert(): BelongsTo
    {
        return $this->belongsTo(PriceAlert::class);
    }
}
