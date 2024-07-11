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
                Schema::create('online_shop_products', function (Blueprint $table) {
                    $table->id();
                    $table->integer('origin_id');
                    $table->string('brand');
                    $table->double('price')->nullable();
                    $table->string('size', 1024)->nullable();
                    $table->string('name', 1024)->nullable();
                    $table->string('description', 1024)->nullable();
                    $table->string('category')->nullable();
                    $table->foreignId('online_shop_id');
                    $table->foreignId('category_id');
                    $table->timestamps();
                });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_shop_products');
    }
};
