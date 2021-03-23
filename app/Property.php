<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable=['id','cust_id','name','type','description','amount','status','tax','cash','created_at','date'];
    protected $visible=['id','cust_id','name','type','description','amount','status','tax','cash','created_at','date'];
}
