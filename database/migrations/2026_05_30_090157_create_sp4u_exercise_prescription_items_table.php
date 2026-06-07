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
        Schema::create('sp4u_exercise_prescription_items', function (Blueprint $table) {
             $table->id();
            
            // กำหนด Foreign Key เองแบบสั้นๆ เพื่อไม่ให้เกิน 64 ตัวอักษร
            $table->unsignedBigInteger('exercise_prescription_id');
            $table->foreign('exercise_prescription_id', 'ep_items_ep_id_foreign')
                  ->references('id')->on('sp4u_exercise_prescriptions')->cascadeOnDelete();

            $table->unsignedBigInteger('exercise_library_id');
            $table->foreign('exercise_library_id', 'ep_items_el_id_foreign')
                  ->references('id')->on('sp4u_exercise_libraries')->cascadeOnDelete();

            $table->unsignedInteger('sets')->nullable(); // จำนวนเซ็ท
            $table->string('reps', 50)->nullable(); // จำนวนครั้ง (เช่น 10 ครั้ง หรือ 30 วินาที)
            $table->decimal('duration_minutes', 8, 2)->nullable(); // ระยะเวลา (นาที)
            $table->unsignedInteger('rest_seconds')->nullable(); // เวลาพัก (วินาที)
            $table->text('specific_notes')->nullable(); // โน้ตเฉพาะท่า (เช่น หากเจ็บหัวเข่าให้หยุด)
            $table->unsignedInteger('sort_order')->default(0); // ลำดับการแสดงผล
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_exercise_prescription_items');
    }
};
