<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id');
            $table->foreign('invoice_id')->on('invoices')->references('id')->cascadeOnDelete();
            $table->string('name');
            $table->foreignId('unit_id');
            $table->foreign('unit_id')->on('units')->references('id');
            $table->decimal('quantity');
            $table->decimal('price');
            $table->decimal('discount')->default(0);
            $table->decimal('discount_percent')->default(0);
            $table->decimal('total_sum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
