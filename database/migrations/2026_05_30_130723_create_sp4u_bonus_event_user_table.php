<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_bonus_event_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bonus_event_id')->constrained('sp4u_bonus_events')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_completed')->default(false); //ทำภารกิจเสร็จหรือยัง
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // ป้องกันคนไข้เข้าร่วมอีเวนต์เดิมซ้ำ
            $table->unique(['bonus_event_id', 'user_id'], 'bonus_event_user_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_bonus_event_user');
    }
};