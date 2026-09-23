<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'environment',
        'api_key',
        'api_secret',
        'endpoint_url',
        'allowed_domains',
        'config',
        'rotated_at',
    ];

    protected $casts = [
        'allowed_domains' => 'array',
        'config' => 'array',
        'rotated_at' => 'datetime',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
