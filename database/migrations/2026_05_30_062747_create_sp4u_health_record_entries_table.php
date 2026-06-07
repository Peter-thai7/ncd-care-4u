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
        Schema::create('sp4u_health_record_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_record_id')->constrained('sp4u_health_records')->cascadeOnDelete(); // ผูกกับ Record หลัก
            $table->foreignId('form_question_id')->constrained('sp4u_form_questions')->cascadeOnDelete(); // ตอบคำถามข้อไหน
            $table->foreignId('form_option_id')->nullable()->constrained('sp4u_form_options')->nullOnDelete(); // เลือกตัวเลือกไหน (ถ้าเป็น Radio/Checkbox)
            $table->text('answer_text')->nullable(); // คำตอบแบบข้อความ/ตัวเลข (ถ้าเป็น Text/Number/Slider)
            $table->string('triggered_alert_level', 20)->default('green'); // ระบบ Traffic Light ระดับคำตอบแต่ละข้อ (สำคัญมากสำหรับแจ้งเตือน)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_health_record_entries');
    }
};
