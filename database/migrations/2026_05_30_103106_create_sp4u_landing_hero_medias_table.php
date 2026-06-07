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
        Schema::create('sp4u_landing_hero_medias', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable(); // หัวข้อบน Banner
            $table->text('subtitle')->nullable(); // ข้อความรอง
            $table->string('media_type', 50)->default('image'); // ประเภท (image, video)
            $table->string('desktop_image_path')->nullable(); // รูป Desktop (Relative Path)
            $table->string('mobile_image_path')->nullable(); // รูป Mobile (Relative Path)
            $table->string('video_url')->nullable(); // URL วิดีโอ (.m3u8 หรือ YouTube)
            $table->string('button_text', 100)->nullable(); // ข้อความปุ่ม CTA (เช่น ปรึกษาเลย)
            $table->string('button_url')->nullable(); // ลิงก์ปุ่ม CTA
            $table->unsignedInteger('sort_order')->default(0); // ลำดับการแสดงผล (Drag Reorder)
            $table->boolean('is_active')->default(true); // เปิด/ปิดการแสดงผล (Toggle On/Off)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_landing_hero_medias');
    }
};
