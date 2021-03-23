<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kickstarter extends Model
{
    protected $table='kickstarter';

    protected $fillable = [
        'user_id','email','name','phone','country','state','city','postal_code','address','description','search'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'user_id'
    // ];

    public function profile_image()
    {
        return $this->hasOne('App\Model\Image','user_id','id')->where('type','2');
    }
	
	public function getPhoneAttribute($data) {
		if(is_numeric($data)){
			
			return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."-".substr($data,6);
		}
        return $data;
        // add logic to correctly format number here
        // a more robust ways would be to use a regular expression
       
    }

}
