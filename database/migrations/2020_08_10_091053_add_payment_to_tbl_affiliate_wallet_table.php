<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentToTblAffiliateWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_affiliate_wallet', function (Blueprint $table) {
            $table->string('order_id')->nullable()->after('transaction_type');
            $table->dateTime('order_date')->nullable()->after('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_affiliate_wallet', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->dropColumn('order_date');
        });
    }
}
