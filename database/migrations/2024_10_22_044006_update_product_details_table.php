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
        Schema::table('product_details', function (Blueprint $table) {
            $table->string('product_code')->nullable()->after('id');
            $table->double('discount_price')->nullable()->after('price');
        });
    }

    public function down()
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropColumn('discount_price');
            $table->dropColumn('product_code');
        });
    }
};
