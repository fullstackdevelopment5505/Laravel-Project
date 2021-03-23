<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPostcardDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_postcard_designs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('postcard_size');
            $table->string('handwriting_style');
            $table->string('title');
            $table->longText('description');
            $table->longText('postcard_content');
            $table->longText('company_goal');
            $table->longText('targets');
            $table->string('primary_color');
            $table->string('secondary_color');
            $table->string('font_family');
            $table->mediumText('sample_image');
			$table->longText('additional_notes');
			$table->enum('save_as_template',['0','1'])->default('0');
			$table->enum('status',['0','1','2','3'])->default('0');
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
        Schema::dropIfExists('user_postcard_designs');
    }
}
