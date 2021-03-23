<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use DB;

class AffiliateUsers extends Authenticatable
{
	use Notifiable, HasApiTokens;
    protected $table='affiliate_users';

    protected $fillable=[ 'id', 'username','affiliate_token', 'service_code', 'service_code_prefix' ,'email', 'password','state','city','zipcode','phone','info','address','full_name','taxid','paypal_email_address', 'status','api_token'];

	protected $hidden = [
        'password', 'remember_token' ,'api_token'
    ];
	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function aff_commission()
    {
        return $this->hasOne('App\AffiliateCommission','affiliate_id')->orderBy('id','desc');
    }

	public function wallet()
    {
        return $this->hasMany('App\AffiliateWallet','affiliate_id')->orderBy('id','desc');
    }

	public function getPhoneAttribute($data) {
		if(is_numeric($data)){

			return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."-".substr($data,6);
		}
        return $data;
        // add logic to correctly format number here
        // a more robust ways would be to use a regular expression

    }

	public function getServiceCodePrefixAttribute($value) {

        return '';
    }

	public function getZipcodeAttribute($zipcode) {
		if(strlen($zipcode) == 5){
			return $zipcode;
		}
		if(strlen($zipcode) == 4){
			return str_pad($zipcode,5,"0",STR_PAD_LEFT);
		}
        return substr($zipcode, 0, 5)."-".substr($zipcode,6);
    }

	/* public function getStateAttribute($value) {
		$data=DB::table('us_states')->select('STATE_NAME')->where('ID',$value)->first();
		return $data->STATE_NAME;
    }

	public function getCityAttribute($value) {
		$data=DB::table('us_cities')->select('CITY')->where('ID',$value)->first();
		return $data->CITY;
    } */


}
