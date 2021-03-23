<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_no')->nullable();
            $table->string('company_name')->nullable();
            $table->string('session')->nullable();
            $table->string('bill_type')->nullable();
            $table->string('address')->nullable();
            $table->string('gstin')->nullable();
            $table->date('date')->nullable();
            $table->string('invoice_prefix')->nullable();
            $table->string('rec_name')->nullable();
            $table->string('rec_address')->nullable();
            $table->string('rec_state')->nullable();
            $table->string('rec_state_code')->nullable();
            $table->string('rec_gstin')->nullable();
            $table->string('con_name')->nullable();
            $table->string('con_address')->nullable();
            $table->string('con_state')->nullable();
            $table->string('con_state_code')->nullable();
            $table->string('con_gstin')->nullable();
            $table->decimal('sub_totla')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('discount')->nullable();
            $table->decimal('total')->nullable();
            $table->string('status')->nullable();
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
}
