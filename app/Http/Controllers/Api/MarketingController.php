<?php

namespace App\Http\Controllers\Api;

use App\Email;
use App\Phone;
use App\Jobs\SendEmailRequest;
use App\Jobs\SendPhoneRequest;
use Anam\PhantomMagick\Converter;
use App\Http\Controllers\Api\MainController;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\MailNotify;
use App\Notifications\ContactRequest;
use App\User;
use App\Model\DataTree;
use App\Model\UserProperty;
use Validator, Response, DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Cartalyst\Stripe\Stripe;
use App\Model\PropertiesJob;
use App\Model\PropertyGroupName;
use App\Model\PropertyResultId;
use Carbon\Carbon;
use App\Model\Points;
use App\Configuration;
use DataTables;
use App\Model\ApiMode;

class MarketingController extends MainController
{ 
	private $datafinder_key,$datafinder_token,$accurate_append_key;

	public function __construct() 
	{
		$data = ApiMode::where('api_name','datafinder')->first();
		$this->datafinder_key   = env('DATAFINDER_TEST_KEY');
		$this->datafinder_token = env('DATAFINDER_TEST_TOKEN');
		if( isset($data) && $data->mode == 1){
			$this->datafinder_key   = env('DATAFINDER_LIVE_KEY');
			$this->datafinder_token = env('DATAFINDER_LIVE_TOKEN');
		} 
		
		$dataAp = ApiMode::where('api_name','accurate_append')->first();
        $this->accurate_append_key   = env('ACCURATE_APPEND_TEST_KEY');
		if( isset($dataAp) && $dataAp->mode == 1){
			$this->accurate_append_key   = env('ACCURATE_APPEND_LIVE_KEY');
		} 
    }
	
	public function marketingDataFound(Request $request){
		$validator = Validator::make($request->all(),[
			'property_id' => 'required',
			'type' => 'required',
			'record_type' => 'required',
		]);

		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}  
		$request_type = $request->get( 'type' );
		$record_type = $request->get( 'record_type' );
		
		$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );
		
		$user_properties_count = DB::table('user_property')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count(); 
		
		if($user_properties_count == 0){
			
			return $this->getResponse(422,'Invalid property id',0);
		}
		if($record_type == 'datatree'){
			if($request_type == 'email'){
			
				$properties_arr=UserProperty::join('datatree','datatree.id','=','user_property.property_id')
				->select('email_search_flag','user_property.email','user_property.id as property_id','user_property.status','MailHouseNumber','MailCity',
				DB::raw('(CASE WHEN LENGTH(SitusZipCode) = 4 THEN  CONCAT(\'0\',SitusZipCode) ELSE SitusZipCode END) as zip'),'SitusHouseNumber',
				'SitusStreetName','SitusMode','Owner1FirstName as firstname','OwnerLastname1 as lastname','SitusCity as city','SitusState as state')
				->where('property_type','datatree')
				->where('user_id', Auth::id())->whereIN('user_property.id',$property_id_in_arrays)->get();
			}
			
			if($request_type == 'phone'){
				
				$properties_arr=UserProperty::join('datatree','datatree.id','=','user_property.property_id')
				->select('phone','phone_search_flag','user_property.id as property_id','user_property.status',
				DB::raw('(CASE WHEN LENGTH(SitusZipCode) = 4 THEN  CONCAT(\'0\',SitusZipCode) ELSE SitusZipCode END) as zip'),
				'SitusHouseNumber','SitusStreetName','SitusMode','Owner1FirstName as firstname','MailCity','MailState','MailZZIP9',
				'OwnerLastname1 as lastname','OwnerMailingName','SitusCity as city','SitusState as state','SitusHouseNumber as address',
				'MailingStreetAddress','MailHouseNumber','MailHouseNumber2','MailStreetName','AlternateMailingCity')
				->where('property_type','datatree')
				->where('user_id', Auth::id())->whereIN('user_property.id',$property_id_in_arrays)->get();
			}
			if($request_type == 'postcard'){
				
				$properties_arr=UserProperty::join('datatree','datatree.id','=','user_property.property_id')
				->select('user_property.id as property_id','user_property.status','OwnerMailingName',
				DB::raw('(CASE WHEN CONCAT(MailHouseNumber,\' \', MailStreetName) <> "" THEN  "1" ELSE "0" END) as address_flag'),
				DB::raw('CONCAT(MailHouseNumber,\' \', MailStreetName) as address'),'MailCity',
				'MailState','MailZZIP9')->where('user_id', Auth::id())->where('property_type','datatree')
				->whereIN('user_property.id',$property_id_in_arrays)->get();
			}
			
		}
		
		if($record_type == 'import'){
			if($request_type == 'email'){
			
				$properties_arr=UserProperty::select('email_search_flag','email','user_property.id as property_id','status',
				DB::raw('(CASE WHEN LENGTH(zip) = 4 THEN  CONCAT(\'0\',zip) ELSE zip END) as zip'),'address','firstname','lastname','city','state')
				->where('user_id', Auth::id())->where('property_type','import')->whereIN('user_property.id',$property_id_in_arrays)->get();
			}
			
			if($request_type == 'phone'){
				
				$properties_arr=UserProperty::select('phone','phone_search_flag','user_property.id as property_id','status',
				DB::raw('(CASE WHEN LENGTH(zip) = 4 THEN  CONCAT(\'0\',zip) ELSE zip END) as zip'),
				'firstname','lastname','city','state','address')
				->where('property_type','import')
				->where('user_id', Auth::id())->whereIN('user_property.id',$property_id_in_arrays)->get();
			}
			if($request_type == 'postcard'){
				
				$properties_arr=UserProperty::select('user_property.id as property_id','status',
				DB::raw('(CASE WHEN address <> "" THEN  "1" ELSE "0" END) as address_flag'),
				DB::raw('CONCAT(firstname, \' \', lastname) as OwnerMailingName'),'city as MailCity',
				'state as MailState','address','zip as MailZZIP9')
				->where('property_type','import')
				->where('user_id', Auth::id())
				->whereIN('user_property.id',$property_id_in_arrays)->get();
			}
			
		}
		
		return $this->getResponseMultipledata(200,'data',$properties_arr,(Object)array('total'=>count($property_id_in_arrays),'found_data'=>$properties_arr->count())); 
	}
	
}