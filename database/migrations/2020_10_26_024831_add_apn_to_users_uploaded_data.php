<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApnToUsersUploadedData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_uploaded_data', function (Blueprint $table) {
             $table->string('apn')->after('upload_data_group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_uploaded_data', function (Blueprint $table) {
            $table->dropColumn('apn');
        });
    }
}
