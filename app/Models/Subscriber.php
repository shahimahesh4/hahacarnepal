<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'locale',
        'source',
        'consent_version',
        'status',
        'verification_token_hash',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];
}
