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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade'); // Liên kết với bảng 'invoices'
            $table->string('product_name'); // Tên sản phẩm tại thời điểm hóa đơn
            $table->string('product_avata');
            $table->string('color'); // Màu sắc sản phẩm
            $table->string('size'); // Kích thước sản phẩm
            $table->integer('quantity'); // Số lượng
            $table->decimal('price', 15, 2); // Giá sản phẩm tại thời điểm hóa đơn
            $table->timestamps(); // Thêm cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
