<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWealthAndRatingFieldsToUserProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_property', function (Blueprint $table) {
            $table->string('NetWorth');
            $table->string('CreditRating');
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
           $table->dropColumn('NetWorth');
           $table->dropColumn('CreditRating');
        });
    }
}
