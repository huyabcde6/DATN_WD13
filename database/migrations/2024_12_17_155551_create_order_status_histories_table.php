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
        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Khóa ngoại tham chiếu tới bảng orders

            // Thay đổi cột trạng thái trước và trạng thái hiện tại thành khóa ngoại tham chiếu tới bảng status_donhangs
            $table->foreignId('previous_status_id')->nullable()->constrained('status_donhangs')->onDelete('set null'); // Khóa ngoại tham chiếu tới status_donhangs
            $table->foreignId('current_status_id')->constrained('status_donhangs')->onDelete('cascade'); // Khóa ngoại tham chiếu tới status_donhangs

            $table->timestamp('changed_at')->default(now()); // Thời gian thay đổi trạng thái
            $table->foreignId('changed_by')->nullable()->constrained('users'); // Người thực hiện thay đổi (nếu có)
            $table->timestamps(); // Tự động tạo created_at và updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_status_histories');
    }
};
