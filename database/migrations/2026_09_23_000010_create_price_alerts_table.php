<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_alerts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('email')->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('pickup_location_id')->constrained('locations');
            $table->foreignId('dropoff_location_id')->constrained('locations');
            $table->dateTime('pickup_datetime');
            $table->dateTime('dropoff_datetime');
            $table->string('criteria_hash', 64)->index();
            $table->string('currency', 3)->default('USD');
            $table->string('threshold_type')->default('any_drop'); // any_drop, percentage, fixed_amount
            $table->decimal('threshold_value', 8, 2)->default(0.00);
            $table->string('frequency')->default('daily'); // real_time, daily
            $table->integer('last_best_price_minor')->nullable();
            $table->string('status')->default('pending_confirmation')->index(); // pending_confirmation, active, paused, unsubscribed, expired
            $table->string('verify_token_hash', 64)->nullable()->index();
            $table->string('manage_token_hash', 64)->nullable()->index();
            $table->string('consent_version', 20)->default('v1.0');
            $table->dateTime('consented_at')->nullable();
            $table->dateTime('last_checked_at')->nullable();
            $table->dateTime('last_notified_at')->nullable();
            $table->dateTime('next_check_at')->nullable()->index();
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_alerts');
    }
};
