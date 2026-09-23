<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_alert_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_alert_id')->constrained('price_alerts')->cascadeOnDelete();
            $table->integer('previous_price_minor')->nullable();
            $table->integer('new_price_minor')->nullable();
            $table->string('decision'); // triggered, skipped_no_drop, skipped_cooldown, failed
            $table->string('status')->default('success'); // success, failed
            $table->text('error_details')->nullable();
            $table->dateTime('started_at');
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_alert_runs');
    }
};
