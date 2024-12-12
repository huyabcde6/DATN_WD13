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
        Schema::create('coupon__conditions', function (Blueprint $table) {
            $table->id(); // ID duy nhất
            $table->unsignedBigInteger('coupon_id'); // Liên kết với bảng Coupons
            $table->unsignedBigInteger('product_id')->nullable(); // Áp dụng cho sản phẩm cụ thể (nullable)
            $table->unsignedBigInteger('category_id')->nullable(); // Áp dụng cho danh mục sản phẩm cụ thể (nullable)
            $table->timestamps(); // created_at, updated_at

            // Khóa ngoại
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon__conditions');
    }
};
