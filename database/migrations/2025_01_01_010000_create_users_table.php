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
            $table->string('prefix')->default('');

            $table->string('password')->nullable(); // Có thể null nếu đăng nhập bằng Google
            $table->enum('provider', ['email', 'google'])->default('email')->nullable();
            $table->string('provider_id')->nullable();
            $table->unsignedBigInteger('group_id');

            $table->boolean('status')->default(1);
            // $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            // Thêm khóa ngoại
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
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
