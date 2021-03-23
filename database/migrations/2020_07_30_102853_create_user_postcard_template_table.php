<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPostcardTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_postcard_template', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
			$table->string('postcard_title');
			$table->longText('postcard_front_content');
			$table->longText('postcard_back_content');
			$table->enum('status',['0', '1'])->default('1');
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
        Schema::dropIfExists('user_postcard_template');
    }
}
