<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReportFieldsToUserProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_property', function (Blueprint $table) {
            $table->integer('total_view_report_flag');
            $table->integer('transaction_hostory_report_flag');
            $table->integer('sales_comparable_report_flag');
            $table->integer('title_chain_lien_report_flag');
            $table->integer('hoa_lien_report_flag');
            $table->integer('pace_lien_report_flag');
            $table->string('totalViewReportUrl')->nullable();
            $table->string('transactionHistoryReportUrl')->nullable();
            $table->string('salesComparableReportUrl')->nullable();
            $table->string('titleChainLienReportUrl')->nullable();
            $table->string('hoaLienReportUrl')->nullable();
            $table->string('paceLienReportUrl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_property', function (Blueprint $table) {
            $table->dropColumn('total_view_report_flag');
            $table->dropColumn('transaction_hostory_report_flag');
            $table->dropColumn('sales_comparable_report_flag');
            $table->dropColumn('title_chain_lien_report_flag');
            $table->dropColumn('hoa_lien_report_flag');
            $table->dropColumn('pace_lien_report_flag');
            $table->dropColumn('totalViewReportUrl');
            $table->dropColumn('transactionHistoryReportUrl');
            $table->dropColumn('salesComparableReportUrl');
            $table->dropColumn('titleChainLienReportUrl');
            $table->dropColumn('hoaLienReportUrl');
            $table->dropColumn('paceLienReportUrl');
        });
    }
}
