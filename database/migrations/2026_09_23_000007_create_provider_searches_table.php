<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_searches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('search_id')->constrained('searches')->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('providers')->cascadeOnDelete();
            $table->string('request_hash', 64)->nullable();
            $table->string('status')->default('success'); // success, timeout, error
            $table->integer('latency_ms')->default(0);
            $table->integer('http_status')->nullable();
            $table->text('error_message')->nullable();
            $table->integer('result_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_searches');
    }
};
