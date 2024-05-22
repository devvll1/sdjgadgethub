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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->string('first_name', 55);
            $table->string('middle_name', 55)->nullable();
            $table->string('last_name', 55);
            $table->string('suffix_name',55)->nullable();
            $table->date('birth_date');
            $table->unsignedBigInteger('gender_id');
            $table->text('address');
            $table->string('contact_number', 55);
            $table->string('email', 55);
            $table->unsignedBigInteger('role_id');
            $table->string('username',55)->unique();
            $table->string('photo', 255)->nullable();
            $table->string('password', 255);
            $table->timestamps();

            $table->foreign('gender_id')
                    ->references('gender_id')
                    ->on('genders')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('role_id')
                    ->references('role_id')
                    ->on('roles')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
