<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('url');
            $table->text('title');
            $table->text('small_description');
            $table->text('description');
            $table->integer('posted_by_role',11 );
            $table->integer('category',11 );
            $table->date('date');
            $table->string('filename', 255);
            $table->string('youtube_id', 255);
            $table->string('vimeo_id', 255);
            $table->string('views', 20);
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
        Schema::dropIfExists('news');
    }
}
