<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBannersTable extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            // Xóa cột 'order' nếu tồn tại
            if (Schema::hasColumn('banners', 'order')) {
                $table->dropColumn('order');
            }

            // Thêm cột 'status' nếu chưa tồn tại
            if (!Schema::hasColumn('banners', 'status')) {
                $table->integer('status')->default(1); // 1 là "hiện", 0 là "ẩn"
            }

            // Thêm cột 'category_id' với ràng buộc khóa ngoại
            if (!Schema::hasColumn('banners', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable();
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            // Xóa cột 'status' nếu tồn tại
            if (Schema::hasColumn('banners', 'status')) {
                $table->dropColumn('status');
            }

            // Xóa cột 'category_id' nếu tồn tại
            if (Schema::hasColumn('banners', 'category_id')) {
                $table->dropForeign(['category_id']); // Xóa ràng buộc khóa ngoại
                $table->dropColumn('category_id');
            }

            // Không cần thêm lại cột 'order', chỉ phục hồi lại nếu cần thiết
        });
    }
}
