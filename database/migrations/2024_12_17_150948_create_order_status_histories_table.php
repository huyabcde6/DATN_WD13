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
        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Khóa ngoại tham chiếu tới bảng orders
            $table->string('previous_status')->nullable(); // Trạng thái trước khi chuyển đổi
            $table->string('current_status'); // Trạng thái hiện tại
            $table->timestamp('changed_at')->default(now()); // Thời gian thay đổi trạng thái
            $table->foreignId('changed_by')->nullable()->constrained('users'); // Người thực hiện thay đổi (nếu có)
            $table->timestamps(); // Tự động tạo created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
    }
};
