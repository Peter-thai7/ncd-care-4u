<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_thread_id')->constrained('sp4u_chat_threads')->cascadeOnDelete();
            $table->foreignId('sender_user_id')->nullable()->constrained('users')->nullOnDelete(); // ผู้ส่ง (null ถ้าเป็นระบบ/Bot)
            $table->string('message_type', 50)->default('text'); // ประเภท (text, image, file, system)
            $table->longText('body')->nullable(); // ข้อความ
            $table->string('file_path')->nullable(); // ไฟล์แนบ (Relative Path)
            $table->boolean('is_read')->default(false); // อ่านแล้วหรือยัง
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_chat_messages');
    }
};