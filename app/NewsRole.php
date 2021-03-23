<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsRole extends Model
{
    protected $table='tbl_news_roles';

	protected $fillable=['id','role'];
	
	public function news()
    {
        return $this->belongsTo('App\Model\News','posted_by_role','id');

    }
}
