<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'vehicle_id',
        'driver_profile_id',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'service_option',
        'pickup_location',
        'return_location',
        'pickup_date',
        'return_date',
        'total_days',
        'daily_rate',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'special_requests',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'pickup_date' => 'datetime',
            'return_date' => 'datetime',
            'total_days' => 'integer',
            'daily_rate' => 'integer',
            'total_price' => 'integer',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Booking $booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = 'HHC-BK-' . strtoupper(Str::random(6));
            }
        });
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driverProfile(): BelongsTo
    {
        return $this->belongsTo(DriverProfile::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function getFormattedDailyRateAttribute(): string
    {
        return 'Rs. ' . number_format($this->daily_rate);
    }

    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rs. ' . number_format($this->total_price);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
}
