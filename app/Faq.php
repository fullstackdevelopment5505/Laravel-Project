<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table='tbl_faqs';

    protected $fillable=[ 'id', 'answer', 'question', 'posted_by','posted_on'];
}
