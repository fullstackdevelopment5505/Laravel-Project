<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApisReponseFieldsToUserProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_property', function (Blueprint $table) {
            $table->json('lifeinterest_reponse')->nullable();
            $table->json('finhouse_reponse')->nullable();
            $table->json('zip4_demographic_reponse')->nullable();
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
             $table->dropColumn('lifeinterest_reponse');
             $table->dropColumn('finhouse_reponse');
             $table->dropColumn('zip4_demographic_reponse');
        });
    }
}
