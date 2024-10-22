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
        Schema::table('products', function (Blueprint $table) {
            $table->double('price')->after('avata');
            $table->double('discount_price')->nullable()->after('price');
            $table->integer('stock_quantity')->default(0)->after('discount_price');
            $table->string('short_description')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('short_description');
            $table->dropColumn('stock_quantity');
            $table->dropColumn('discount_price');
            $table->dropColumn('price');
        });
    }
};
