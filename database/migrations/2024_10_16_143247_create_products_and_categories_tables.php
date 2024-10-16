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
    // Termékek táblája
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->integer('price');
        $table->timestamps();
    });

    // Kategóriák táblája
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->timestamps();
    });

    // Köztes tábla a termékek és kategóriák kapcsolatához
    Schema::create('category_product', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('products');
    }
};

