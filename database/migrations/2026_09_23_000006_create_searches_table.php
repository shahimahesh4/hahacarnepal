<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('searches', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('session_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('pickup_location_id')->constrained('locations');
            $table->foreignId('dropoff_location_id')->constrained('locations');
            $table->dateTime('pickup_datetime');
            $table->dateTime('dropoff_datetime');
            $table->integer('driver_age')->default(30);
            $table->string('currency', 3)->default('USD');
            $table->string('locale', 10)->default('en');
            $table->string('criteria_hash', 64)->index();
            $table->string('status')->default('completed'); // completed, partial, failed
            $table->integer('provider_count')->default(0);
            $table->integer('result_count')->default(0);
            $table->integer('duration_ms')->default(0);
            $table->json('attribution')->nullable();
            $table->dateTime('expires_at')->nullable()->index();
            $table->timestamps();

            $table->index(['created_at', 'status', 'criteria_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('searches');
    }
};
