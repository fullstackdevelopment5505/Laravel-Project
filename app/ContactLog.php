<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use Carbon\Carbon;

class ContactLog extends Model
{
   use  Notifiable;
   
   protected $table = 'tbl_contact_logs';
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','user_id', 'user_property_id', 'type', 'woc_id','description','contact_date','contact_time'
    ];
	
	/* public function property()
	{
		return $this->belongsToMany('App\Model\UserProperty','user_property_id');
	} */
	
	public function getContactDateAttribute($value)
    {
		return Carbon::parse($value)->format('d-M-Y');
	}
	
	public function woc()
    {
    	return $this->hasOne('App\Woc','id','woc_id');
    }
}
