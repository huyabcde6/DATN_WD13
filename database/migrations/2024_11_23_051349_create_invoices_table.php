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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique(); // Mã hóa đơn
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Liên kết với bảng 'users'
            $table->unsignedBigInteger('order_id'); // Liên kết với bảng 'orders'
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade'); // Đặt khóa ngoại
            $table->string('nguoi_nhan'); // Tên người nhận
            $table->string('email'); // Email người nhận
            $table->string('number_phone'); // Số điện thoại
            $table->string('address'); // Địa chỉ
            $table->text('ghi_chu')->nullable(); // Ghi chú (nullable)
            $table->enum('method', ['COD', 'credit_card', 'paypal', 'momo', 'bank_transfer'])->default('COD'); // Phương thức thanh toán
            $table->decimal('subtotal', 15, 2); // Tổng tạm tính
            $table->decimal('discount', 15, 2)->default(0); // Giảm giá
            $table->decimal('shipping_fee', 15, 2)->default(0); // Phí vận chuyển
            $table->decimal('total_price', 15, 2); // Tổng tiền
            $table->date('date_invoice'); // Ngày lập hóa đơn
            $table->timestamps(); // Thêm cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
