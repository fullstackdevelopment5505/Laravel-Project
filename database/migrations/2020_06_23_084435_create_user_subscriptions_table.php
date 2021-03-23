<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
			$table->enum('payment_method',['stripe'])->default('stripe');
			$table->string('stripe_subscription_id');
			$table->string('stripe_customer_id');
			$table->string('stripe_plan_id');
			$table->double('plan_amount', 10, 2);
			$table->string('plan_amount_currency');
			$table->string('plan_interval');
			$table->tinyInteger('plan_interval_count');
			$table->string('payer_email');
			$table->dateTime('plan_period_start');
			$table->dateTime('plan_period_end');
			$table->string('status');
			$table->date(' ended_at');
			$table->dateTime('canceled_at');
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
        Schema::dropIfExists('user_subscriptions');
    }
}
