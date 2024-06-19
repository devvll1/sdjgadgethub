<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id('transaction_item_id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('products_id');
            $table->integer('quantity');
            $table->float('price');
            $table->timestamps();
            

            $table->foreign('transaction_id')
                    ->references('transaction_id')
                    ->on('transactions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('products_id')
                    ->references('products_id')
                    ->on('products')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
