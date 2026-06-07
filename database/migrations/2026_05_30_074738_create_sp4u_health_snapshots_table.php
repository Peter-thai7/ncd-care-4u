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
        Schema::create('sp4u_health_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // คนไข้
            $table->foreignId('entered_by_user_id')->constrained('users'); // ใครเป็นคนบันทึก (รองรับ Collaborative)
            $table->date('snapshot_date'); // วันที่วัด/ชั่ง (อาจไม่ใช่วันนี้ อาจย้อนไปเมื่อวาน)
    
    // ค่าวัดร่างกาย (เอาไว้ทำกราฟเส้นและคำนวณ BMI อัตโนมัติ)
            $table->decimal('weight_kg', 8, 2)->nullable(); // น้ำหนัก (กก.)
            $table->decimal('height_cm', 8, 2)->nullable(); // ส่วนสูง (ซม.)
            $table->decimal('bmi', 8, 2)->nullable(); // ค่า BMI (คำนวณจากระบบ หรือกรอกเข้ามา)
            $table->decimal('waist_inches', 8, 2)->nullable(); // รอบเอว (นิ้ว)
    
    // ค่าวัดทางการแพทย์ที่ต้องกราฟบ่อยๆ
            $table->unsignedInteger('systolic_bp')->nullable(); // ความดันบน
            $table->unsignedInteger('diastolic_bp')->nullable(); // ความดันล่าง
            $table->decimal('fbs_mg_dl', 8, 2)->nullable(); // น้ำตาลสะสม/น้ำตาลอดอาหาร
    
            $table->text('notes')->nullable(); // หมายเหตุเพิ่มเติม
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_health_snapshots');
    }
};
