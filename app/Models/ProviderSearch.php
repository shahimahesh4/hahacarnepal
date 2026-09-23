<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'search_id',
        'provider_id',
        'request_hash',
        'status',
        'latency_ms',
        'http_status',
        'error_message',
        'result_count',
    ];

    protected $casts = [
        'latency_ms' => 'integer',
        'http_status' => 'integer',
        'result_count' => 'integer',
    ];

    public function search(): BelongsTo
    {
        return $this->belongsTo(Search::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
