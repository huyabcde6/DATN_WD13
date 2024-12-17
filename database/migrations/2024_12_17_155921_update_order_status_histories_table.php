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
        Schema::table('order_status_histories', function (Blueprint $table) {
            // Xóa các cột trạng thái hiện tại và trạng thái trước đó cũ
            $table->dropColumn('previous_status');
            $table->dropColumn('current_status');

            // Thêm cột khóa ngoại tham chiếu tới bảng 'status_donhangs'
            $table->foreignId('previous_status_id')
                ->nullable()
                ->constrained('status_donhangs') // Liên kết với bảng status_donhangs
                ->onDelete('set null'); // Nếu xóa status thì cột này sẽ được đặt là null

            $table->foreignId('current_status_id')
                ->constrained('status_donhangs') // Liên kết với bảng status_donhangs
                ->onDelete('cascade'); // Nếu xóa status, các bản ghi tương ứng cũng sẽ bị xóa
        });
    }

    public function down()
    {
        Schema::table('order_status_histories', function (Blueprint $table) {
            // Khôi phục lại các cột trạng thái cũ nếu rollback
            $table->string('previous_status')->nullable();
            $table->string('current_status');

            // Xóa các cột khóa ngoại
            $table->dropColumn('previous_status_id');
            $table->dropColumn('current_status_id');
        });
    }
};
