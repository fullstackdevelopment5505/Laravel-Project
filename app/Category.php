<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='tbl_category';

    protected $fillable = [
        'id','category_url','name'
    ];

	public function news()
    {
        return $this->belongsTo('App\Model\News','category');

    }
	public function newsList()
    {
        return $this->hasMany('App\Model\News','category','id');

    }
}
