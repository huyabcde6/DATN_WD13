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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nguoi_nhan');
            $table->string('email');
            $table->string('number_phone');
            $table->string('address');
            $table->string('ghi_chu')->nullable();
            $table->enum('method', ['COD', 'credit_card', 'paypal', 'momo'])->default('COD');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount', 15, 2)->default(0); 
            $table->decimal('shipping_fee', 15, 2)->default(0);
            $table->decimal('total_price', 15, 2);
            $table->date('date_invoice');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
