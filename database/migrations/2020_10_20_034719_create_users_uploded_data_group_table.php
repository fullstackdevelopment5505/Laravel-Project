<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersUplodedDataGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_uploaded_data_group', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
			$table->integer('users_uploaded_data_id');
			$table->string('group_name');
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
        Schema::dropIfExists('users_uploaded_data_group');
    }
}
