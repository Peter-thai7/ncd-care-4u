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
        Schema::create('sp4u_user_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // คนไข้
            $table->foreignId('disease_package_id')->nullable()->constrained('sp4u_disease_packages')->cascadeOnDelete(); // ผูกกับแพ็กเกจโรค (หรือเป็นเป้าหมายรวม)
            $table->string('goal_name', 255); // ชื่อเป้าหมาย (เช่น ลดน้ำหนัก, ควบคุมน้ำตาล)
            $table->string('metric_type', 50); // ตัวชี้วัด (เช่น weight, fbs, waist)
            $table->decimal('start_value', 10, 2)->nullable(); // ค่าเริ่มต้น (จาก Baseline)
            $table->decimal('target_value', 10, 2); // เป้าหมายที่ตั้งไว้
            $table->string('unit', 50)->nullable(); // หน่วย (เช่น กก., mg/dL, นิ้ว)
            $table->date('start_date'); // วันเริ่มต้น
            $table->date('target_date'); // กำหนดถึงเมื่อไหร่
            $table->string('status', 20)->default('active'); // สถานะ (active, completed, failed)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_user_goals');
    }
};
