<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersUplodedDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_uploaded_data', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
			$table->integer('datafinder_found_id');
			$table->integer('accurate_append_found_id');
			$table->integer('upload_data_group_id');
			$table->string('firstname');
			$table->string('lastname');
			$table->string('city');
			$table->string('state');
			$table->integer('zip');
			$table->text('address');
			$table->string('email');
			$table->string('email_address_usable');
			$table->integer('phone');
			$table->string('line_type');
			$table->enum('phone_search_flag',['0', '1'])->default('0');
			$table->enum('email_search_flag',['0', '1'])->default('0');
			$table->enum('batch_process_email',['0', '1'])->default('0');
			$table->enum('batch_process_phone',['0', '1'])->default('0');
			$table->enum('status',['0', '1'])->default('0');
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
        Schema::dropIfExists('users_uploaded_data');
    }
}
