<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_reward_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // ชื่อแคมเปญ
            $table->text('description')->nullable();
            $table->string('image_path')->nullable(); // รูปแคมเปญ (Relative Path)
            $table->timestamp('starts_at')->nullable(); // เริ่มแคมเปญเมื่อไหร่
            $table->timestamp('ends_at')->nullable(); // สิ้นสุดแคมเปญเมื่อไหร่
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_reward_campaigns');
    }
};