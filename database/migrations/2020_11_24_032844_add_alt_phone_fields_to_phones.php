<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAltPhoneFieldsToPhones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phones', function (Blueprint $table) {
            $table->string('fullnumber2');
            $table->string('linetype2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phones', function (Blueprint $table) {
           $table->dropColumn('fullnumber2');
           $table->dropColumn('linetype2');
        });
    }
}
