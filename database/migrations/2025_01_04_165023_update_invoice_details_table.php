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
        Schema::table('invoice_details', function (Blueprint $table) {
            // Xóa các cột không cần thiết (nếu tồn tại)
            if (Schema::hasColumn('invoice_details', 'color')) {
                $table->dropColumn('color');
            }
            if (Schema::hasColumn('invoice_details', 'size')) {
                $table->dropColumn('size');
            }

            // Thêm các cột mới để giống với bảng `order_details`
            $table->json('attributes')->nullable()->after('quantity'); // Cột thuộc tính động
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            // Xóa cột 'attributes'
            $table->dropColumn('attributes');

            // Thêm lại các cột đã xóa
            $table->string('color')->nullable()->after('product_avata'); // Màu sắc
            $table->string('size')->nullable()->after('color');         // Kích thước
        });
    }
};
