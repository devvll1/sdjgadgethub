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
        Schema::create('products', function (Blueprint $table) {
            $table->id('products_id');
            $table->string('photo')->nullable();
            $table->string('name', 55);
            $table->string('description', 55)->nullable();
            $table->float('price');
            $table->integer('stock_quantity');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('category_id')
                    ->references('category_id')
                    ->on('categories')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
