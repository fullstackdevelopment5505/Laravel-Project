<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable=['id','first_name','last_name','email','phoneno','dob','age','gender','city','department'];
    protected $visible=['id','first_name','last_name','email','phoneno','dob','age','gender','city','department'];

}
