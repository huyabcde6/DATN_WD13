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
        Schema::rename('coupon__conditions', 'couponConditions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('couponConditions', 'coupon__conditions');
    }
};
