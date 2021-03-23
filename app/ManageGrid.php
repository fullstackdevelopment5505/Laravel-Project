<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManageGrid extends Model
{
    protected $table='tbl_manage_grid';
	
	protected $fillable=['user_id',	'grid_total_number', 'type',	'column_status',	'selected_column',	'column_name'];

	/* type=> 1:warm prospects, 2: hot prospects, 3: purchased view records, 4: saved_search: 5: kickstarter, 6: Trash, 7:purchased-view all records page*/
	
	protected $hidden=['id'];
}
