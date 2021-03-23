<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DataTreeModel extends Model
{
    protected $table='data_trees';

	protected $fillable=['id','amount','entry_user_id','gl_code','batch_no','brand'];
}
