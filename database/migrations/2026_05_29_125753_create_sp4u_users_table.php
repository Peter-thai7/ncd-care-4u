<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->unique()->nullable();
            $table->string('line_id')->unique()->nullable();
            $table->timestamp('line_verified_at')->nullable();
            $table->string('referral_code')->unique()->nullable();
            $table->foreignId('referred_by_user_id')->nullable()->constrained('sp4u_users')->onDelete('set null');
            $table->enum('status', ['pending_verify', 'active', 'suspended'])->default('pending_verify');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_users');
    }
};