<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_user_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete(); // 1 คนมีได้ 1 แถวสรุป
            $table->unsignedInteger('total_points')->default(0); // คะแนนสะสมคงเหลือ
            $table->unsignedInteger('total_earned')->default(0); // คะแนนรวมที่เคยได้ (ไว้ทำระดับสมาชิก)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_user_points');
    }
};