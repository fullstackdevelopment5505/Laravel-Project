<?php

namespace App\Http\Controllers\Api;

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
use App\Model\PropertyGroupName;
use App\Model\PropertyResultId;
use Carbon\Carbon;
use DataTables;
use App\Model\ApiMode;

class DataFinderController extends MainController
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
	public function createDatafinderUrl($id, $type, $search_methods, $table_name, $service ) {
        // api details
        $k2 = $this->datafinder_key;
        $DataFinderUrl = "https://api.datafinder.com/qdf.php?service=" . $service . "&k2=";
        $Token = $this->datafinder_token;

        // variables necessary for url creation
        $searchUrl = $DataFinderUrl . $k2;

		if($type == 'datatree'){

			$data = DB::table('datatree')->select('SitusHouseNumber','SitusDirection','SitusStreetName','SitusMode','Owner1FirstName as first','OwnerLastname1 as last','SitusMode','SitusPostDirection','SitusUnitNumber','SitusCity as city','SitusState as state','SitusZipCode as zip','SitusHouseNumber as address')
			->where('id', '=', $id)->first();

			$data->address  = $data->SitusHouseNumber." ".$data->SitusDirection." ".$data->SitusStreetName." ".$data->SitusMode." ".$data->SitusPostDirection." ".$data->SitusUnitNumber." ".$data->city." ".$data->state." ".$data->zip;
		}
		if($type == 'user_imported'){
			$data = UserProperty::select('firstname as first','lastname as last','address','city','state','zip')
			->where('user_id',Auth::id())
			->where('id',$id)
			->first();

		}

        // create the url to call
        for ($i = 0; $i < count($search_methods); $i++) {
            if ($search_methods[$i] === 'first' || $search_methods[$i] === 'last' || $search_methods[$i] === 'city' || $search_methods[$i] === 'state' || $search_methods[$i] === 'zip' || $search_methods[$i] === 'address') {

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
	public function getDatafinderData(Request $request){

		$validator = Validator::make($request->all(), [
            'property_id'=> 'required',
            'type'       => 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$type = $request->get('type');
		$property_id = $request->get('property_id');
		$resultData = [];
		$resultDataLifeint = [];
		$resultDataFinHou = [];
		$resultDataZip4Demog = [];
		$user_property_id = 0;
		$demographUrl='';
		$lifeintrUrl='';
		$zip4Url='';
		$finhouseUrl='';
		if($type=='datatree'){
			$dataTree = DataTree::select('datatree.id as datatree_id','user_property.id as prop_id')->join('user_property','user_property.property_id','=','datatree.id')
			->where('user_id',Auth::id())
			->where('datatree.PropertyId',$property_id)
			->first();
			//echo "<pre>"; print_r($dataTree);
			//die;
			if($dataTree){
				$user_property_id  = $dataTree->prop_id;
				$search_methods = array('first', 'last', 'address', 'city', 'state', 'zip'); // search parameters
				/* demograph api */

				$demographUrl = $this->createDatafinderUrl($dataTree->datatree_id, $type, $search_methods, 'user_property', 'demograph');

				$client = new Client();
				$response = $client->request('GET', $demographUrl);
				$result_demograph = $response->getBody()->getContents();
				// convert json string to arary
				$jsonString 	= json_decode($result_demograph, true); // decode the json string
				$data = $jsonString['datafinder'];
				if (array_key_exists('results', $data)) { $resultData = $data['results'][0]; }

				/* Lifestyle and Interests */
				$lifeintrUrl = $this->createDatafinderUrl($dataTree->datatree_id, $type, $search_methods, 'user_property', 'lifeint');
				$client = new Client();
				$lifeintresponse = $client->request('GET', $lifeintrUrl);
				$result_lifeintr = $lifeintresponse->getBody()->getContents();
				// convert json string to arary
				$jsonStringlife 	= json_decode($result_lifeintr, true); // decode the json string
				$data_lifeint = $jsonStringlife['datafinder'];
				if (array_key_exists('results', $data_lifeint)) { $resultDataLifeint = $data_lifeint['results'][0]; }

				/* Financial, Household and Auto */
				$finhouseUrl = $this->createDatafinderUrl($dataTree->datatree_id, $type, $search_methods, 'user_property', 'finhouse');
				$client = new Client();
				$finhouseresponse = $client->request('GET', $finhouseUrl);
				$result_finhouse = $finhouseresponse->getBody()->getContents();
				// convert json string to arary
				$jsonStringfinhouse 	= json_decode($result_finhouse, true); // decode the json string
				$data_finhouse = $jsonStringfinhouse['datafinder'];
				if (array_key_exists('results', $data_finhouse)) { $resultDataFinHou = $data_finhouse['results'][0]; }

				/* Zip 4 Demographics  */
				$zip4Url = $this->createDatafinderUrl($dataTree->datatree_id, $type, $search_methods, 'user_property', 'zip4');
				$client = new Client();
				$zip4response = $client->request('GET', $zip4Url);
				$result_zip4 = $zip4response->getBody()->getContents();
				// convert json string to arary
				$jsonStringzip4	= json_decode($result_zip4, true); // decode the json string
				$data_zip4 = $jsonStringzip4['datafinder'];
				if (array_key_exists('results', $data_zip4)) { $resultDataZip4Demog = $data_zip4['results'][0]; }

			}else{
			 return $this->getResponse(422,'Invalid request!',[],0);
			}
		}
		if($type=='user_imported'){

			$property = UserProperty::where('user_id',Auth::id())->where('id',$property_id)->first();

			if($property){

				$user_property_id  = $property->id;

				$search_methods = array('first', 'last', 'address', 'city', 'state', 'zip'); // search parameters
				/* demograph api */
				$demographUrl = $this->createDatafinderUrl($property->id, $type, $search_methods, 'user_property', 'demograph');
				$client = new Client();
				$response = $client->request('GET', $demographUrl);
				$result_demograph = $response->getBody()->getContents();
				// convert json string to arary
				$jsonString 	= json_decode($result_demograph, true); // decode the json string
				$data = $jsonString['datafinder'];
				if (array_key_exists('results', $data)) { $resultData = $data['results'][0]; }

				/* Lifestyle and Interests */
				$lifeintrUrl = $this->createDatafinderUrl($property->id, $type, $search_methods, 'user_property', 'lifeint');
				$client = new Client();
				$response = $client->request('GET', $lifeintrUrl);
				$result_lifeintr = $response->getBody()->getContents();
				// convert json string to arary
				$jsonStringlife 	= json_decode($result_lifeintr, true); // decode the json string
				$data_lifeint = $jsonStringlife['datafinder'];
				if (array_key_exists('results', $data_lifeint)) { $resultDataLifeint = $data_lifeint['results'][0]; }

				/* Financial, Household and Auto */
				$finhouseUrl = $this->createDatafinderUrl($property->id, $type, $search_methods, 'user_property', 'finhouse');
				$client = new Client();
				$finhouseresponse = $client->request('GET', $finhouseUrl);
				$result_finhouse = $finhouseresponse->getBody()->getContents();
				// convert json string to arary
				$jsonStringfinhouse 	= json_decode($result_finhouse, true); // decode the json string
				$data_finhouse = $jsonStringfinhouse['datafinder'];
				if (array_key_exists('results', $data_finhouse)) { $resultDataFinHou = $data_finhouse['results'][0]; }

				/* Zip 4 Demographics  */
				$zip4Url = $this->createDatafinderUrl($property->id, $type, $search_methods, 'user_property', 'zip4');
				$client = new Client();
				$zip4response = $client->request('GET', $zip4Url);
				$result_zip4 = $zip4response->getBody()->getContents();
				// convert json string to arary
				$jsonStringzip4	= json_decode($result_zip4, true); // decode the json string
				$data_zip4 = $jsonStringzip4['datafinder'];
				if (array_key_exists('results', $data_zip4)) { $resultDataZip4Demog = $data_zip4['results'][0]; }
			}
			else{
			 return $this->getResponse(422,'Invalid request!',[],0);
			}
		}

		//print_r($resultDataZip4Demog);
		if(!empty($resultDataZip4Demog))
		{
				//echo "sdsdsa";
			if (array_key_exists('MedianHouseholdIncome', $resultDataZip4Demog)) {
				$MedianHouseholdIncome = $resultDataZip4Demog['MedianHouseholdIncome'];
				//echo $MedianHouseholdIncome;
				}

			$updated = UserProperty::where([['user_id', Auth::id()],['id',$user_property_id]])
			->update(array(
			'MedianHouseholdIncome' => isset($MedianHouseholdIncome) ? $MedianHouseholdIncome : '',
			'zip4_demographic_reponse' => $result_zip4,
			'zip4_append_url'=>$zip4Url
			));
			//print_r($updated);
		}

		if(!empty($resultDataFinHou))
		{
		 //echo "sdsdsa";
			if (array_key_exists('EstimatedHouseholdIncome', $resultDataFinHou)) { $EstimatedHouseholdIncome = $resultDataFinHou['EstimatedHouseholdIncome']; }
			if (array_key_exists('EstWealth', $resultDataFinHou)) { $EstWealth = $resultDataFinHou['EstWealth']; }
			$updated = UserProperty::where([['user_id', Auth::id()],['id',$user_property_id]])
			->update(array(
			'EstimatedHouseholdIncome' => isset($EstimatedHouseholdIncome) ? $EstimatedHouseholdIncome : '',
			'finhouse_reponse' => $result_finhouse,
			'finhouse_append_url'=>$finhouseUrl,
			'NetWorth'=>isset($EstWealth) ? $EstWealth : '',
			));
		}
		//die;
		if(!empty($resultDataLifeint))
		{

			if (array_key_exists('Investing', $resultDataLifeint)) { $Investing= $resultDataLifeint['Investing']; }
			if (array_key_exists('CharitableDonations', $resultDataLifeint)) { $CharitableDonations= $resultDataLifeint['CharitableDonations']; }
			$updated = UserProperty::where([['user_id', Auth::id()],['id',$user_property_id]])
			->update(array(
			'Investing' => isset($Investing) ? $Investing : '',
			'CharitableDonations' => isset($CharitableDonations) ? $CharitableDonations : '',
			'lifeinterest_reponse' => $result_lifeintr,
			'lifeint_append_url'=>$lifeintrUrl,
			));
		}
		if(!empty($resultData))
		{
			if (array_key_exists('DOB', $resultData)) { $dob= $resultData['DOB']; }
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

			$updated = UserProperty::where([['user_id', Auth::id()],['id',$user_property_id]])
			->update(array(
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
			'demograph_reponse' => $result_demograph,
			'demographic_append_url'=>$demographUrl
			));


		}

		$res = UserProperty::find($user_property_id);
		return $this->getResponse(200,'Data saved',(Object)array('response'=>$result_demograph,'data'=>$res),1);
	}
	public function getProspectsPhone( Request $request )
    {
		$validator = Validator::make($request->all(), [
            'property_id'    => 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		// declare variables
        $search_methods = array('firstname', 'lastname', 'address', 'city', 'state', 'zip'); // search parameters

		$table_name = 'datatree';

		$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );
		$numRows = count($property_id_in_arrays);
		/**
         *
         *
         * EMAIL SEARCH
         *
         *
        */
		$api_response_arr = [];

			/*$data = DB::table('user_property')->select('email_search_flag','property_id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays);

			$query = str_replace(array('?'), array('\'%s\''), $data->toSql());
            $queryss = vsprintf($query, $data->getBindings());
            dump($queryss); */

		$user_properties = DB::table('user_property')->select('phone_search_flag','status','property_id','id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->get();

		$total_user_properties = DB::table('user_property')->select('phone_search_flag','status','property_id','id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count();
		if($total_user_properties == 0){

			return $this->getResponse(422,'Invalid property id',0);
		}
        // build urls and dispatch jobs
		$resultData= [];
		$update_arr = [];
		$phone = '';
		$phone_search_flag= 0;
		$fullNumber = '';
		$lineType = '';
		foreach($user_properties as $key => $data_prop){
			$flag_check 	= 	$data_prop->phone_search_flag;
            $datetree_id 	= 	$data_prop->property_id;
            $status 		= 	$data_prop->status;
			if ($flag_check == 0) {


                $tempUrl = $this->createAccurateAppendUrl($datetree_id, $search_methods);

                /* echo $tempUrl;

				echo "<br />"; */
				$client = new Client();
				$response = $client->request('GET', $tempUrl);
				$result = $response->getBody()->getContents();

				// convert json string to arary
				$jsonString 	= json_decode($result, true); // decode the json string
				$result_array 	= $jsonString['Phones'];
				$resultData[]=$result_array;

				//echo "<pre>"; print_r($result_array);
				 $count = count($result_array);
				if ($count == 1) {
					if (array_key_exists(0, $result_array)) {
						$phoneData = $result_array[0];

						if (array_key_exists('AreaCode', $phoneData)) { $areaCode = $phoneData['AreaCode']; } else { $areaCode = ''; }
						if (array_key_exists('LineType', $phoneData)) { $lineType = $phoneData['LineType']; } else { $lineType = ''; }
						if (array_key_exists('PhoneNumber', $phoneData)) { $phoneNumber = $phoneData['PhoneNumber']; } else { $phoneNumber = ''; }

						if ($lineType == 'CellLine') {

							$fullNumber = $areaCode . $phoneNumber;
							$phone_search_flag = 1;

						}
						if ($lineType == 'LandLine') {

							$fullNumber = 0;
							$phone_search_flag = 0;

						}

					}
				} else {

					for ($i = 0; $i < count($result_array); $i++) {
						$phoneData = $result_array[$i];
						if (array_key_exists('AreaCode', $phoneData)) { $areaCode = $phoneData['AreaCode']; } else { $areaCode = ''; }
						if (array_key_exists('LineType', $phoneData)) { $lineTypes = $phoneData['LineType']; } else { $lineTypes = ''; }
						if (array_key_exists('PhoneNumber', $phoneData)) { $phoneNumber = $phoneData['PhoneNumber']; } else { $phoneNumber = ''; }

						if ($lineTypes == 'CellLine') {
							$lineType = 'CellLine';
							$fullNumber = $areaCode . $phoneNumber;
							$phone_search_flag = 1;

						}
						if ($lineTypes == 'LandLine') {
							$lineType = 'LandLine';
							$fullNumber = 0;
							$phone_search_flag = 0;

						}
					}
				}


				/* $result_array 	= $jsonString['datafinder'];
				$inputData 		= $result_array['input-query'];
				if (array_key_exists('results', $result_array)) { $resultData = $result_array['results'][0]; }
				if (!empty($resultData)) {
					if (array_key_exists('Phone', $resultData)) {
						$phone = $resultData['Phone'];
						$phone_search_flag = 1;
						if($status ==0){

							$status = '1';
						}
					}
				} */

				UserProperty::where([['user_id', Auth::id()],['id',$data_prop->id]])->update(array('phone' => $fullNumber,'phone_search_flag'=>$phone_search_flag,'line_type'=>$lineType));

            }
		}

		$user_properties_new = DB::table('user_property')->select('phone','phone_search_flag','line_type','id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->get();

		if($user_properties_new->count() > 0){

			return $this->getResponse(200,'Phone Data',$user_properties_new,1);

		}

		return $this->getResponse(422,'Something went wrong!',0);

	}

	// createAccurateAppendUrl function
    // create the AccurateAppennd Url
    public function createAccurateAppendUrl($datetree_id, $search_methods) {
        // api details
        $AccurateAppendUrl = 'https://api.accurateappend.com/Services/V2/AppendPhone/Residential/';
        $apiKey = $this->accurate_append_key;
       // $hf = new HelperFunctions();

        // example of search url
        // https://api.accurateappend.com/Services/V2/AppendPhone/Residential/e854dda0-f52f-4dff-b26c-9a1fb35dd1f0/?firstname=Evander&lastname=Mendonca&address=17040%2060th%20Lane%20N&city=Loxahatchee&state=FL

        // variables necessary for url creation
        $searchUrl = $AccurateAppendUrl . $apiKey . '/?';

		$datatree_data = DB::table('datatree')->select('SitusHouseNumber','SitusStreetName','SitusMode','Owner1FirstName as firstname','OwnerLastname1 as lastname','SitusCity as city','SitusState as state','SitusZipCode as zip','SitusHouseNumber as address')->where('id', '=', $datetree_id)->first();


		$datatree_data->address  = $datatree_data->SitusHouseNumber." ".$datatree_data->SitusStreetName." ".$datatree_data->SitusMode." ".$datatree_data->city." ".$datatree_data->state." ".$datatree_data->zip;

		$urlString = '';
		 // create the url to call
        for ($i = 0; $i < count($search_methods); $i++) {
            if ($search_methods[$i] === 'firstname' || $search_methods[$i] === 'lastname' || $search_methods[$i] === 'city' || $search_methods[$i] === 'state' || $search_methods[$i] === 'zip' || $search_methods[$i] === 'address') {

               // $input = $hf->requestSql($table_name, $search_methods[$i], $id);
                $tempSearchVar = $search_methods[$i]; // remove either 1 or 2 from end of string
                $urlString .= '&' . $tempSearchVar . '=' . rawurlencode($datatree_data->$tempSearchVar);
            }
        }


        // create the url
        /* for ($i = 0; $i < count($search_methods); $i++) {
            if ($search_methods[$i] === 'first1' || $search_methods[$i] === 'first2') {
                $input = $hf->requestSql($table_name, $search_methods[$i], $id);
                $tempSearchVar = 'firstname';
                $searchUrl .= $tempSearchVar . '=' . $input;
            } else if ($search_methods[$i] === 'last1' || $search_methods[$i] === 'last2') {
                $input = $hf->requestSql($table_name, $search_methods[$i], $id);
                $tempSearchVar = 'lastname';
                $searchUrl .= '&' . $tempSearchVar . '=' . $input;
            } else {
                $input = $hf->requestSql($table_name, $search_methods[$i], $id);
                $searchUrl .= '&' . $search_methods[$i] . '=' . $input;
            }
        } */

        // fill in blank spaces with %20
		$UrlFinal = $searchUrl.$urlString;
        /* $searchUrl = str_replace(' ', '%20', $searchUrl);
        $searchUrl = str_replace('#', '%20', $searchUrl); */

        // return the url
        return $UrlFinal;
    }


	public function getProspectsEmail( Request $request )
    {
		$validator = Validator::make($request->all(), [
            'property_id'    => 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		// declare variables
        $search_methods = array('first', 'last', 'address', 'city', 'state', 'zip'); // search parameters

		$table_name = 'datatree';

		$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );
		$numRows = count($property_id_in_arrays);
		/**
         *
         *
         * EMAIL SEARCH
         *
         *
        */
		$api_response_arr = [];

			/*$data = DB::table('user_property')->select('email_search_flag','property_id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays);

			$query = str_replace(array('?'), array('\'%s\''), $data->toSql());
            $queryss = vsprintf($query, $data->getBindings());
            dump($queryss); */

		$user_properties = DB::table('user_property')->select('email_search_flag','status','property_id','id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->get();

		$user_properties_count = DB::table('user_property')->select('email_search_flag','status','property_id','id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count();

		if($user_properties_count == 0){

			return $this->getResponse(422,'Invalid property id',0);
		}
        // build urls and dispatch jobs
		$resultData= [];
		$update_arr = [];
		$email = '';
		$email_search_flag= 0;

		foreach($user_properties as $key => $data_prop){
			$flag_check 	= 	$data_prop->email_search_flag;
            $datetree_id 	= 	$data_prop->property_id;
            $status 		= 	$data_prop->status;
			if ($flag_check == 0) {
                $tempUrl = $this->createUrl($datetree_id, $search_methods, 'user_property', 'email');

                /* echo $tempUrl;

				echo "<br />"; */
				$client = new Client();
				$response = $client->request('GET', $tempUrl);
				$result = $response->getBody()->getContents();

				// convert json string to arary
				$jsonString 	= json_decode($result, true); // decode the json string
				$result_array 	= $jsonString['datafinder'];
				$inputData 		= $result_array['input-query'];
				if (array_key_exists('results', $result_array)) { $resultData = $result_array['results'][0]; }
				if (!empty($resultData)) {
					if (array_key_exists('EmailAddr', $resultData)) {
						$email = $resultData['EmailAddr'];
						$email_search_flag = 1;
						if($status ==0){

							$status = '1';
						}

					}
				}

				UserProperty::where([['user_id', Auth::id()],['id',$data_prop->id]])->update(array('email' => $email,'email_search_flag'=>$email_search_flag));

            }
		}
		$user_properties_new = DB::table('user_property')->select('email','email_search_flag','id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->get();

		if($user_properties_new->count() > 0){

			return $this->getResponse(200,'Email Data',$user_properties_new,1);

		}


		return $this->getResponse(422,'Something went wrong!',0);

	}

	public function getDemographData($PropertyId){

		if(!isset($PropertyId) || $PropertyId == '' || $PropertyId == 0){
			return $this->getResponse(422,'Invalid request!',[],0);
		}
		$dataTree = DataTree::select('datatree.id as datatree_id','user_property.id as prop_id')->join('user_property','user_property.property_id','=','datatree.id')->where('user_id',Auth::id())->where('datatree.PropertyId',$PropertyId)->first();
		if($dataTree){
			$search_methods = array('first', 'last', 'address', 'city', 'state', 'zip'); // search parameters
			$tempUrl = $this->createUrl($dataTree->datatree_id, $search_methods, 'user_property', 'demograph');
			$client = new Client();
			$response = $client->request('GET', $tempUrl);
			$result = $response->getBody()->getContents();

			// convert json string to arary
			$jsonString 	= json_decode($result, true); // decode the json string
			$data = $jsonString['datafinder'];
			if (array_key_exists('results', $data)) { $resultData = $data['results'][0]; }

			if (array_key_exists('DOB', $resultData)) { $dob= $resultData['DOB']; }
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

			$updated = UserProperty::where([['user_id', Auth::id()],['id',$dataTree->prop_id]])
			->update(array(
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
				$res = UserProperty::find($dataTree->prop_id);
				return $this->getResponse(200,'Data saved',(Object)array('response'=>$result,'data'=>$res),1);
			}
		}
		return $this->getResponse(422,'Invalid request!',[],0);
	}
	// createUrl function
    // creates urls based on parameters passed
    public function createUrl($datetree_id, $search_methods, $table_name, $service ) {
        // api details
        $k2 = $this->datafinder_key;
        $DataFinderUrl = "https://api.datafinder.com/qdf.php?service=" . $service . "&k2=";
        $Token = $this->datafinder_token;


        // examples of how url should look
        // $searchUrl = $DataFinderUrl . $k2 . '&d_' . $search_methods[0] . '=' . $input1 . '&d_' . $search_methods[1] . '=' . $input2 . '&d_' . $search_methods[2] . '=' . $input3;
        // $searchUrl = $DataFinderUrl . $k2 . '&d_address=' . $address . '&d_city=' . $city . "&d_state=" . $state;

        // variables necessary for url creation
        $searchUrl = $DataFinderUrl . $k2;
		$datatree_data = DB::table('datatree')->select('SitusHouseNumber','SitusStreetName','SitusMode','Owner1FirstName as first',
		'OwnerLastname1 as last','SitusCity as city','SitusState as state','SitusZipCode as zip','SitusHouseNumber as address')
		->where('id', '=', $datetree_id)->first();
		$datatree_data->address  = $datatree_data->SitusHouseNumber." ".$datatree_data->SitusStreetName." ".$datatree_data->SitusMode." ".$datatree_data->city." ".$datatree_data->state." ".$datatree_data->zip;
        // create the url to call
        for ($i = 0; $i < count($search_methods); $i++) {
            if ($search_methods[$i] === 'first' || $search_methods[$i] === 'last' || $search_methods[$i] === 'city' || $search_methods[$i] === 'state' || $search_methods[$i] === 'zip' || $search_methods[$i] === 'address') {

               // $input = $hf->requestSql($table_name, $search_methods[$i], $id);
                $tempSearchVar = $search_methods[$i]; // remove either 1 or 2 from end of string
                $searchUrl .= '&d_' . $tempSearchVar . '=' . $datatree_data->$tempSearchVar;
            }
        }

        // fill in blank spaces with %20
        $searchUrl = str_replace(' ', '%20', $searchUrl);

        // return the url
        return $searchUrl;
    }


}
