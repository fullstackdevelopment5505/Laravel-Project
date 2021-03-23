<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{
	protected $table='customers_master';

	protected $fillable=['email ',	'membership_id',	'type',	'membership_purchase_date',	'first_name',	'last_name',	'company_name',	'phone_number',	'city',	'state',	'country',	'address',	'postal_code',	'username ',	'custid ',	'created_at',	'updated_at','last_login_date','status'];

	protected $hidden=['id','updated_at'];
}
