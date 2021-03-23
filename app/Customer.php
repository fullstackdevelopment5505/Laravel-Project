<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable=['id','name','email','phoneno','location','property_description','report_name','price','type'];
    protected $visible=['id','name','email','phoneno','location','date','property_description','report_name','price','type'];

}
