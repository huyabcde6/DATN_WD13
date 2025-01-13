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
        Schema::create('user_shift', function (Blueprint $table) {
            $table->id(); // Mã định danh bản ghi
            $table->unsignedBigInteger('user_id'); // Mã định danh người dùng
            $table->unsignedBigInteger('shift_id'); // Mã định danh ca làm việc
            $table->date('assigned_date')->nullable(); // Ngày áp dụng ca làm việc
            $table->timestamps(); // created_at, updated_at
        
            // Khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_shift');
    }
};
