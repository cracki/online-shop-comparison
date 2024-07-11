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
        Schema::create('product_combinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('productA_id')->constrained('online_shop_products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('productB_id');
            $table->foreignId('category_id')->constrained('categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('percentage');
            $table->string('engine_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_combinations');
    }
};
