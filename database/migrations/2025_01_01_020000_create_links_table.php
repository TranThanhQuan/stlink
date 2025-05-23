<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('short_code', 20)->unique();
            $table->string('original_url', 2083);
            $table->boolean('status')->default(1);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index('short_code');
            $table->index('expires_at');
        });
    }


    public function down() {
        Schema::dropIfExists('links');
    }
};

