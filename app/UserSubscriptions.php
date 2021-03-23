<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptions extends Model
{
    protected $table='user_subscriptions';
	
	protected $fillable=['id','user_id',	'payment_method',	'stripe_subscription_id',	'stripe_customer_id',	'stripe_plan_id',	'plan_amount',	'plan_amount_currency',	'plan_interval',	'plan_interval_count',	'payer_email',	'plan_period_start',	'plan_period_end',	'status'];

}
