<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PropertyReminder extends Model
{
    use Notifiable;
    protected $table='property_reminders';

	protected $fillable = [
        'user_id','user_property_id','notes','title','start_date','start_time','status'
    ];

    public function users()
    {
         return $this->hasOne('App\User','id','user_id')->select('id','email');
    }

    public function datatree()
    {
        return $this->hasOne('App\Model\DataTree','id','user_property_id');
    }

    public function properties()
    {
         return $this->hasMany('App\Model\UserProperty','id','user_property_id')->join('datatree','datatree.id','=','property_id')->select('user_property.id','trash','property_id','PropertyId');
    }
}
