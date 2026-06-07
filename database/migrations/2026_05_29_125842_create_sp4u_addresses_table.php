<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sp4u_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('sp4u_users')->onDelete('cascade');
            $table->string('address_line')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('subdistrict_id')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp4u_addresses');
    }
};