<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('point_rule_id')->nullable()->constrained('sp4u_point_rules')->nullOnDelete(); // ได้จากกฎไหน (ถ้าเป็นการใช้คะแนนจะเป็น null)
            $table->integer('amount'); // จำนวนคะแนน (บวก = รับ, ลบ = ใช้)
            $table->unsignedInteger('balance_after')->default(0); // ยอดคงเหลือหลังทำรายการ
            $table->string('type', 50); // ประเภท (earn, spend, adjust, expire)
            $table->string('description', 255)->nullable(); // รายละเอียดเพิ่มเติม
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_point_transactions');
    }
};