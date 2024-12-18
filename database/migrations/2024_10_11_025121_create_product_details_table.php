<?php

use App\Models\colors;
use App\Models\products;
use App\Models\sizes;
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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->nullable();
            $table->foreignIdFor(products::class)->constrained();
            $table->foreignId('size_id')->constrained('sizes', 'size_id');
            $table->foreignId('color_id')->constrained('colors', 'color_id');
            $table->string('image');
            $table->boolean('is_active')->default(true);
            $table->double('price');
            $table->double('discount_price')->nullable();
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
