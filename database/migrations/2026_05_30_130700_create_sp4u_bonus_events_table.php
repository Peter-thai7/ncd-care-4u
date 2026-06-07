<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_bonus_events', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // ชื่ออีเวนต์โบนัส
            $table->text('description')->nullable();
            $table->string('event_type', 50); // ประเภทอีเวนต์
            $table->unsignedInteger('bonus_points')->default(0); // คะแนนโบนัส
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_bonus_events');
    }
};