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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign('user_id')->on('users')->references('id')->cascadeOnDelete();
            $table->string('series', 3);
            $table->string('serial_number');
            $table->date('date');
            $table->foreignId('type_id');
            $table->foreign('type_id')->on('invoice_types')->references('id');
            $table->foreignId('icon_id')->nullable();
            $table->foreign('icon_id')->on('icons')->references('id');
            $table->string('seller_name');
            $table->string('seller_phone');
            $table->string('seller_address');
            $table->foreignId('seller_bank_id');
            $table->foreign('seller_bank_id')->on('banks')->references('id');
            $table->string('seller_ia_certificate_id')->nullable();
            $table->string('seller_personal_code')->nullable();
            $table->string('seller_bank_account_number');
            $table->foreignId('client_id');
            $table->foreign('client_id')->on('clients')->references('id')->cascadeOnDelete();
            $table->foreignId('currency_id');
            $table->foreign('currency_id')->on('currencies')->references('id');
            $table->text('notes')->nullable();
            $table->date('pay_date');
            $table->string('filename');
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
        Schema::dropIfExists('invoices');
    }
};
