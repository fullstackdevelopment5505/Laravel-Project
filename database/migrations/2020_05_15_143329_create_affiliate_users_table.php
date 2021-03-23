<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('username');
            $table->string('full_name');
            $table->string('taxid')->nullable();
            $table->string('paypal_email_address')->nullable();
            $table->integer('state');
            $table->integer('city');
            $table->integer('zipcode');
            $table->string('address');
            $table->string('phone');
            $table->longText('info')->nullable();
            $table->enum('status',['0', '1']);
            $table->text('api_token')->nullable();
            $table->text('affiliate_token')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('affiliate_users');
    }
}
