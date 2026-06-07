<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_chat_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // คนไข้/ผู้ตั้ง Ticket
            $table->foreignId('assigned_to_user_id')->nullable()->constrained('users')->nullOnDelete(); // แอดมิน/หมอ ที่รับเรื่อง
            $table->string('subject', 255)->nullable(); // หัวข้อเรื่องที่ปรึกษา
            $table->string('status', 20)->default('open'); // สถานะ (open, pending, closed)
            $table->string('priority', 20)->default('normal'); // ความเร่งด่วน (normal, high, urgent)
            $table->string('channel', 50)->default('web'); // ช่องทาง (web, line, app)
            $table->string('line_user_id')->nullable(); // สำหรับเชื่อม Line@ API จับคู่ User อัตโนมัติ
            $table->timestamp('last_replied_at')->nullable(); // เวลาตอบล่าสุด (ไว้ทำ Sort หน้าแชท)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_chat_threads');
    }
};