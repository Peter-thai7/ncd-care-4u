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
        Schema::create('sp4u_package_tabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_package_id')->constrained('sp4u_disease_packages')->cascadeOnDelete();
            $table->string('title', 255); // ชื่อแท็บ (เช่น บันทึกระดับน้ำตาล, อาการข้างเคียง)
            $table->string('tab_type', 50)->default('dynamic_form'); // ประเภทแท็บ (dynamic_form, meal_plan, exercise)
            $table->unsignedInteger('sort_order')->default(0); // ลำดับการแสดงผล (Drag Reorder)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_package_tabs');
    }
};
