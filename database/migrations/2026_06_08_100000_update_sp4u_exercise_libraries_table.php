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
     * เพิ่มคอลัมน์ใหม่ที่ขาดในตาราง sp4u_exercise_libraries
     * และเปลี่ยนชื่อ title → name, ลบ body_part
     */
    public function up(): void
    {
        // Step 1: เพิ่มคอลัมน์ใหม่ทั้งหมดก่อน
        Schema::table('sp4u_exercise_libraries', function (Blueprint $table) {
            $table->string('name', 255)->nullable()->after('id');
            $table->string('category', 100)->nullable()->after('description');
            $table->string('video_url', 500)->nullable()->after('video_path');
            $table->integer('duration_minutes')->nullable()->after('thumbnail_path');
            $table->decimal('calories_burned', 8, 2)->nullable()->after('difficulty_level');
            $table->text('instructions')->nullable()->after('calories_burned');
            $table->text('precautions')->nullable()->after('instructions');
            $table->json('suitable_for')->nullable()->after('precautions');
            $table->json('tags')->nullable()->after('suitable_for');
            $table->integer('sort_order')->default(0)->after('is_active');
            $table->unsignedBigInteger('created_by')->nullable()->after('sort_order');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
        });

        // Step 2: คัดลอกข้อมูลจาก title → name
        DB::statement('UPDATE sp4u_exercise_libraries SET name = title WHERE name IS NULL');

        // Step 3: ลบคอลัมน์เก่าที่ไม่ใช้
        Schema::table('sp4u_exercise_libraries', function (Blueprint $table) {
            $table->dropColumn(['title', 'body_part']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sp4u_exercise_libraries', function (Blueprint $table) {
            $table->string('title', 255)->nullable()->after('id');
            $table->string('body_part', 100)->nullable()->after('thumbnail_path');
        });

        DB::statement('UPDATE sp4u_exercise_libraries SET title = name WHERE title IS NULL');

        Schema::table('sp4u_exercise_libraries', function (Blueprint $table) {
            $table->dropColumn([
                'name', 'category', 'video_url', 'duration_minutes',
                'calories_burned', 'instructions', 'precautions',
                'suitable_for', 'tags', 'sort_order', 'created_by', 'updated_by',
            ]);
        });
    }
};
