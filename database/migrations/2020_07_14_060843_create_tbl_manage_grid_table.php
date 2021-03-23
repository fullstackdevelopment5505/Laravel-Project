<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblManageGridTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_manage_grid', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
			$table->enum('type',['1', '2'])->default('1');
			$table->integer('grid_total_number');
			$table->json('column_status');
			$table->json('selected_column');
			$table->json('column_name');
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
        Schema::dropIfExists('tbl_manage_grid');
    }
}
