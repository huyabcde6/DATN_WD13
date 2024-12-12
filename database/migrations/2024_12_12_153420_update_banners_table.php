<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBannersTable extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            // Xóa cột 'oder' nếu tồn tại
            if (Schema::hasColumn('banners', 'order')) {
                $table->dropColumn('oder');
            }

            // Thêm cột 'status' với kiểu integer có các giá trị 0 (ẩn) và 1 (hiện)
            if (!Schema::hasColumn('banners', 'status')) {
                $table->integer('status')->default(1);  // 1 là "hiện", 0 là "ẩn"
            }
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {


            // Xóa cột 'status' nếu cần
            $table->dropColumn('status');
        });
    }
}
