<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class dataTree extends Model
{
    protected $table='datatree';

	protected $fillable=['Fips','SalePrice','PropertyId','PropertyId','LastSaleDate','Zip','MktTotalValue'];

	protected $hidden=['Fips','Address2','City','Zip','NewZip9','StreetName','StreetDir','StreetPostDir','StreetType','StreetNumber','Unit','UnitType','Owner','Owner1FirstNameMiddleInitial','Owner1LastName','Owner2FirstNameMiddleInitial','Owner2LastName','OwnerOccupied','LandUseDescription','LandUseCode','SqFoot','Rooms','Bedrooms','Bathrooms','BathroomsFull','BathroomsPartial','LotSize','PoolType','AssessedTotalValue','LastSaleDate'];  
	
	protected $casts = [
		'MktTotalValue' => 'double',
	];
	public function getMailZZIP9Attribute($data) {
        
        // add logic to correctly format number here
        // a more robust ways would be to use a regular expression
		if(is_numeric($data)){
			
			return substr($data, 0, 5)."-".substr($data, 5, 4);
		}
        return $data;
    }
	
	public function user_property(){

        return $this->hasOne('App\Model\UserProperty','property_id','id')->where('user_id',Auth::id());

    }
}
