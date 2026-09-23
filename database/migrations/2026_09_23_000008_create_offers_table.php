<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('search_id')->constrained('searches')->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('providers')->cascadeOnDelete();
            $table->string('external_offer_id');
            $table->string('fingerprint', 64)->index();
            $table->foreignId('vehicle_category_id')->constrained('vehicle_categories');
            $table->string('vehicle_name');
            $table->text('vehicle_image_url')->nullable();
            $table->string('vehicle_group')->nullable();
            $table->string('transmission')->default('automatic'); // automatic, manual
            $table->integer('seats')->default(5);
            $table->integer('doors')->default(4);
            $table->integer('bags')->default(2);
            $table->boolean('has_ac')->default(true);
            $table->string('supplier_name');
            $table->text('supplier_logo_url')->nullable();
            $table->decimal('supplier_rating', 3, 1)->default(8.5);
            $table->string('pickup_type')->default('terminal'); // terminal, shuttle, meet_greet
            $table->string('pickup_location_name')->nullable();
            $table->integer('total_price_minor'); // in minor currency units, cents
            $table->integer('daily_price_minor');
            $table->string('currency', 3)->default('USD');
            $table->integer('original_total_price_minor');
            $table->string('original_currency', 3)->default('USD');
            $table->decimal('exchange_rate', 10, 4)->default(1.0000);
            $table->boolean('tax_included')->default(true);
            $table->boolean('fees_included')->default(true);
            $table->string('mileage_policy')->default('unlimited'); // unlimited, limited
            $table->string('fuel_policy')->default('full_to_full'); // full_to_full, same_to_same, prepaid
            $table->string('cancellation_policy')->default('free_cancellation'); // free_cancellation, flexible, non_refundable
            $table->dateTime('cancellation_deadline')->nullable();
            $table->integer('deposit_minor')->default(20000); // 200.00
            $table->decimal('ranking_score', 8, 4)->default(0.0000)->index();
            $table->boolean('is_sponsored')->default(false)->index();
            $table->longText('deep_link_payload')->nullable();
            $table->dateTime('expires_at')->nullable()->index();
            $table->timestamps();

            $table->unique(['provider_id', 'external_offer_id', 'search_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
