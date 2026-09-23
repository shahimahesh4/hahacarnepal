<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('providers')->cascadeOnDelete();
            $table->string('environment')->default('sandbox'); // sandbox, production
            $table->text('api_key')->nullable();
            $table->text('api_secret')->nullable();
            $table->string('endpoint_url')->nullable();
            $table->json('allowed_domains')->nullable();
            $table->json('config')->nullable();
            $table->timestamp('rotated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_credentials');
    }
};
