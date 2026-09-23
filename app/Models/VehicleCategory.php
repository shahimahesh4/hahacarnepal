<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'sipp_code',
        'default_seats',
        'default_bags',
        'default_doors',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'default_seats' => 'integer',
        'default_bags' => 'integer',
        'default_doors' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }
}
