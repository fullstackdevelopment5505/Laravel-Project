<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserProperty extends Model
{
    protected $table='user_property';
	public $timestamps = true;
    protected $fillable = [
        'id','user_id','property_id','status','trash','opportunity_status','email_search_flag','email','for_closue_status','open_lien_status',
		'property_detail_status','tax_status_status','forclosue','openlien','propertydetail','taxstatus','notes','phone_search_flag',
		'phone','line_type','job_status','batch_search_email_flag','batch_search_phone_flag','firstname','lastname','address','city','state','zip',
		'property_type','apn','mailing_address','mailing_unit_number','mailing_city','mailing_state','mailing_zip','unit_number', 'sales_comparable', 'sales_comparable_status'
    ];

	public function logs()
    {
    	return $this->hasOne('App\ContactLog','user_property_id','id')->where('user_id',Auth::id())->orderBy('id','desc');
    }



	/* public function getOpportunityStatusAttribute($value)
    {
        if($value == 1){
			return 'Prospecting';
		}elseif($value == 2){
			return 'Qualification';
		}elseif($value == 3){
			return 'Needs Analysis';
		}elseif($value == 4){
			return ' Value Proposition';
		}elseif($value == 5){
			return 'Id. Decision Makers';
		}elseif($value == 6){
			return 'Perception Analysis ';
		}elseif($value == 7){
			return 'Proposal/Price Quote';
		}elseif($value == 8){
			return 'Negotiation/Review';
		}elseif($value == 9){
			return 'Closed Won';
		}elseif($value == 10){
			return 'Closed Lost';
		}else{
			return '';
		}
    } */

    public function datatree()
    {
    	return $this->hasOne('App\Model\DataTree','id','property_id');
    }

    public function getForclosueAttribute($value)
    {
        return url($value);
    }

    public function getOpenlienAttribute($value)
    {
        return url($value);
    }

    public function getPropertydetailAttribute($value)
    {
        return url($value);
    }

    public function getTaxstatusAttribute($value)
    {
        return url($value);
    }


}
