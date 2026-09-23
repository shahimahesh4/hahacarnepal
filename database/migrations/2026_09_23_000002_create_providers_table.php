<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('adapter_class');
            $table->string('status')->default('active'); // active, inactive, maintenance
            $table->integer('priority')->default(10);
            $table->integer('timeout_ms')->default(3000);
            $table->string('commission_model')->default('cpc'); // cpc, cpa, hybrid
            $table->boolean('is_active')->default(true)->index();
            $table->string('last_health_state')->default('healthy'); // healthy, degraded, down
            $table->timestamp('last_health_check_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
