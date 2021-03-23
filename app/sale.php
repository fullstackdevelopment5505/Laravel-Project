<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends User
{
    protected $fillable=['id','username','email','type','remember_token','api_token','role'];
    protected $visible=['id','username','email','type','remember_token','api_token','role'];
}
