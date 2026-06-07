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
        Schema::create('sp4u_master_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // ชื่อเมนูอาหาร
            $table->text('description')->nullable(); // ส่วนผสม/วิธีทำสั้นๆ
            $table->string('image_path')->nullable(); // รูปอาหาร (เก็บแบบ Relative Path)
            $table->decimal('calories_kcal', 8, 2)->nullable(); // แคลอรี่
            $table->decimal('protein_g', 8, 2)->nullable(); // โปรตีน (กรัม)
            $table->decimal('carb_g', 8, 2)->nullable(); // คาร์บ (กรัม)
            $table->decimal('fat_g', 8, 2)->nullable(); // ไขมัน (กรัม)
            $table->string('meal_type', 50)->default('general'); // ประเภทมื้อ (breakfast, lunch, dinner, snack, general)
            $table->boolean('is_active')->default(true); // สถานะเปิด/ปิด
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_master_menus');
    }
};
