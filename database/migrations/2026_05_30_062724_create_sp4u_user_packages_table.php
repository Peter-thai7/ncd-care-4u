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
        Schema::create('sp4u_user_packages', function (Blueprint $table) {
    
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // คนไข้
            $table->foreignId('disease_package_id')->constrained('sp4u_disease_packages')->cascadeOnDelete(); // แพ็กเกจโรค
            $table->foreignId('unlocked_by_user_id')->constrained('users')->cascadeOnDelete(); // แอดมิน/หมอ ที่เปิดให้
            $table->boolean('is_active')->default(true); // สถานะเปิด/ปิดการใช้งานแพ็กเกจนี้
            $table->timestamp('unlocked_at')->nullable(); // เวลาที่เปิดให้ใช้งาน
            $table->timestamps();
            $table->softDeletes();

    // ป้องกันการ Unlock แพ็กเกจเดิมซ้ำ (1 คนไข้ ต่อ 1 แพ็กเกจ มีได้แค่แถวเดียว)
    $table->unique(['user_id', 'disease_package_id'], 'user_package_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_user_packages');
    }
};
