<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->nullable(false)->change();
        });
    }
};
