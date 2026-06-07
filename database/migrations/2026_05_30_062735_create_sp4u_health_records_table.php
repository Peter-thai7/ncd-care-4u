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
        Schema::create('sp4u_health_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_package_id')->constrained('sp4u_user_packages')->cascadeOnDelete(); // ผูกกับแพ็กเกจที่คนไข้มี
            $table->foreignId('package_tab_id')->constrained('sp4u_package_tabs')->cascadeOnDelete(); // ผูกกับแท็บ/ฟอร์มไหน
            $table->foreignId('entered_by_user_id')->constrained('users'); // ใครเป็นคนกรอก (หมอ/พยาบาล/คนไข้เอง) -> รองรับระบบสีแยกแหล่งที่มา
            $table->timestamp('recorded_at')->nullable(); // เวลาที่บันทึกข้อมูลจริง (อาจจะไม่ใช่เวลาปัจจุบัน เช่น ย้อนบันทึกเมื่อวาน)
            $table->string('overall_alert_level', 20)->default('green'); // ระบบ Traffic Light ระดับ Record ทั้งก้อน
            $table->text('notes')->nullable(); // โน้ต/หมายเหตุเพิ่มเติม
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_health_records');
    }
};
