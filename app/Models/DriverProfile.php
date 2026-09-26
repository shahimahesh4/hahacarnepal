<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class DriverProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'partner_type',
        'status',
        'province',
        'service_city',
        'service_area',
        'license_number',
        'license_photo_path',
        'bluebook_photo_path',
        'citizenship_photo_path',
        'passport_photo_path',
        'current_latitude',
        'current_longitude',
        'current_address',
        'is_online',
        'admin_notes',
        'rating',
        'total_bookings',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'is_online' => 'boolean',
            'current_latitude' => 'decimal:7',
            'current_longitude' => 'decimal:7',
            'rating' => 'decimal:2',
            'total_bookings' => 'integer',
            'verified_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('status', 'verified');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
