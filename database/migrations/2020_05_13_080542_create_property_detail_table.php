<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('property_id');
            $table->string('property_report_status')->nullable();
            $table->json('property_address')->nullable();
            $table->json('owner_information')->nullable();
            $table->json('location_information')->nullable();
            $table->json('site_information')->nullable();
            $table->json('property_characteristics')->nullable();
            $table->json('tax_information')->nullable();
            $table->json('county_recording_history')->nullable();
            $table->json('owner_transfer_information')->nullable();
            $table->json('last_market_sale_information')->nullable();
            $table->json('prior_sale_information')->nullable();
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
        Schema::dropIfExists('property_detail');
    }
}
