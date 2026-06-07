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
        Schema::create('sp4u_form_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_tab_id')->constrained('sp4u_package_tabs')->cascadeOnDelete();
            $table->text('question_text'); // ข้อความคำถาม
            $table->string('input_type', 50); // ประเภทคำตอบ (text, number, radio, checkbox, slider, textarea)
            $table->json('configuration')->nullable(); // เก็บ config เพิ่มเติม เช่น {"min": 0, "max": 500, "step": 10}
            $table->string('unit', 50)->nullable(); // หน่วย (เช่น mg/dL, ครั้ง, นาที)
            $table->boolean('is_required')->default(false); // จำเป็นต้องตอบไหม
            $table->unsignedInteger('sort_order')->default(0); // ลำดับคำถาม
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_form_questions');
    }
};
