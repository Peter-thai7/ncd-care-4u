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
        Schema::create('sp4u_exercise_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_package_id')->constrained('sp4u_user_packages')->cascadeOnDelete(); // ผูกกับแพ็กเกจคนไข้
            $table->foreignId('prescribed_by_user_id')->constrained('users'); // นักกายภาพฯ ที่สั่งแผน
            $table->date('prescription_date')->nullable(); // วันที่เริ่มแผน
            $table->text('notes')->nullable(); // โน้ตจากนักกายภาพฯ
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_exercise_prescriptions');
    }
};
