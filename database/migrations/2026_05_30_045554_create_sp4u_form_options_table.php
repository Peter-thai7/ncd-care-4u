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
        Schema::create('sp4u_form_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_question_id')->constrained('sp4u_form_questions')->cascadeOnDelete();
            $table->string('option_text', 255); // ข้อความตัวเลือก (เช่น ปวดน้อย, ปวดปานกลาง, ปวดมาก)
            $table->string('option_value', 255)->nullable(); // ค่าที่เก็บจริง (ถ้าต่างจากข้อความ)
            $table->string('alert_level', 20)->default('green'); // ระบบ Traffic Light (green, yellow, red)
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_form_options');
    }
};
