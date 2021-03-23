<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use DB;
class User extends Authenticatable
{
     use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','type','api_token','status','reg_status','role','id','affiliate_username','mapped_to_affiliate','service_code','service_code_prefix','mapped_to_users'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function departments()
    {
        return $this->belongsToMany('App\Model\Department');
    }

	public function details(){

        return $this->hasOne('App\Model\Detail','user_id','id');

    }
	public function role_type()
    {
        return $this->hasOne('App\Model\Role','id','role');
    }
    public function property_reminders()
    {
        return $this->hasMany('App\Model\PropertyReminder','user_id','id');
    }
    public function detail()
    {
        return $this->hasOne('App\Model\Detail', 'user_id', 'id')->SELECT('user_detail.*','us_states.ID as stateID','us_states.STATE_NAME','us_states.STATE_CODE',
            'us_cities.CITY','us_cities.ID as cityID')
        ->join("us_states",function($query){
            $query->on("us_states.ID","=",'user_detail.state');
        })
        ->join("us_cities",function($query){
            $query->on("us_cities.ID","=",'user_detail.city');
        });
    }
    public function customers()
    {
        return $this->hasMany('App\Model\Customer', 'sale_manager');
    }

    public function Image()
    {
         return $this->hasOne('App\Model\Image','user_id')->where('type','1');
    }

    public function cards()
    {
        return $this->hasMany('App\Model\Cards','user_id');
    }


    public function member()
    {
        return $this->hasOne('App\Model\Member','user_id')->orderBy('id','desc');
    }

	public function subscription()
    {
        return $this->hasOne('App\UserSubscriptions','user_id')->orderBy('id','desc');
    }
}
