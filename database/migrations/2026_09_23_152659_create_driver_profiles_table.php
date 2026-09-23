<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('partner_type')->default('vehicle_owner'); // individual_driver, vehicle_owner, fleet_operator
            $table->string('status')->default('pending'); // pending, verified, rejected, suspended
            $table->string('service_city')->default('Kathmandu');
            $table->string('service_area')->nullable();
            $table->string('license_number')->nullable();
            $table->string('license_photo_path')->nullable();
            $table->string('bluebook_photo_path')->nullable();
            $table->string('citizenship_photo_path')->nullable();
            $table->decimal('current_latitude', 10, 7)->nullable();
            $table->decimal('current_longitude', 10, 7)->nullable();
            $table->string('current_address')->nullable();
            $table->boolean('is_online')->default(false);
            $table->text('admin_notes')->nullable();
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->unsignedInteger('total_bookings')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'service_city']);
            $table->index('is_online');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_profiles');
    }
};
