<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRequetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_requets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('department')->nullable();
            $table->string('leave_type')->nullable();
            $table->date('holiday_from')->nullable();
            $table->date('holiday_to')->nullable();
            $table->integer('no_of_days')->nullable();
            $table->string('status')->nullable();
            $table->string('reason')->nullable();

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
        Schema::dropIfExists('leave_requets');
    }
}
