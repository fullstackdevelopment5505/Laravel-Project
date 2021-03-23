<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table='user_detail';

    protected $fillable = [
        'user_id','f_name', 'l_name','industry', 'company', 'phone', 'country', 'state', 'city', 'address', 'postal', 'info', 'paypal_email_address', 'taxid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

	public function getPhoneAttribute($data) {
        
        // add logic to correctly format number here
        // a more robust ways would be to use a regular expression
		if(is_numeric($data)){
			
			return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."-".substr($data,6);
		}
        return $data;
    }

	public function getIndustryAttribute($data) {
        
		if($data==1){
			return json_encode(array('1'=>'Mortgage Banker/Broker'));
		}else if($data==2){
			return json_encode(array('2'=>'Real Estate Agent/Broker'));
		}else if($data==3){
			return json_encode(array('3'=>'Insurance'));
		}else if($data==4){
			return json_encode(array('4'=>'Investigator'));
		}else if($data==5){
			return json_encode(array('5'=>'Lender'));
		}else{ 
			return json_encode(array('6'=>'Other'));
		}
       
    }
}
