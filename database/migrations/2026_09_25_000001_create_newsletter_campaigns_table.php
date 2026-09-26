<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subject');
            $table->string('preview_text')->nullable();
            $table->string('badge_text')->nullable();
            $table->string('headline')->nullable();
            $table->string('banner_image_url')->nullable();
            $table->longText('content');
            
            // Featured Offer / Service Box
            $table->string('featured_offer_title')->nullable();
            $table->string('featured_offer_price')->nullable();
            $table->string('featured_offer_badge')->nullable();
            $table->text('featured_offer_description')->nullable();
            
            // Call to Action
            $table->string('cta_text')->nullable()->default('Explore Nepal Rentals');
            $table->string('cta_url')->nullable()->default(config('app.url', 'https://hahakar.com'));
            
            // Audience & Delivery
            $table->string('target_audience')->default('all_subscribers');
            $table->json('manual_recipients')->nullable();
            $table->string('status')->default('draft'); // draft, sending, sent, failed
            
            $table->unsignedInteger('total_recipients')->default(0);
            $table->unsignedInteger('successful_sends')->default(0);
            $table->unsignedInteger('failed_sends')->default(0);
            $table->dateTime('sent_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_campaigns');
    }
};
