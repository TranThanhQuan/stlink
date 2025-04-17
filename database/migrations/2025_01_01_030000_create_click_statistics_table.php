<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('click_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained('links')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->string('referrer', 50)->nullable();
            $table->string('os', 50);
            $table->string('country', 100)->nullable();
            $table->string('browser', 100)->nullable();
            $table->string('platform', 50);
            $table->timestamps();

            $table->index('created_at');
            $table->index('os');
            $table->index('country');
            $table->index('browser');
            $table->index('platform');
        });

    }


    public function down() {
        Schema::dropIfExists('click_statistics');
    }
};

