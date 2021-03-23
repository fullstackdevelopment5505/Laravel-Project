<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTreeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_tree_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gl_code')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('entry_user_id')->nullable();
            $table->string('batch_no')->nullable();
            $table->string('brand')->nullable();
            $table->string('report')->nullable();
            $table->decimal('qty')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('data_tree_items');
    }
}
