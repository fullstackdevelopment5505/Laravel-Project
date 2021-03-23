<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutTeam extends Model
{
    //
    protected $table='tbl_about_teams';
    protected $fillable=['id', 'name', 'designation', 'phone_number', 'email', 'description', 'profile_image', 'header_image', 'facebook_url', 'linkedin_url', 'status', 'deleted_at'];
	
	public function getProfileImageAttribute($value)
    {
        if($value ==""){
            return '';
        }
        return url('../storage/app/'.$value);
    }

    public function getHeaderImageAttribute($value)
    {
        if($value ==""){
            return '';
        }
        return url('../storage/app/'.$value);
    }
	public function getPhoneNumberAttribute($data) {
        if(is_numeric($data)){
			
			return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."-".substr($data,6);
		}
        return $data;
    }
}
