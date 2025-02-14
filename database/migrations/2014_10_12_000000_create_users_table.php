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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable(); // Có thể null nếu đăng nhập bằng Google
            $table->enum('provider', ['email', 'google'])->edefault('email');
            $table->string('provider_id')->nullable();
            $table->enum('role', ['user', 'premium', 'moderator', 'admin'])->default('user');
            $table->enum('status', ['active', 'disable'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
