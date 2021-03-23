<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveRequets extends Model
{
    protected $table='leave_requets';

    protected $fillable=['employee_id','employee_name','department','leave_type','holiday_from','holiday_to','no_of_days','status','reason'];
    
    protected $hidden=['id']; 
}
