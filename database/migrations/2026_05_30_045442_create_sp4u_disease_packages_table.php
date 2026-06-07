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
        Schema::create('sp4u_disease_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // ชื่อแพ็กเกจ (เช่น เบาหวาน, ความดัน)
            $table->string('slug', 255)->unique(); // สำหรับทำ URL หรืออ้างอิง
            $table->text('description')->nullable(); // รายละเอียดแพ็กเกจ
            $table->string('icon')->nullable(); // ไอคอนแพ็กเกจ (เช่น SVG หรือชื่อ Icon)
            $table->string('color_code', 7)->default('#3B82F6'); // สีประจำแพ็กเกจ (รองรับ Traffic Light)
            $table->boolean('is_active')->default(true); // สถานะเปิด/ปิดการใช้งาน
            $table->timestamps();
            $table->softDeletes(); // ป้องกันการลบที่ทำให้ข้อมูลเดิมพัง
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_disease_packages');
    }
};
