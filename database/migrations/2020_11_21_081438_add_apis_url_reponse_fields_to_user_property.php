<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApisUrlReponseFieldsToUserProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_property', function (Blueprint $table) {
           $table->longText('demographic_append_url')->nullable();
           $table->longText('finhouse_append_url')->nullable();
           $table->longText('zip4_append_url')->nullable();
           $table->longText('lifeint_append_url')->nullable();
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
            $table->dropColumn('demographic_append_url');
            $table->dropColumn('finhouse_append_url');
            $table->dropColumn('zip4_append_url');
            $table->dropColumn('lifeint_append_url');
        });
    }
}
