<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('sp4u_users')->onDelete('cascade');
            $table->string('consent_type');
            $table->string('accepted_version');
            $table->timestamp('accepted_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_consents');
    }
};