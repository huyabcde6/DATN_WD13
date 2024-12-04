<?php

use App\Models\categories;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->foreignIdFor(categories::class)->constrained();
            $table->string('avata');
            $table->double('price');
            $table->double('discount_price')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->boolean('iS_hot')->default(true);
            $table->boolean('iS_new')->default(true);
            $table->boolean('iS_show')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
