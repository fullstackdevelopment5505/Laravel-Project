<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMailingFieldsToUserProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_property', function (Blueprint $table) {
            $table->string('unit_number');
            $table->string('mailing_address');
            $table->string('mailing_city');
            $table->string('mailing_state');
            $table->integer('mailing_zip');
            $table->string('mailing_unit_number');
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
            $table->dropColumn('unit_number');
            $table->dropColumn('mailing_address');
            $table->dropColumn('mailing_city');
            $table->dropColumn('mailing_state');
            $table->dropColumn('mailing_zip');
            $table->dropColumn('mailing_unit_number');
        });
    }
}
