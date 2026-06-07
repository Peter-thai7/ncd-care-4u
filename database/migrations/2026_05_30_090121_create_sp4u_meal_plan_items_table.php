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
        Schema::create('sp4u_meal_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_plan_id')->constrained('sp4u_meal_plans')->cascadeOnDelete(); // ผูกกับแผนหลัก
            $table->foreignId('master_menu_id')->constrained('sp4u_master_menus')->cascadeOnDelete(); // หยิบเมนูไหนจากคลัง
            $table->string('meal_time', 50)->default('breakfast'); // มื้อไหน (breakfast, lunch, dinner, snack)
            $table->decimal('serving_quantity', 8, 2)->default(1); // จำนวนที่สั่ง (เช่น 1.5 ที่)
            $table->decimal('water_glasses', 8, 2)->nullable(); // ปริมาณน้ำที่แนะนำ
            $table->string('fruit_portion', 255)->nullable(); // ผลไม้ที่แนะนำเพิ่ม
            $table->text('specific_notes')->nullable(); // โน้ตส่วนตัวเฉพาะเมนูนี้ (เช่น ห้ามใส่น้ำตาล)
            $table->unsignedInteger('sort_order')->default(0); // ลำดับการแสดงผล
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_meal_plan_items');
    }
};
