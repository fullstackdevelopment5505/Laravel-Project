<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPostcardMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_postcard_metadata', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
			$table->integer('property_id');
			$table->longText('message');
			$table->string('name');
			$table->integer('handwriting_style');
			$table->string('front_image');
			$table->integer('transaction_id');
			$table->integer('total_estimated_recipients');
			$table->integer('authorization_total');
			$table->string('size');
			$table->string('session_id');
			$table->string('display_trigger');
			$table->string('status');
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
        Schema::dropIfExists('user_postcard_metadata');
    }
}
