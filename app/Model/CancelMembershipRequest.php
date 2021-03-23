<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CancelMembershipRequest extends Model
{
    protected $table='tbl_cancel_membership_request';
    protected $fillable = [
        'user_id', 'ticket_number',  'reason', 'subject', 'message', 'status'
    ];
	
	public function users(){

        return $this->hasOne('App\User','id','user_id');
    }
	
	public function user_detail(){

        return $this->hasOne('App\Model\Detail','id','user_id');
    }
}
