<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->unsignedInteger('rate_per_km')->nullable()->after('daily_rate');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('pricing_type')->default('daily')->after('service_option'); // daily, distance
            $table->unsignedInteger('estimated_distance_km')->nullable()->after('total_days');
            $table->unsignedInteger('rate_per_km')->nullable()->after('daily_rate');
            $table->string('fuel_type')->nullable()->after('rate_per_km');
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedInteger('rate_per_km_minor')->nullable()->after('daily_price_minor');
            $table->string('fuel_type')->nullable()->after('transmission');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('rate_per_km');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['pricing_type', 'estimated_distance_km', 'rate_per_km', 'fuel_type']);
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['rate_per_km_minor', 'fuel_type']);
        });
    }
};
