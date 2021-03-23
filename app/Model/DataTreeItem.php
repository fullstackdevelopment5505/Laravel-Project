<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DataTreeItem extends Model
{
    protected $table='data_tree_items';

    protected $fillable=['id','amount','entry_user_id','gl_code','batch_no','brand','report','qty','created_at','status'];

    protected $attributes = [
        'gl_code' => 'GL-101',
     ];
}
