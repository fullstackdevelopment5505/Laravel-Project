<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApisFieldsToUserProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_property', function (Blueprint $table) {
            $table->string('MedianHouseholdIncome')->nullable();
            $table->string('EstimatedHouseholdIncome')->nullable();
            $table->string('Investing')->nullable();
            $table->string('CharitableDonations')->nullable();
            $table->string('email2');
            $table->string('alternate_email1');
            $table->string('alternate_email2');
            $table->string('phone2');
            $table->string('line_type2');
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
             $table->dropColumn('MedianHouseholdIncome');
             $table->dropColumn('EstimatedHouseholdIncome');
             $table->dropColumn('Investing');
             $table->dropColumn('CharitableDonations');
             $table->dropColumn('email2');
             $table->dropColumn('alternate_email1');
             $table->dropColumn('alternate_email2');
             $table->dropColumn('phone2');
             $table->dropColumn('line_type2');
        });
    }
}
