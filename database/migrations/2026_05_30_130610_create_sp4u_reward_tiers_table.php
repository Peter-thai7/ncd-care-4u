<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_reward_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reward_campaign_id')->constrained('sp4u_reward_campaigns')->cascadeOnDelete();
            $table->string('title', 255); // ชื่อระดับรางวัล (เช่น รางวัลทอง, รางวัลเงิน)
            $table->text('description')->nullable();
            $table->string('image_path')->nullable(); // รูปรางวัล (รองรับ Drag reorder รูปภาพ)
            $table->unsignedInteger('required_points'); // ต้องใช้คะแนนแลกเท่าไหร่
            $table->unsignedInteger('stock_quantity')->nullable(); // จำนวนสต็อก (null = ไม่จำกัด)
            $table->unsignedInteger('sort_order')->default(0); // ลำดับ
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_reward_tiers');
    }
};