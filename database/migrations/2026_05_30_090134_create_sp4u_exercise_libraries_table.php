<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sp4u_exercise_libraries', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255); // ชื่อท่าบริหาร
            $table->text('description')->nullable(); // วิธีทำ/ข้อควรระวัง
            $table->string('video_path')->nullable(); // Path วิดีโอคลิป (เก็บแบบ Relative Path)
            $table->string('thumbnail_path')->nullable(); // รูปปกคลิป
            $table->string('body_part', 100)->nullable(); // ส่วนของร่างกาย (เช่น Core, ขา, แขน)
            $table->string('difficulty_level', 50)->default('beginner'); // ระดับความยาก (beginner, intermediate, advanced)
            $table->boolean('is_active')->default(true); // สถานะเปิด/ปิด
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_exercise_libraries');
    }
};
