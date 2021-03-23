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
use Maatwebsite\Excel\Facades\Excel;
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
use App\Model\UsersUploadedData;
use App\Model\UsersUploadedDataGroup;
use Carbon\Carbon;
use App\Model\Points;
use App\Configuration;
use DataTables;
use App\Model\ApiMode;
use App\Exports\UserUploadExcelExport;
use App\Imports\UserDataImport;
use App\Model\PropertyResultId;
use App\Model\FoundData;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Http\UploadedFile;

class UserUplodedDataController extends MainController
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
	
	public function RenameGroupName(Request $request)
    {
		
		$validator = Validator::make($request->all(), [ 
            'group_id'  	=> 	'required',
            'new_group_name' => 'required'
        ]);   
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		
		$user_id 		= 	Auth::id();
		$group_id		=  	$request->get('group_id');
		$new_group_name = 	$request->get('new_group_name');
		
		$dataTotal = PropertyResultId::where([['user_id',Auth::id()],['result_id',$group_id],['property_type','import']])
					->get()->count();
					
		if($dataTotal == 0){
			
			return $this->getResponse(422,'Invalid group id!',0);
		}
		$groupname_new  = preg_replace('/[+%_-]/s','',$new_group_name);
		
		$result = PropertyResultId::where([['user_id',Auth::id()],['property_type','import']])->pluck('purchase_group_name');
		
		$arr =  (array)$result;
		$groupname_exists  =  array_values($arr);
		if(in_array($groupname_new,$groupname_exists[0])){
			
			return $this->getResponse(422,'Group name already exists',(Object)[],0);
		}
		
		/* $updated = UsersUploadedDataGroup::where([['user_id',$user_id],['id',$group_id]])->update(array(
			'group_name' 	  =>  $new_group_name,
		)); */
		$updated = PropertyResultId::where([['user_id',Auth::id()],['result_id',$group_id],['property_type','import']])
			       ->update(array('purchase_group_name' => $new_group_name)); 
		
		if($updated){
			
			return $this->getResponse(200,'Group name changed successfully!');
		}

		return $this->getResponse(422,'something went wrong,please try after some time!',0);
		
	}
	public function createApiUrl($id, $search_methods, $table_name, $service ) {
        // api details 
        $k2 = $this->datafinder_key;
        $DataFinderUrl = "https://api.datafinder.com/qdf.php?service=" . $service . "&k2="; 
        $Token = $this->datafinder_token;
      
        // examples of how url should look
        // $searchUrl = $DataFinderUrl . $k2 . '&d_' . $search_methods[0] . '=' . $input1 . '&d_' . $search_methods[1] . '=' . $input2 . '&d_' . $search_methods[2] . '=' . $input3;
        // $searchUrl = $DataFinderUrl . $k2 . '&d_address=' . $address . '&d_city=' . $city . "&d_state=" . $state;

        // variables necessary for url creation 
        $searchUrl = $DataFinderUrl . $k2; 
		
		$data = UserProperty::select('firstname as first','lastname as last','address','city','state','zip')
		       ->where([['user_id',Auth::id()],['id',$id],['property_type','import']])->first();
		
        // create the url to call 
        for ($i = 0; $i < count($search_methods); $i++) {
            if ($search_methods[$i] === 'first' || $search_methods[$i] === 'last' || $search_methods[$i] === 'city' 
			|| $search_methods[$i] === 'state' || $search_methods[$i] === 'zip' || $search_methods[$i] === 'address') {
				
               // $input = $hf->requestSql($table_name, $search_methods[$i], $id);
                $tempSearchVar = $search_methods[$i]; // remove either 1 or 2 from end of string 
                $searchUrl .= '&d_' . $tempSearchVar . '=' . $data->$tempSearchVar;
            }
        }

        // fill in blank spaces with %20 
        $searchUrl = str_replace(' ', '%20', $searchUrl);
        
        // return the url 
        return $searchUrl;
    }
	public function getRecordsDemographData($id)
    {
		
		$property_exists = UserProperty::where([['user_id',Auth::id()],['id',$id],['property_type','import']])->get()->count();
		if($property_exists == 0){
			
			return $this->getResponse(422,'Invalid property id!',0);
		}
		$res = UserProperty::find($id);
		if($res->demograph_reponse !=''){
			
			return $this->getResponse(200,'Data saved',(Object)array('response'=>[],'data'=>$res),1);
			
		}	
		
		$search_methods = array('first', 'last', 'address', 'city', 'state', 'zip'); // search parameters
		$tempUrl = $this->createApiUrl($id, $search_methods, 'user_property', 'demograph');
		
		$client = new Client();
		try {
			$response = $client->request('GET', $tempUrl);
			$result = $response->getBody()->getContents();
		
			// convert json string to arary 
			$jsonString 	= json_decode($result, true); // decode the json string
			$data = $jsonString['datafinder'];
			
			
			if (array_key_exists('results', $data)) { $resultData = $data['results'][0]; }
			if (array_key_exists('input-query', $data)) { $inputQuery = $data['input-query']; }
			//echo "<pre>"; print_r($jsonString); die;
			if(isset($resultData)){
				if (array_key_exists('FirstName', $inputQuery)) { $FirstNameinput= $inputQuery['FirstName']; }
				if (array_key_exists('LastName', $inputQuery)) { $LastNameinput= $inputQuery['LastName']; }
				if (array_key_exists('Address', $inputQuery)) { $Addressinput= $inputQuery['Address']; }
				if (array_key_exists('City', $inputQuery)) { $Cityinput= $inputQuery['City']; }
				if (array_key_exists('State', $inputQuery)) { $Stateinput= $inputQuery['State']; }
				if (array_key_exists('PostalCode', $inputQuery)) { $PostalCodeinput= $inputQuery['PostalCode']; }
				if (array_key_exists('HouseNum', $inputQuery)) { $HouseNum= $inputQuery['HouseNum']; }
				if (array_key_exists('Street', $inputQuery)) { $Street= $inputQuery['Street']; }
				
				if (array_key_exists('FirstName', $resultData)) { $FirstName= $resultData['FirstName']; }
				if (array_key_exists('LastName', $resultData)) { $LastName= $resultData['LastName']; }
				if (array_key_exists('Address', $resultData)) { $Address= $resultData['Address']; }
				if (array_key_exists('City', $resultData)) { $City= $resultData['City']; }
				if (array_key_exists('State', $resultData)) { $State= $resultData['State']; }
				if (array_key_exists('Zip', $resultData)) { $Zip= $resultData['Zip']; }
				if (array_key_exists('DOB', $resultData)) { $DOB= $resultData['DOB']; }
				if (array_key_exists('AgeRange', $resultData)) { $AgeRange=$resultData['AgeRange']; }
				if (array_key_exists('EthnicGroup', $resultData)) { $EthnicGroup=$resultData['EthnicGroup']; }
				if (array_key_exists('Language', $resultData)) { $Language=$resultData['Language']; }
				if (array_key_exists('Religion', $resultData)) { $Religion=$resultData['Religion']; }
				if (array_key_exists('NumberOfChildren', $resultData)) { $NumberOfChildren=$resultData['NumberOfChildren']; }
				if (array_key_exists('Education', $resultData)) { $Education=$resultData['Education']; }
				if (array_key_exists('Occupation', $resultData)) { $Occupation=$resultData['Occupation']; }
				if (array_key_exists('Gender', $resultData)) { $Gender=$resultData['Gender']; }
				if (array_key_exists('PresenceOfChildren', $resultData)) { $PresenceOfChildren=$resultData['PresenceOfChildren']; }
				if (array_key_exists('SingleParent', $resultData)) { $SingleParent=$resultData['SingleParent']; }
				if (array_key_exists('SeniorAdultInHousehold', $resultData)) { $SeniorAdultInHousehold=$resultData['SeniorAdultInHousehold']; }
				if (array_key_exists('YoungAdultInHousehold', $resultData)) { $YoungAdultInHousehold=$resultData['YoungAdultInHousehold']; }
				if (array_key_exists('WorkingWoman', $resultData)) { $WorkingWoman=$resultData['WorkingWoman']; }
				if (array_key_exists('SOHOIndicator', $resultData)) { $SOHOIndicator=$resultData['SOHOIndicator']; }
				 if (array_key_exists('BusinessOwner', $resultData)) { $BusinessOwner=$resultData['BusinessOwner']; }
				if (array_key_exists('MaritalStatusInHousehold', $resultData)) { $MaritalStatusInHousehold=$resultData['MaritalStatusInHousehold']; }
				if (array_key_exists('HomeOwnerRenter', $resultData)) { $HomeOwnerRenter=$resultData['HomeOwnerRenter'];
				}
				if (array_key_exists('OccupationDetail', $resultData)) { $OccupationDetail=$resultData['OccupationDetail']; }
				
				$updated = UserProperty::where('id', $id)->update(array(
				'OccupationDetail' => isset($OccupationDetail) ? $OccupationDetail : '',
				'HomeOwnerRenter' => isset($HomeOwnerRenter) ? $HomeOwnerRenter : '',
				'MaritalStatusInHousehold' => isset($MaritalStatusInHousehold) ? $MaritalStatusInHousehold : '',
				'BusinessOwner' => isset($BusinessOwner) ? $BusinessOwner : '',
				'SOHOIndicator' => isset($SOHOIndicator) ? $SOHOIndicator : '',
				'YoungAdultInHousehold' => isset($YoungAdultInHousehold) ? $YoungAdultInHousehold : '',
				'SeniorAdultInHousehold' => isset($SeniorAdultInHousehold) ? $SeniorAdultInHousehold : '',
				'SingleParent' => isset($SingleParent) ? $SingleParent : '',
				'PresenceOfChildren' => isset($PresenceOfChildren) ? $PresenceOfChildren : '',
				'Gender' => isset($Gender) ? $Gender : '',
				'Occupation' => isset($Occupation) ? $Occupation : '',
				'Education' => isset($Education) ? $Education : '',
				'NumberOfChildren' => isset($NumberOfChildren) ? $NumberOfChildren : '',
				'Religion' => isset($Religion) ? $Religion : '',
				'Language' => isset($Language) ? $Language : '',
				'EthnicGroup' => isset($EthnicGroup) ? $EthnicGroup : '',
				'AgeRange' => isset($AgeRange) ? $AgeRange : '',
				'DOB' => isset($DOB) ? $DOB : '',
				'demograph_reponse' => $result,
				)); 
				
				if($updated){
					
					
					$found_data_array = array(
					'user_id'=>Auth::id(),
					'request_type'=>'import_data',
					'api_type'=>'demograph',
					'property_id'=>$id,
					'first_input'=>isset($FirstNameinput) ? $FirstNameinput : '',
					'last_input'=>isset($LastNameinput) ? $LastNameinput : '',
					'address_input'=>isset($Addressinput) ? $Addressinput : '',
					'city_input'=>isset($Cityinput) ? $Cityinput : '',
					'state_input'=>isset($Stateinput) ? $Stateinput : '',
					'zip_input'=>isset($PostalCodeinput) ? $PostalCodeinput : '',
					'house_num_input'=>isset($HouseNum) ? $HouseNum : '',
					'street_input'=>isset($Street) ? $Street : '',
					'first_result'=>isset($FirstName) ? $FirstName : '',
					'last_result'=>isset($LastName) ? $LastName : '',
					'address_result'=>isset($Address) ? $Address : '',
					'city_result'=>isset($City) ? $City : '',
					'state_result'=>isset($State) ? $State : '',
					'zip_result'=>isset($Zip) ? $Zip : '',
					'occupational_detail' => isset($OccupationDetail) ? $OccupationDetail : '',
					'home_owner_renter' => isset($HomeOwnerRenter) ? $HomeOwnerRenter : '',
					'marital_status' => isset($MaritalStatusInHousehold) ? $MaritalStatusInHousehold : '',
					'business_owner' => isset($BusinessOwner) ? $BusinessOwner : '',
					'soho_indicator' => isset($SOHOIndicator) ? $SOHOIndicator : '',
					'young_adult_in_household' => isset($YoungAdultInHousehold) ? $YoungAdultInHousehold : '',
					'senior_in_household' => isset($SeniorAdultInHousehold) ? $SeniorAdultInHousehold : '',
					'single_parent' => isset($SingleParent) ? $SingleParent : '',
					'child_presence' => isset($PresenceOfChildren) ? $PresenceOfChildren : '',
					'gender' => isset($Gender) ? $Gender : '',
					'occupation' => isset($Occupation) ? $Occupation : '',
					'education' => isset($Education) ? $Education : '',
					'num_children' => isset($NumberOfChildren) ? $NumberOfChildren : '',
					'religion' => isset($Religion) ? $Religion : '',
					'language' => isset($Language) ? $Language : '',
					'ethnic_group' => isset($EthnicGroup) ? $EthnicGroup : '',
					'age_range' => isset($AgeRange) ? $AgeRange : '',
					'dob' => isset($DOB) ? $DOB : '',
					'api_response' => $result,
					);
					//echo "<pre>"; print_r($found_data_array); die;
					$datass =FoundData::insert($found_data_array);
					
					return $this->getResponse(200,'Data saved',(Object)array('response'=>$result,'data'=>$res),1); 
				}
			}
			return $this->getResponse(200,'No data found',0);	
		} catch (RequestException $e) {
			return $this->getResponse(422,'We are having some issues in finding your properties now. Please check back after some time',0);	
		}
	}
	
	public function RecordDetail(Request $request)
    {
		$validator = Validator::make($request->all(), [ 
            'property_id'  	=> 	'required',
        ]);   
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$property_exists = UserProperty::where([['user_id',Auth::id()],['id',$request->get('property_id')],['property_type','import']])->get()->count();
		if($property_exists == 0){
			
			return $this->getResponse(422,'Invalid property id!',0);
		}
		$data = UserProperty::find($request->get('property_id'));
		
		return $this->getResponse(200,'property detail',$data,1); 
	}	
	public function DataByGroupId(Request $request){
		
		$validator = Validator::make($request->all(),[
			'group_id' => 'required',
		]);

		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}  
		$dataTotal = PropertyResultId::where([['user_id',Auth::id()],['result_id',$request->get('group_id')],['property_type','import']])->get()->count();		
		if($dataTotal == 0){
			
			return $this->getResponse(422,'Invalid group id!',0);
		}
		//$data = UsersUploadedData::with('groupname')->where('upload_data_group_id',$request->get('group_id'))->where('user_id',Auth::id())->get();
		/* 
		//$data = UsersUploadedData::with('groupname')->where('upload_data_group_id',$request->get('group_id'))->where('user_id',Auth::id())->get();
		$data = UserProperty::with('logs')->select('user_property.*')
			->join('property_result_id','property_result_id.property_id','=','user_property.id')
			->where('property_result_id.result_id',$request->get('group_id'))
			->where('user_property.result_id',$request->get('group_id'))
			->where('user_property.user_id',Auth::id())
			->where('user_property.trash','0')->get(); */
			
		$dataNameArr = PropertyResultId::where([['user_id',Auth::id()],['result_id',$request->get('group_id')],['property_type','import']])
		->groupBy('result_id')->pluck('purchase_group_name');
					
		$datatable_parameters = 	$request->get('dataTablesParameters');
		$columns              = 	array_column($datatable_parameters['columns'], 'data');
		$column_name          =     $columns[$datatable_parameters['order'][0]['column']];
		
		$start  = 	$datatable_parameters['start'];
		$draw   = 	$datatable_parameters['draw'];
		$limit 	= 	$datatable_parameters['length'];
	
		$search = 	$datatable_parameters['search']['value'];
		$order 	= 	$columns[$datatable_parameters['order'][0]['column']];
		$dir 	= 	$datatable_parameters['order'][0]['dir'];
		
		$total_q = UserProperty::with('logs')->select('user_property.*')
			->join('property_result_id','property_result_id.property_id','=','user_property.id')
			->where('property_result_id.result_id',$request->get('group_id'))
			->where('user_property.result_id',$request->get('group_id'))
			->where('user_property.user_id',Auth::id())
			->where('user_property.property_type','import')
			->where('user_property.trash','0');
			
		
		$query = UserProperty::with('logs')->select('user_property.*')
			->join('property_result_id','property_result_id.property_id','=','user_property.id')
			->where('property_result_id.result_id',$request->get('group_id'))
			->where('user_property.result_id',$request->get('group_id'))
			->where('user_property.user_id',Auth::id())
			->where('user_property.property_type','import')
			->where('user_property.trash','0');
			
		if($request->get('zip') != ''){
			$zip  = str_replace( '-' , '', $request->get('zip'));
			$zipn  =	ltrim( $zip, "0");
			$total_q->where('zip',$zipn);
			$query->where('zip',$zipn);
		}
		if($request->get('city') != ''){
		
			$total_q->where('city',$request->get('city'));
			$query->where('city',$request->get('city'));
		}
		if($request->get('state') != ''){
		
			$total_q->where('state',$request->get('state'));
			$query->where('state',$request->get('state'));
		}
		if($request->get('firstname') != ''){
			
			$total_q->where('firstname',$request->get('firstname'));
			$query->where('firstname',$request->get('firstname'));
		}
		if($request->get('lastname') != ''){
		
			$total_q->where('lastname',$request->get('lastname'));
			$query->where('lastname',$request->get('lastname'));
		}
		if($request->get('phone') != ''){
			
			$total_q->where('phone',$request->get('phone'));
			$query->where('phone',$request->get('phone'));
		}
		if($request->get('email') != ''){
		
			$total_q->where('email',$request->get('email'));
			$query->where('email',$request->get('email'));
		}	
		$recordsTotal = $total_q->orderBy($order,$dir)->count();
		if($limit > 0){
			$query->offset($start)->limit($limit);
		}else {
			$limit = $recordsTotal;
			$query->offset($start)->limit($limit);
		}
		$data_u = $query->get();
		$data = array(
            'draw' => intval($draw),
            'recordsTotal' => intval($recordsTotal),
            'recordsFiltered' => intval($recordsTotal),
            'data' => $data_u->toArray(),
            'purchase_group_name' => $dataNameArr[0],
        ); 
		return $this->getResponse(200,'Purchase group records',json_encode($data),1); 
		//return $this->getResponse(200,'Group record list',(Object)array('count'=>$data->count(),'purchase_group_name'=>$dataNameArr[0],'data'=>$data)); 
	}
	
	public function UplodedDataList(Request $request){
		
		//$data = UsersUploadedData::with('groupname')->where('user_id',Auth::id())->get();
		/* $data = UserProperty::with('logs')
				->where('user_id',Auth::id())
				->where('trash','0')
				->where('property_type', 'import')
				->orderBy('updated_at', 'desc')
				->get(); */
				
		$datatable_parameters = 	$request->get('dataTablesParameters');
		$columns              = 	array_column($datatable_parameters['columns'], 'data');
		$column_name          =     $columns[$datatable_parameters['order'][0]['column']];
		$start  = 	$datatable_parameters['start'];
		$draw   = 	$datatable_parameters['draw'];
		$limit 	= 	$datatable_parameters['length'];
		$search = 	$datatable_parameters['search']['value'];
		$order 	= 	$columns[$datatable_parameters['order'][0]['column']];
		$dir 	= 	$datatable_parameters['order'][0]['dir'];	
		
		$total_q = UserProperty::with('logs')->select('user_property.*')
			->join('property_result_id','property_result_id.property_id','=','user_property.id')
			->where('user_property.user_id',Auth::id())
			->where('user_property.property_type','import')
			->where('user_property.trash','0');
			
		$query = UserProperty::with('logs')->select('user_property.*')
			->join('property_result_id','property_result_id.property_id','=','user_property.id')
			->where('user_property.user_id',Auth::id())
			->where('user_property.property_type','import')
			->where('user_property.trash','0');
			
		if($request->get('zip') != ''){
			$zip  = str_replace( '-' , '', $request->get('zip'));
			$zipn  =	ltrim( $zip, "0");
			$total_q->where('zip',$zipn);
			$query->where('zip',$zipn);
		}
		if($request->get('city') != ''){
		
			$total_q->where('city',$request->get('city'));
			$query->where('city',$request->get('city'));
		}
		if($request->get('state') != ''){
		
			$total_q->where('state',$request->get('state'));
			$query->where('state',$request->get('state'));
		}
		if($request->get('firstname') != ''){
			
			$total_q->where('firstname',$request->get('firstname'));
			$query->where('firstname',$request->get('firstname'));
		}
		if($request->get('lastname') != ''){
		
			$total_q->where('lastname',$request->get('lastname'));
			$query->where('lastname',$request->get('lastname'));
		}
		if($request->get('phone') != ''){
			
			$total_q->where('phone',$request->get('phone'));
			$query->where('phone',$request->get('phone'));
		}
		if($request->get('email') != ''){
		
			$total_q->where('email',$request->get('email'));
			$query->where('email',$request->get('email'));
		}	
		$recordsTotal = $total_q->orderBy($order,$dir)->count();
		if($limit > 0){
			$query->offset($start)->limit($limit);
		}else {
			$limit = $recordsTotal;
			$query->offset($start)->limit($limit);
		}
		$data_u = $query->get();
		$data = array(
            'draw' => intval($draw),
            'recordsTotal' => intval($recordsTotal),
            'recordsFiltered' => intval($recordsTotal),
            'data' => $data_u->toArray()
        ); 
		return $this->getResponse(200,'All records',json_encode($data),1); 
		
		//return $this->getResponsedataCount(200,'All records',$data->count(),$data,1); 
	}
	
	public function UplodedDataByGroup(Request $request){
		
		$data = UsersUploadedData::with('groupname')->where('user_id',Auth::id())->get();
		return $this->getResponse(200,'Contact log List',$data,1); 
	}
	
	public function defaultExcelTemplate(){
		$data = [
			[
				'firstname' => '',
				'lastname' => '',
				'subject_property_address' => '',
				'unit_number' => '',
				'city' => '',
				'state' => '',
				'zip' => '',
				'apn_subject_property' => '',
				'mailing_address' => '',
				'mailing_unit_number' => '',
				'mailing_city' => '',
				'mailing_state' => '',
				'mailing_zip' => '',
				'phone' => '',
				'email' => '',
			],
			
		];
       // return Excel::download(new UsersExport, 'users.xlsx');
	   return Excel::download(new UserUploadExcelExport($data), 'upload_data_template.xlsx');
	}
	
	public function UplodedGroupList(){
		
		/* $data = UsersUploadedData::with('groupname')
			->select(DB::raw('count(upload_data_group_id) as total'),'created_at','batch_process_email','batch_process_phone','upload_data_group_id',
			DB::raw('(CASE WHEN batch_process_email = "0"  THEN  count(batch_process_email) END) as grey_flag_email'),
			DB::raw('(CASE WHEN batch_process_email = "1"  THEN  count(batch_process_email) END) as green_flag_email'),
			DB::raw('(CASE WHEN batch_process_phone = "1"  THEN  count(batch_process_phone) END) as green_flag_phone'),
			DB::raw('(CASE WHEN batch_process_phone = "0"  THEN  count(batch_process_phone) END) as grey_flag_phone'))
			->where('user_id',Auth::id())
			->groupBy('upload_data_group_id')
			->orderBy('id','desc')
			->get(); */
			
			
		$data = PropertyResultId::select(
		DB::raw('(CASE WHEN result_id > 0  THEN  0 END) as grey_flag'),
		DB::raw('(CASE WHEN result_id > 0  THEN  0 END) as teal_flag'),
		DB::raw('(CASE WHEN result_id > 0  THEN  0 END) as green_flag'),
		DB::raw('(CASE WHEN result_id > 0  THEN  0 END) as total_green_flag_e'),
		DB::raw('(CASE WHEN result_id > 0  THEN  0 END) as total_green_flag_p'),
		DB::raw('(CASE WHEN result_id > 0  THEN  0 END) as total_grey_flag_p'),
			DB::raw('(CASE WHEN result_id > 0  THEN  0 END) as total_grey_flag_e'),
		DB::raw('(CASE WHEN result_id > 0  THEN  0 END) as total_teal_flag_p'),
		DB::raw('(CASE WHEN result_id > 0  THEN  0 END) as total_teal_flag_e'),
		'id','user_id','property_id',
		DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'),'batch_process_email_status','batch_process_phone_status'
		,'purchase_group_name',DB::raw('count(result_id) as total'),'result_id')
		->where('user_id', Auth::id())
		->where('property_type', 'import')
		->where('trash', '0')
		->whereNotNull('purchase_group_name')
		->groupBy('result_id')
		->orderBy('id','desc')->get();
			
		$wordCount = $data->count();
		
		$dataArr = PropertyResultId::select('id','user_id','property_id',
		DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'),'batch_process_email_status','batch_process_phone_status',
		'purchase_group_name','result_id')->where('user_id', Auth::id())->where('trash', '0')
		->whereNotNull('purchase_group_name')
		->where('property_type', 'import')
		->orderBy('id','desc')
		->get()
		->toArray();
		//print_r($data->toArray() );
		$flagArr = [];
		
		
		$datan =[];

		foreach($data as $key => $val){
			$totalGrey = 0;
			$totalTeal = 0;
			$totalGreen = 0;
			$totalGreyE = 0;
			$totalGreyP = 0;
			$green_e =0;
			$green_p =0;
			$tt_ee = 0;
			foreach($dataArr as $key => $value){
				
				if($val->result_id == $value['result_id']){
					
					if($value['batch_process_email_status']=="1" ){
					
						$totalGreyE = $totalGreyE+1;
					}
					
					if( $value['batch_process_phone_status']=="1" ){
					
						$totalGreyP = $totalGreyP+1;
					}
					
					if($value['batch_process_phone_status']=="3" || $value['batch_process_email_status']=="3" || $value['batch_process_phone_status']=="2" || $value['batch_process_email_status']=="2" ){
						
						$totalGreen = $totalGreen+1;
						
					}
					
					if($value['batch_process_phone_status']=="3"  || $value['batch_process_phone_status']=="2" ){
						
						$green_e = $green_e+1;
						
					}
					if( $value['batch_process_email_status']=="3"  || $value['batch_process_email_status']=="2" ){
						
						$green_p = $green_p+1;
						
					}
					
					
				}
				$totalGrey_e = $val->total-$green_e;
				$totalGrey_p = $val->total-$green_p;
				//$totalGrey = $val->total-$totalGreen;
				$totalGrey = $totalGrey_e+$totalGrey_p;
				$green_total_both = $green_e+$green_p;
			}
			//$totalGrey = $totalGreyE+$totalGreyP;
			$overall_total = 2*$val->total;
			if($green_total_both == $overall_total){
				$val['green_flag']=1;
			}
			if($green_total_both < $overall_total && $totalGrey != $overall_total){
				$val['teal_flag']=1;
			}
			if($totalGrey == $overall_total){
				$val['grey_flag']=1;
			}
			$val['total_green_flag_e']=$green_e;
			$val['total_grey_flag_e']=$totalGrey_e;
			$val['total_teal_flag_e']=$totalTeal;
			$val['total_green_flag_p']=$green_p;
			$val['total_grey_flag_p']=$totalGrey_p;
			$val['total_teal_flag_p']=$totalTeal;
			//$flagArr[] = (object)$val;
			//$flagArr->push($val);
			array_push($flagArr,$val);
		}
		if($wordCount>0){
			array_push($datan,$flagArr);
			//$datan->push($flagArr);
		}
			
			
		return $this->getResponse(200,'Group list records',$flagArr,1); 
	}
	
	
	public function ImportUserData(Request $request){
		$validator = Validator::make($request->all(),[
			'file' => 'required',
		]);

		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}   
		$extensions = array("xls","xlsx");
		$file = $request->file('file');
		$extension = $file->getClientOriginalExtension();
		if(!in_array($extension,$extensions)){
			return $this->getResponse(422,'The file must be a file of type: xls, xlsx.',[],0);
		}
		$purchase_group_name = date('Ymd') . '-' . time() . '-' . Auth::id(); 
					
		if($request->get('group_name') != ''){
			
			$purchase_group_name = $request->get('group_name');
			$groupname  = preg_replace('/[+%_-]/s','',$purchase_group_name);
		
			//$result = UsersUploadedDataGroup::where('user_id',Auth::id())->pluck('group_name');
			$result = PropertyResultId::where('user_id',Auth::id())->where('property_type','import')->groupBy('result_id')->pluck('purchase_group_name');
			$arr =  (array)$result;
			$groupname_exists  =  array_values($arr);
			if(in_array($purchase_group_name,$groupname_exists[0])){
				
				return $this->getResponse(422,'Group name already exists',(Object)[],0);
			}
		} 
		//echo $group_name; die;
		$purchasePriceData 	= 	Configuration::where('type','purchase_record_price')->first();
		$per_property_rate = 	(isset($purchasePriceData->price) && $purchasePriceData->price!='')  ? $purchasePriceData->price : 0;
		
		$import = new UserDataImport($purchase_group_name,$per_property_rate);
		$headings = (new HeadingRowImport)->toArray($request->file('file'));
		$error = [];
		
		if(isset($headings[0][0])){
			
			 $headers = $headings[0][0];
			
			if(!in_array("firstname",$headers) || !in_array("lastname",$headers) || !in_array("subject_property_address",$headers)
				|| !in_array("unit_number",$headers) || !in_array("city",$headers) || !in_array("state",$headers)
		        || !in_array("zip",$headers)|| !in_array("apn_subject_property",$headers)|| !in_array("mailing_address",$headers)
			    || !in_array("mailing_unit_number",$headers) || !in_array("mailing_city",$headers) || !in_array("phone",$headers)
			   || !in_array("mailing_state",$headers) || !in_array("mailing_zip",$headers) || !in_array("email",$headers))
			{
				array_push($error,'true');
			}
		}
		
		if(in_array('true',$error)){
			
			return $this->getResponse(422,'Kindly download our template below and then re-upload. Thank you!',[],0);
		}
		try {
			$data =  Excel::import($import,$request->file('file'));
			$total_imported = count($import->getRowCount());
			if($total_imported == 0){
				
				return $this->getResponse(422,'No data imported!',(Object)array('total'=>$total_imported),0);
			}
			return $this->getResponse(200,'Imported Records',(Object)array('total'=>$total_imported,'data'=>$import->getRowCount()));
		}
		catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
			 $failures = $e->failures();
			 $errors=[];
			 $message=[];
			 foreach ($failures as $failure) {
				$row = $failure->row();
				$rowE = $row-1;
				//$errors[] = $failure->errors();
				
			
				$failure->row(); // row that went wrong
				$attribute = $failure->attribute(); // either heading key (if using heading row concern) or column index
				if($attribute=='email'){
					$errors['email'] = $failure->errors();
					$message['email']['row'] = "Your excel has an error at row ".$rowE;
				}
				if($attribute=='phone'){
					$errors['phone'] = $failure->errors();
					$message['phone']['row'] = "Your excel has an error at row ".$rowE;
				}
				$failure->errors(); // Actual error messages from Laravel validator
				$failure->values(); // The values of the row that has failed.
				
			}
			return $this->getResponse(422,array_merge($errors['email'],$errors['phone']),[],0);
		}
	}
	
}