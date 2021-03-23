<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyDetail extends Model
{
    protected $table='property_detail';

	protected $fillable=['property_id',	'property_report_status',	'property_address',	'owner_information',	'location_information',	'site_information',	'property_characteristics',	'tax_information',	'county_recording_history',	'owner_transfer_information',	'last_market_sale_information',	'prior_sale_information'];

	protected $hidden=['id'];
}
