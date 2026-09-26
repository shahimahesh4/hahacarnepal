<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('identifier')->index(); // email or phone number
            $table->string('type')->default('email'); // 'email' or 'phone'
            $table->string('action')->default('login'); // 'login', 'register', 'password_reset'
            $table->string('otp_code', 20);
            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();
            $table->unsignedSmallInteger('attempts')->default(0);
            $table->string('ip_address', 45)->nullable();
            $table->json('meta')->nullable(); // Store temporary registration payload
            $table->timestamps();

            $table->index(['identifier', 'action', 'type']);
        });

        if (!Schema::hasColumn('users', 'phone_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('otps');

        if (Schema::hasColumn('users', 'phone_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('phone_verified_at');
            });
        }
    }
};
