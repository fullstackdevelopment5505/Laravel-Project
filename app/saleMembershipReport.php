<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class saleMembershipReport extends Model
{
    protected $table='membership_report';

	protected $fillable=['date','name','membership_type','amount','tax','cash'];

	protected $hidden=['id'];   
}
