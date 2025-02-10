<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('click_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('short_link_id')->constrained('short_links')->onDelete('cascade');
            $table->string('ip_address', 45);
            $table->text('user_agent');
            $table->enum('referrer', ['facebook', 'google', 'ads', 'other'])->default('other');
            $table->enum('device_type', ['mobile', 'tablet', 'pc']);
            $table->string('os', 50);
            $table->string('country', 100)->nullable();
            $table->timestamp('clicked_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->index('clicked_at');
            $table->index('referrer');
        });
    }

    public function down() {
        Schema::dropIfExists('click_statistics');
    }
};

