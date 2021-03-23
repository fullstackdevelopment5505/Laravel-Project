<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $visible=['name','email','phoneno','location','type'];
    protected $fillable=['name','email','phoneno','location','type'];
}
