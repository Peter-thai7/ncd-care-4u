<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_point_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // ชื่อกฎ (เช่น บันทึกอาหาร, อ่านบทความ, แนะนำเพื่อน)
            $table->string('code', 255)->unique(); // รหัสกฎสำหรับอ้างอิงในโค้ด (เช่น DAILY_FOOD_LOG)
            $table->unsignedInteger('point_value')->default(0); // คะแนนที่ได้รับ
            $table->unsignedInteger('max_per_day')->nullable(); // จำกัดการได้คะแนนต่อวัน (null = ไม่จำกัด)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_point_rules');
    }
};