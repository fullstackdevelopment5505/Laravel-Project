<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class DataTree extends Model
{
	protected $table='datatree';

	protected $fillable=['id','PropertyId',	'Apn',	'Fips',	'Address',	'Address2',	'City',	'State',	'Zip',	'NewZip9',	'County',	'StreetName',	'StreetDir',	'StreetPostDir',	'StreetType',	'StreetNumber',	'Unit',	'UnitType',	'Owner',	'Owner1FirstNameMiddleInitial',	'Owner1LastName',	'Owner2FirstNameMiddleInitial',	'Owner2LastName',	'OwnerOccupied',	'LandUseDescription',	'LandUseCode',	'YearBuilt',	'SqFoot',	'Rooms',	'Bedrooms',	'Bathrooms',	'BathroomsFull',	'BathroomsPartial',	'LotSize',	'PoolType',	'AssessedTotalValue',	'SalePrice',	'LastSaleDate',	'LastMarketSaleRecordingDate',	'status','Owner1FirstName','OwnerLastname1','MktTotalValue','MailCity','MailState','MailZZIP9','SitusHouseNumber'];

	protected $hidden=['updated_at'];


    public function property_image()
    {
        return $this->hasOne('App\Model\Image','user_id','PropertyId')->where('type','3');
    }
	
	public function user_property(){
        return $this->hasOne('App\Model\UserProperty','property_id','id')->where('user_id',Auth::id());
    }

}
