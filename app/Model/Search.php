<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table='search';

    protected $fillable = [
        'user_id', 
        'country', 
        'state',   
        'land',    
        'residentials',   
        'commercial', 
        'owner',   
        'exemption',   
        'occupancy', 
        'sales_from', 
        'sales_to',    
        'mortgage_amount_f',  
        'mortgage_amount_t',  
        'mortgage_date_f',
        'mortgage_date_t', 
        'mortgage_type',  
        'interest_rate_f',
        'interest_rate_t', 
        'max_open_lien',   
        'equity_from',
        'equity_to',  
        'listing_status',  
        'listing_amount_f',    
        'listing_amount_t',    
        'foreclosure_status', 
        'foreclosure_date_f', 
        'foreclosure_date_t', 
        'foreclosure_amount_f',    
        'foreclosure_amount_t',   
        'finance_scores', 
        'owner_owned_f',  
        'owner_owned_t', 
        'hoa', 
        'phone', 
        'email',
        'other', 
        'status'
    ];


    public function user($value='')
    {
        return $this->belongsTo('App\User','user_id','id');
    }

}
