<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyComparablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_comparables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('property_id');
            $table->string('property_report_status')->nullable();
            $table->json('comparable_properties')->nullable();
            $table->json('comparable_properties_summary')->nullable();
            $table->json('subject_property')->nullable();
            $table->json('filters')->nullable();
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
        Schema::dropIfExists('property_comparables');
    }
}
