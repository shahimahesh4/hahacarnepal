<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // MINI, ECONOMY, COMPACT, INTERMEDIATE, STANDARD, FULLSIZE, SUV, VAN, LUXURY
            $table->string('name');
            $table->string('sipp_code', 10)->default('EDMR');
            $table->integer('default_seats')->default(5);
            $table->integer('default_bags')->default(2);
            $table->integer('default_doors')->default(4);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_categories');
    }
};
