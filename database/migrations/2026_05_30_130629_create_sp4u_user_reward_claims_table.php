<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_user_reward_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reward_tier_id')->constrained('sp4u_reward_tiers')->cascadeOnDelete();
            $table->unsignedInteger('points_spent'); // คะแนนที่ถูกหักไปตอนแลก
            $table->string('status', 20)->default('pending'); // สถานะ (pending, approved, shipped, cancelled)
            $table->timestamp('claimed_at')->nullable(); // เวลาที่แลก
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_user_reward_claims');
    }
};