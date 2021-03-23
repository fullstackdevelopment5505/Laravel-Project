<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersUploadedDataGroup extends Model
{
    protected $table='users_uploaded_data_group';
    public $timestamps = true;
   
    protected $fillable = [
        'id','user_id','users_uploaded_data_id','group_name'
    ];
}
