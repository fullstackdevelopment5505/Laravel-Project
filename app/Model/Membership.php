<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table='membership_master';
    protected $fillable = [
        'id','page_title', 'type', 'description','login_users','amount'
    ];
    public function customer()
    {
        return $this->belongsTo('App\Model\Customer','membership_id');

    }
}
