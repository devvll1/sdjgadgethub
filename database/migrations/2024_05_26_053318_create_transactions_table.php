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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->dateTime('transaction_date');
            $table->float('total_amount');
            $table->UnsignedBigInteger('pmethod_id');
            $table->UnsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('pmethod_id')
                    ->references('pmethod_id')
                    ->on('paymentmethods')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

                    $table->foreign('user_id')
                    ->references('user_id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
