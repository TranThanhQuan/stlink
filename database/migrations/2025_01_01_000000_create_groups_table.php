<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->json('permissions');
            $table->unsignedBigInteger('user_id')->default(1);
            $table->boolean('isAdmin')->default(0);
            $table->timestamps();
        });

    }

    public function down() {
        Schema::dropIfExists('groups');
    }
};

