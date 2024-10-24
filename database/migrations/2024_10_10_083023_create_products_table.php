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
            $table->foreignIdFor(categories::class)->constrained();
            $table->string('avata');
            $table->text('description')->nullable();
            $table->boolean('iS_hot')->default(true);
            $table->boolean('iS_new')->default(true);
            $table->boolean('iS_show')->default(true);
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
