<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAffiliateWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_affiliate_wallet', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('affiliate_id');
			$table->decimal('amount', 8, 2);
			$table->integer('transaction_id');
			$table->string('transaction_type');
			$table->enum('status',['paid','due'])->default('due');
			$table->enum('type',['credit','debit'])->default('credit');
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
        Schema::dropIfExists('tbl_affiliate_wallet');
    }
}
