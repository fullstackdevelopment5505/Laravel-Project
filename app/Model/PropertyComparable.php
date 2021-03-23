<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertyComparable extends Model
{
    protected $fillable = [
      'property_id', 'property_report_status', 'comparable_properties', 'comparable_properties_summary', 'subject_property', 'filters'
    ];
}
