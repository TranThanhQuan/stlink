<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('user_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('payment_method'); // Phương thức thanh toán (e.g., PayPal, Momo, VNPay)
            $table->string('transaction_id')->unique(); // Mã giao dịch
            $table->decimal('amount', 10, 2); // Số tiền thanh toán
            $table->string('currency', 10)->default('VND'); // Đơn vị tiền tệ
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending'); // Trạng thái thanh toán
            $table->json('meta_data')->nullable(); // Lưu trữ dữ liệu bổ sung như phản hồi từ cổng thanh toán
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('user_payments');
    }
};
