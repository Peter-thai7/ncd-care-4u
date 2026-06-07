<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_chatbot_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question_keywords', 255); // คำค้นหา/คำถาม (เช่น "ตรวจเลือด", "ความดันสูง")
            $table->longText('answer_text'); // คำตอบของ Chatbot
            $table->unsignedInteger('sort_order')->default(0); // ลำดับความสำคัญ/การแสดงผล
            $table->boolean('is_active')->default(true); // เปิด/ปิดคำถามนี้
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_chatbot_faqs');
    }
};