<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{
    protected $table='tbl_saved_cards';

    protected $fillable = [
        'user_id','month', 'year', 'card_no','card_no_last','brand'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];
}
