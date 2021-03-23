<?php

namespace App\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class UsersUploadedData extends Model
{
   protected $table='users_uploaded_data';
   
    public $timestamps = true;
   
    protected $fillable = [
        'id','user_id','datafinder_found_id','accurate_append_found_id','upload_data_group_id','firstname','lastname','city',
		'state','zip','address','email','email_address_usable','phone','line_type','status','phone_search_flag','email_search_flag',
		'batch_process_email','batch_process_phone','apn'
    ];
	
	public function groupname(){

        return $this->hasOne('App\Model\UsersUploadedDataGroup','id','upload_data_group_id')->where('user_id',Auth::id());

    }
}
