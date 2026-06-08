<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * เพิ่มคอลัมน์ใหม่ที่ขาดในตาราง sp4u_master_menus
     * เปลี่ยนชื่อ calories_kcal → calories, protein_g → protein, carb_g → carbs, fat_g → fat
     * เปลี่ยนชื่อ meal_type → category
     * เปลี่ยนชื่อ image_path → image_path (คงเดิม)
     */
    public function up(): void
    {
        // Step 1: เพิ่มคอลัมน์ใหม่ทั้งหมดก่อน
        Schema::table('sp4u_master_menus', function (Blueprint $table) {
            $table->string('category', 100)->nullable()->after('description');
            $table->decimal('calories', 8, 2)->nullable()->after('image_path');
            $table->decimal('protein', 8, 2)->nullable()->after('calories');
            $table->decimal('carbs', 8, 2)->nullable()->after('protein');
            $table->decimal('fiber', 8, 2)->nullable()->after('fat_g');
            $table->decimal('sodium', 8, 2)->nullable()->after('fiber');
            $table->text('instructions')->nullable()->after('sodium');
            $table->text('ingredients')->nullable()->after('instructions');
            $table->integer('preparation_time')->nullable()->after('ingredients');
            $table->string('serving_size', 100)->nullable()->after('preparation_time');
            $table->string('difficulty_level', 50)->nullable()->after('serving_size');
            $table->json('suitable_for')->nullable()->after('difficulty_level');
            $table->json('tags')->nullable()->after('suitable_for');
            $table->integer('sort_order')->default(0)->after('is_active');
            $table->unsignedBigInteger('created_by')->nullable()->after('sort_order');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
        });

        // Step 2: คัดลอกข้อมูลจากคอลัมน์เก่า → ใหม่
        DB::statement('UPDATE sp4u_master_menus SET category = meal_type WHERE category IS NULL');
        DB::statement('UPDATE sp4u_master_menus SET calories = calories_kcal WHERE calories IS NULL');
        DB::statement('UPDATE sp4u_master_menus SET protein = protein_g WHERE protein IS NULL');
        DB::statement('UPDATE sp4u_master_menus SET carbs = carb_g WHERE carbs IS NULL');

        // Step 3: ลบคอลัมน์เก่าที่ไม่ใช้
        Schema::table('sp4u_master_menus', function (Blueprint $table) {
            $table->dropColumn(['calories_kcal', 'protein_g', 'carb_g', 'fat_g', 'meal_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sp4u_master_menus', function (Blueprint $table) {
            $table->decimal('calories_kcal', 8, 2)->nullable()->after('image_path');
            $table->decimal('protein_g', 8, 2)->nullable()->after('calories_kcal');
            $table->decimal('carb_g', 8, 2)->nullable()->after('protein_g');
            $table->decimal('fat_g', 8, 2)->nullable()->after('carb_g');
            $table->string('meal_type', 50)->default('general')->after('description');
        });

        DB::statement('UPDATE sp4u_master_menus SET calories_kcal = calories WHERE calories_kcal IS NULL');
        DB::statement('UPDATE sp4u_master_menus SET protein_g = protein WHERE protein_g IS NULL');
        DB::statement('UPDATE sp4u_master_menus SET carb_g = carbs WHERE carb_g IS NULL');
        DB::statement('UPDATE sp4u_master_menus SET meal_type = category WHERE meal_type IS NULL');

        Schema::table('sp4u_master_menus', function (Blueprint $table) {
            $table->dropColumn([
                'category', 'calories', 'protein', 'carbs', 'fiber', 'sodium',
                'instructions', 'ingredients', 'preparation_time', 'serving_size',
                'difficulty_level', 'suitable_for', 'tags', 'sort_order',
                'created_by', 'updated_by',
            ]);
        });
    }
};
