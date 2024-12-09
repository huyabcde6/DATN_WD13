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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id(); // ID duy nhất
            $table->string('code', 20)->unique(); // Mã giảm giá (unique)
            $table->enum('discount_type', ['percentage', 'fixed_amount']); // Loại giảm giá
            $table->decimal('discount_value', 10, 2); // Giá trị giảm giá
            $table->decimal('max_discount_amount', 10, 2)->nullable(); // Số tiền giảm tối đa (nullable)
            $table->decimal('min_order_amount', 10, 2)->nullable(); // Giá trị đơn hàng tối thiểu (nullable)
            $table->timestamp('start_date')->nullable(); // Ngày bắt đầu
            $table->timestamp('end_date')->nullable(); // Ngày kết thúc
            $table->integer('total_quantity')->default(0); // Số lượng mã phát hành
            $table->integer('used_quantity')->default(0); // Số lượng mã đã sử dụng
            $table->enum('status', ['active', 'expired', 'disabled'])->default('active'); // Trạng thái
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
