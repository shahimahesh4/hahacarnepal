<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference', 24)->unique();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->string('service_option')->default('with_driver'); // with_driver, self_drive
            $table->string('pickup_location');
            $table->string('return_location');
            $table->dateTime('pickup_date');
            $table->dateTime('return_date');
            $table->unsignedSmallInteger('total_days')->default(1);
            $table->unsignedInteger('daily_rate'); // In NPR Rs.
            $table->unsignedInteger('total_price'); // In NPR Rs.
            $table->string('status')->default('pending'); // pending, confirmed, active, completed, cancelled
            $table->string('payment_method')->default('cash'); // cash, esewa, khalti
            $table->string('payment_status')->default('pending'); // pending, paid
            $table->text('special_requests')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();

            $table->index('booking_reference');
            $table->index(['status', 'pickup_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
