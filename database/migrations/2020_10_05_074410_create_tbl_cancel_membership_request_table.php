<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblCancelMembershipRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cancel_membership_request', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
			$table->json('reason');
			$table->text('subject');
			$table->longText('message');
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
        Schema::dropIfExists('tbl_cancel_membership_request');
    }
}
