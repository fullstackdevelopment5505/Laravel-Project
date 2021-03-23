<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Membership;

class Member extends Model
{
    protected $table='tbl_membership';

    protected $fillable = [
        'user_id', 'subscriptions_id', 'trans_id', 'membership_type', 'expire_at'
    ];

    public function getMembershipTypeAttribute($value)
    {
        $data = Membership::where('id',$value)->pluck('type');
		if(isset($data[0])){
			return $data[0];
		}
		return '';
    }
}
