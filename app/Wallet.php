<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table='wallet';

	protected $fillable=['date','customer_name','deposite_amount','tax','cash'];

	protected $hidden=['id']; 
}
