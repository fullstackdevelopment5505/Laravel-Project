<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->integer('membership_id');
            $table->enum('type', ['member', 'non-member']);
            $table->date('membership_purchase_date');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company_name');
            $table->string('phone_number',20);
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('address');
            $table->integer('postal_code');
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
        Schema::dropIfExists('customers_master');
    }
}
