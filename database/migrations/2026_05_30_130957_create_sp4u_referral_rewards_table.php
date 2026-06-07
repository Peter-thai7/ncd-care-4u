<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_referral_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_user_id')->constrained('users')->cascadeOnDelete(); // คนแนะนำ
            $table->foreignId('referred_user_id')->constrained('users')->cascadeOnDelete(); // คนที่ถูกแนะนำ
            $table->unsignedInteger('points_awarded')->default(0); // คะแนนที่คนแนะนำได้รับ
            $table->string('status', 20)->default('pending'); // สถานะ (pending=รอเพื่อนสมัคร, awarded=จ่ายคะแนนแล้ว)
            $table->timestamp('awarded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_referral_rewards');
    }
};