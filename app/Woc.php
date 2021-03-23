<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Woc extends Model
{
    protected $table = 'tbl_way_of_contact';
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'name'
    ];
	
	public function contactlogs(){
		return $this->belongsTo('App\ContactLog');
	}
}
