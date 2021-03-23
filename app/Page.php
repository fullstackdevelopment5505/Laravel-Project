<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table='tbl_pages';
    protected $fillable=['id','page_name','page_title','page_slug','extra_content','page_content','page_metadata','deleted_at'];
}
