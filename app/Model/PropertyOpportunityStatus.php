<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertyOpportunityStatus extends Model
{
    protected $table='tbl_property_opportunity_status';
    protected $fillable = [
        'id','user_property_id','user_id','opportunity_status_value'
    ];
	
	public function getOpportunityStatusValueAttribute($value)
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
			return 'not status';
		}
    }
}
