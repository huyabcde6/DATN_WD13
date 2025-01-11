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
        Schema::table('product_comments', function (Blueprint $table) {
            $table->text('images')->nullable()->after('description'); // Thêm cột `images`
            $table->dropColumn('image'); // Xóa cột `image`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_comments', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description'); // Khôi phục cột `image`
            $table->dropColumn('images'); // Xóa cột `images`
        });
    }
};
