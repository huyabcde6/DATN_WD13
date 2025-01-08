<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            // Kiểm tra nếu khóa ngoại tồn tại trước khi xóa
            if (Schema::hasColumn('order_details', 'product_detail_id')) {
                $table->dropForeign(['product_detail_id']);
                $table->dropColumn('product_detail_id');
            }

            // Thêm cột 'product_variant_id' nếu chưa tồn tại
            if (!Schema::hasColumn('order_details', 'product_variant_id')) {
                $table->foreignId('product_variant_id')
                    ->constrained('product_variants')
                    ->onDelete('cascade');
            }

            // Thêm cột 'attributes' nếu chưa tồn tại
            if (!Schema::hasColumn('order_details', 'attributes')) {
                $table->json('attributes')->nullable()->after('quantity');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            // Xóa cột 'product_variant_id' nếu tồn tại
            if (Schema::hasColumn('order_details', 'product_variant_id')) {
                $table->dropForeign(['product_variant_id']);
                $table->dropColumn('product_variant_id');
            }

            // Xóa cột 'attributes' nếu tồn tại
            if (Schema::hasColumn('order_details', 'attributes')) {
                $table->dropColumn('attributes');
            }

            // Thêm lại cột 'product_detail_id' nếu cần
            if (!Schema::hasColumn('order_details', 'product_detail_id')) {
                $table->foreignId('product_detail_id')
                    ->constrained('product_details')
                    ->onDelete('cascade');
            }
        });
    }
}
