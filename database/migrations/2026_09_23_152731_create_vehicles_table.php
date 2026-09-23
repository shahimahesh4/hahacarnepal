<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_profile_id')->constrained()->cascadeOnDelete();
            $table->string('category')->default('suv_4wd'); // suv_4wd, compact_suv, sedan, hatchback, tourist_van, luxury_suv
            $table->string('make');
            $table->string('model');
            $table->unsignedSmallInteger('year')->default(2023);
            $table->string('plate_number')->unique();
            $table->unsignedTinyInteger('seating_capacity')->default(5);
            $table->unsignedTinyInteger('luggage_capacity')->default(2);
            $table->string('transmission')->default('manual'); // manual, automatic
            $table->string('fuel_type')->default('diesel'); // diesel, petrol, electric, hybrid
            $table->boolean('has_ac')->default(true);
            $table->boolean('has_4wd')->default(false);
            $table->unsignedInteger('daily_rate')->default(3500); // In NPR Rs. (e.g. 3500, 4500)
            $table->boolean('provides_driver')->default(true);
            $table->boolean('allows_self_drive')->default(true);
            $table->string('vehicle_photo_path')->nullable();
            $table->string('bluebook_photo_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'is_active']);
            $table->index('daily_rate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
