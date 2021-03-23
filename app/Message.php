<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable=['member','subject','text','type'];
    protected $visible=['member','subject','text','type'];

}
