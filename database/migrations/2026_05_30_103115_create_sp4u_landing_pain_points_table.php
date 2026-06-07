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
        Schema::create('sp4u_landing_pain_points', function (Blueprint $table) {
            $table->id();
            $table->string('icon', 255)->nullable(); // ไอคอนประกอบ (เช่น SVG หรือชื่อ Emoji)
            $table->string('title', 255); // หัวข้อจุดปวด (เช่น "เบาหวานคุมไม่อยู่")
            $table->text('description')->nullable(); // รายละเอียดเพิ่มเติม
            $table->unsignedInteger('sort_order')->default(0); // ลำดับการแสดงผล (Drag Reorder)
            $table->boolean('is_active')->default(true); // เปิด/ปิดการแสดงผลรายการนี้ (Toggle On/Off)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_landing_pain_points');
    }
};
