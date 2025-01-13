<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Người dùng thực hiện hành động
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Đơn hàng bị ảnh hưởng
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade'); // Sản phẩm bị ảnh hưởng (nếu có)
            $table->enum('action', ['cancel', 'return', 'complete', 'comment']); // Hành động: hủy, hoàn, bình luận
            $table->text('comment')->nullable(); // Bình luận nếu có
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_actions');
    }
};
