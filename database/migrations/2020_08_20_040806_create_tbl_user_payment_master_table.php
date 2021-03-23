<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblUserPaymentMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_user_payment_master', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
			$table->integer('point_id');
			$table->decimal('amount', 4, 2);
			$table->integer('total_records');
			$table->enum('payment_type',['1', '2', '3', '4' ,'5', '6']);
			$table->string('payment_type_text');
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
        Schema::dropIfExists('tbl_user_payment_master');
    }
}
