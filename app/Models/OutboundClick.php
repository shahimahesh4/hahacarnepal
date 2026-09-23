<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutboundClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'search_id',
        'offer_id',
        'provider_id',
        'session_id',
        'user_id',
        'sub_id',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'referrer',
        'device_type',
        'ip_hash',
        'user_agent_hash',
        'target_url',
        'clicked_at',
    ];

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function search(): BelongsTo
    {
        return $this->belongsTo(Search::class);
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
