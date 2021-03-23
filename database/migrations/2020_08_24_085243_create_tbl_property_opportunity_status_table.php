<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPropertyOpportunityStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_property_opportunity_status', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
			$table->integer('user_property_id');
			$table->integer('opportunity_status_value');
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
        Schema::dropIfExists('tbl_property_opportunity_status');
    }
}
