<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table='customers_master';
    protected $fillable = [
        'email',  'type', 'first_name', 'last_name', 'company_name', 'phone_number', 'city', 'state', 'country', 'address', 'postal_code', 'username', 'custid'
    ];
    protected $visible=['id','email','type', 'first_name', 'last_name', 'company_name', 'phone_number', 'city', 'state', 'country', 'address', 'postal_code', 'username', 'custid'
];
     public function membership()
    {
        return $this->hasOne('App\Model\Membership','id','membership_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'sale_manager');
    }
    
}
