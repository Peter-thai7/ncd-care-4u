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
        Schema::create('sp4u_testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete(); // คนไข้ที่รีวิว (ถ้ามี, ช่วงแรกอาจเป็น null เพราะแอดมินเพิ่มเอง)
            $table->string('reviewer_name', 255); // ชื่อผู้รีวิว (แอดมินกรอกให้ได้ หรือดึงจากคนไข้)
            $table->string('reviewer_photo_path')->nullable(); // รูปผู้รีวิว (Relative Path)
            $table->text('quote'); // ข้อความรีวิว
            $table->unsignedTinyInteger('rating')->nullable(); // คะแนนดาว (1-5)
            $table->string('status', 20)->default('pending'); // สถานะ (pending=รออนุมัติ, approved=แสดงผล, rejected=ซ่อน)
            $table->unsignedInteger('sort_order')->default(0); // ลำดับการแสดงผล (Drag Reorder)
            $table->boolean('is_active')->default(true); // เปิด/ปิดการแสดงผลรายการนี้ (Toggle On/Off สำหรับแอดมิน)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_testimonials');
    }
};
