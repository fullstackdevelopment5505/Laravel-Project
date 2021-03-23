<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenditureMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenditure_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type',50);
            $table->string('name',50);
            $table->float('amount',8, 2);
			$table->string('payment_mode',100);
            $table->integer('user_id')->nullable();
            $table->integer('customer_id')->nullable();
			$table->enum('status',['0', '1']);
            $table->dateTime('expenditure_date');
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
        Schema::dropIfExists('expenditure_master');
    }
}
