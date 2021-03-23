<?php

namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Auth, Validator, Response, DB, DataTables;
use Illuminate\Support\Str;
use App\Mail\MailNotify;
use App\User;
use App\AffiliateUsers;
use App\AffiliateCommission;
use App\Notifications\AffiliateRegister;
use App\Notifications\AffiliateCommissionConfirmation;
use App\AffiliateWallet;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Exports\UsersExport;
use App\Exports\CollectionExport;
use Maatwebsite\Excel\Facades\Excel;

class AffiliateController extends Controller
{

	public function export()
    {
		$data = [
			[
				'name' => 'Povilas',
				'surname' => 'Korop',
				'email' => 'povilas@laraveldaily.com',
				'twitter' => '@povilaskorop'
			],
			[
				'name' => 'Taylor',
				'surname' => 'Otwell',
				'email' => 'taylor@laravel.com',
				'twitter' => '@taylorotwell'
			]
		];
       // return Excel::download(new UsersExport, 'users.xlsx');
	   return Excel::download(new CollectionExport($data), 'exportss.xlsx');

    }

	public function datafinderapi( Request $request )
    {

		// declare variables
        $search_methods_phone = array('firstname', 'lastname', 'address', 'city', 'state', 'zip'); // search parameters

		$search_methods_email = array('first', 'last', 'address', 'city', 'state', 'zip');

		$table_name = 'datatree';
		$property_id = '227425,220677,213280,213342,213529';
		$property_id_in_arrays = explode( ',' , $property_id );
		$numRows = count($property_id_in_arrays);
		/**
         *
         *
         * EMAIL SEARCH
         *
         *
        */
		$api_response_arr = [];


		$user_properties = DB::table('user_property')->select('email_search_flag','phone_search_flag','status','property_id','id')->whereIN('id',$property_id_in_arrays)->get();
		//echo "<pre>"; print_r($user_properties); die;
		$total_user_properties = DB::table('user_property')->select('email_search_flag','phone_search_flag','status','property_id','id')->whereIN('id',$property_id_in_arrays)->count();
		if($total_user_properties == 0){

			echo 'Invalid property id'; die;
		}

        // build urls and dispatch jobs
		$resultData= [];
		$update_arr = [];
		$phone = '';
		$phone_search_flag= 0;
		$fullNumber = '';
		$lineType = '';
		foreach($user_properties as $key => $data_prop){
			$flag_check_phone	= 	$data_prop->phone_search_flag;
			$flag_check_email	= 	$data_prop->email_search_flag;
            $datetree_id 	= 	$data_prop->property_id;
            $status 		= 	$data_prop->status;

                $tempUrl_email = $this->createUrl($datetree_id, $search_methods_email, 'user_property', 'email');
				$tempUrlFinance = $this->createUrl($datetree_id, $search_methods_email, 'user_property', 'finhouse');
				$tempUrlDemograph = $this->createUrl($datetree_id, $search_methods_email, 'user_property', 'demograph');
				$tempUrlPhone = $this->createAccurateAppendUrl($datetree_id, $search_methods_phone);
                /* echo $tempUrl;

				echo "<br />"; */
				$client = new Client();
				$responseDemo = $client->request('GET', $tempUrlDemograph);
				$resultDemo = $responseDemo->getBody()->getContents();
				$jsonStringDemo 	= json_decode($resultDemo, true); // decode the json string
				$result_arrayDemo 	= $jsonStringDemo['datafinder'];

				$responseFinance = $client->request('GET', $tempUrlFinance);
				$resultFinance = $responseFinance->getBody()->getContents();
				$jsonStringFinance 	= json_decode($resultFinance, true); // decode the json string
				$result_arrayFinance 	= $jsonStringFinance['datafinder'];

				$responseEmail = $client->request('GET', $tempUrl_email);
				$resultEmail = $responseEmail->getBody()->getContents();

				// convert json string to arary
				$jsonStringEmail 	= json_decode($resultEmail, true); // decode the json string
				$result_array 	= $jsonStringEmail['datafinder'];

				$responsePhone = $client->request('GET', $tempUrlPhone);
				$resultPhone = $responsePhone->getBody()->getContents();

				// convert json string to arary
				$jsonStringPhone 	= json_decode($resultPhone, true); // decode the json string
				$dataPhone          = $jsonStringPhone['Phones'];
				$ProcessingReport          = $jsonStringPhone['ProcessingReport']['Operations'];
				$count = count($dataPhone);
				$AreaCode = [];
				$LineType = [];
				$PhoneNumber = [];
				$NameP = [];
				$MatchLevel = [];
				$QualityLevel = [];
				$CountP = [];
				if ($count == 1) {
					if (array_key_exists(0, $dataPhone)) {
						$phoneData = $dataPhone[0];
						$processingData = $ProcessingReport[0];

						if (array_key_exists('AreaCode', $phoneData)) { $areaCode = $phoneData['AreaCode']; } else { $areaCode = ''; }
						if (array_key_exists('LineType', $phoneData)) { $lineType = $phoneData['LineType']; } else { $lineType = ''; }
						if (array_key_exists('PhoneNumber', $phoneData)) { $phoneNumber = $phoneData['PhoneNumber']; } else { $phoneNumber = ''; }
						if (array_key_exists('Name', $processingData)) { $Namep = $processingData['Name']; } else { $Namep = ''; }
						if (array_key_exists('MatchLevel', $processingData)) { $matchlvel = $processingData['MatchLevel']; } else { $matchlvel = ''; }
						if (array_key_exists('QualityLevel', $processingData)) { $quality = $processingData['QualityLevel']; } else { $quality = ''; }
						if (array_key_exists('Count', $processingData)) { $countp = $processingData['Count']; } else { $countp = ''; }
						$AreaCode[] = $areaCode;
						$LineType[] = $lineType;
						$PhoneNumber[] = $phoneNumber;
						$NameP[] = $Namep;
						$MatchLevel[] = $matchlvel;
						$QualityLevel[] = $quality;
						$CountP[] = $countp;


					}
				} else {
					for ($i = 0; $i < count($dataPhone); $i++) {
						$phoneData = $dataPhone[$i];
						$processingData = $ProcessingReport[$i];
						if (array_key_exists('AreaCode', $phoneData)) { $areaCode = $phoneData['AreaCode']; } else { $areaCode = ''; }
						if (array_key_exists('LineType', $phoneData)) { $lineType = $phoneData['LineType']; } else { $lineType = ''; }
						if (array_key_exists('PhoneNumber', $phoneData)) { $phoneNumber = $phoneData['PhoneNumber']; } else { $phoneNumber = ''; }
						if (array_key_exists('Name', $processingData)) { $Namep = $processingData['Name']; } else { $Namep = ''; }
						if (array_key_exists('MatchLevel', $processingData)) { $matchlvel = $processingData['MatchLevel']; } else { $matchlvel = ''; }
						if (array_key_exists('QualityLevel', $processingData)) { $quality = $processingData['QualityLevel']; } else { $quality = ''; }
						if (array_key_exists('Count', $processingData)) { $countp = $processingData['Count']; } else { $countp = ''; }
						$AreaCode[] = $areaCode;
						$LineType[] = $lineType;
						$PhoneNumber[] = $phoneNumber;
						$NameP[] = $Namep;
						$MatchLevel[] = $matchlvel;
						$QualityLevel[] = $quality;
						$CountP[] = $countp;

					}
				}
				//echo "<pre>"; print_r($jsonStringPhone);

				$datass[] = [['version' => $result_array['version'],
				'query_id' =>$result_array['query-id'],
				'num_results' => $result_array['num-results'],
				'query_time' => $result_array['query-time'],
				'#RawScore' =>isset($result_array['results']) && isset($result_array['results'][0]['#RawScore']) ? $result_array['results'][0]['#RawScore'] :'',
				'#WeightedScore'=>isset($result_array['results'])&& isset($result_array['results'][0]['#WeightedScore']) ? $result_array['results'][0]['#WeightedScore'] :'',
				'#RawMatchCodes' =>isset($result_array['results']) && isset($result_array['results'][0]['#RawMatchCodes']) ? $result_array['results'][0]['#RawMatchCodes'] :'',
				'#MergeCtr'=>isset($result_array['results']) && isset($result_array['results'][0]['#MergeCtr']) ? $result_array['results'][0]['#MergeCtr'] :'',
				'#MaxRawScore' =>isset($result_array['results']) && isset($result_array['results'][0]['#MaxRawScore']) ? $result_array['results'][0]['#MaxRawScore'] :'',
				'#NormalizedRawScore'=>isset($result_array['results']) && isset($result_array['results'][0]['#NormalizedRawScore']) ? $result_array['results'][0]['#NormalizedRawScore'] :'',
				'#MaxWeightedScore' =>isset($result_array['results']) && isset($result_array['results'][0]['#MaxWeightedScore']) ? $result_array['results'][0]['#MaxWeightedScore'] :'',
				'#NormalizedWeightedScore'=>isset($result_array['results']) && isset($result_array['results'][0]['#NormalizedWeightedScore']) ? $result_array['results'][0]['#NormalizedWeightedScore'] :'',
				'Results:FirstName' =>isset($result_array['results']) && isset($result_array['results'][0]['FirstName']) ? $result_array['results'][0]['FirstName'] :'',
				'Results:MiddleName'=>isset($result_array['results']) && isset($result_array['results'][0]['MiddleName']) ? $result_array['results'][0]['MiddleName'] :'',
				'Results:LastName' =>isset($result_array['results']) && isset($result_array['results'][0]['LastName']) ? $result_array['results'][0]['LastName'] :'',
				'Results:Address'=>isset($result_array['results']) && isset($result_array['results'][0]['Address']) ? $result_array['results'][0]['Address'] :'',
				'Results:City' =>isset($result_array['results']) && isset($result_array['results'][0]['City']) ? $result_array['results'][0]['City'] :'',
				'Results:State'=>isset($result_array['results']) && isset($result_array['results'][0]['State']) ? $result_array['results'][0]['State'] :'',
				'Results:Zip' =>isset($result_array['results']) && isset($result_array['results'][0]['Zip']) ? $result_array['results'][0]['Zip'] :'',
				'Results:Country'=>isset($result_array['results']) && isset($result_array['results'][0]['Country']) ? $result_array['results'][0]['Country'] :'',
				'Results:TimeStamp'=>isset($result_array['results']) && isset($result_array['results'][0]['TimeStamp']) ? $result_array['results'][0]['TimeStamp'] :'',
				'Results:EmailAddr' =>isset($result_array['results']) && isset($result_array['results'][0]['EmailAddr']) ? $result_array['results'][0]['EmailAddr'] :'',
				'Results:IP'=>isset($result_array['results']) && isset($result_array['results'][0]['IP']) ? $result_array['results'][0]['IP'] :'',
				'Results:URLSource' =>isset($result_array['results']) && isset($result_array['results'][0]['URLSource']) ? $result_array['results'][0]['URLSource'] :'',
				'Results:EmailAddrUsable'=>isset($result_array['results']) && isset($result_array['results'][0]['EmailAddrUsable']) ? $result_array['results'][0]['EmailAddrUsable'] :'',
				'input-query:FirstName' => isset($result_array['input-query']['FirstName']) ? $result_array['input-query']['FirstName'] : '',
				'input-query:LastName'=>isset($result_array['input-query']['LastName']) ? $result_array['input-query']['LastName'] : '',
				'input-query:Address' =>isset($result_array['input-query']['Address']) ? $result_array['input-query']['Address'] : '',
				'input-query:City'=>isset($result_array['input-query']['City']) ? $result_array['input-query']['City'] : '',
				'input-query:State'=>isset($result_array['input-query']['State']) ? $result_array['input-query']['State'] : '',
				'input-query:PostalCode' =>isset($result_array['input-query']['PostalCode']) ? $result_array['input-query']['PostalCode'] : '',
				'input-query:HouseNum'=>isset($result_array['input-query']['HouseNum']) ? $result_array['input-query']['HouseNum'] : '',
				'input-query:Street'=>isset($result_array['input-query']['Street']) ? $result_array['input-query']['Street'] : '',
				'phone:AreaCode'=>implode(",", $AreaCode),
				'phone:LineType'=>implode(",", $LineType),
				'phone:PhoneNumber'=>implode(",", $PhoneNumber),
				'phone:Name'=>implode(",", $NameP),
				'phone:MatchLevel'=>implode(",", $MatchLevel),
				'phone:QualityLevel'=>implode(",", $QualityLevel),
				'phone:Count'=>implode(",", $CountP),
				'Demograph: FirstName'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['FirstName']) ? $result_arrayDemo['results'][0]['FirstName'] :'',
				'Demograph: LastName'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['LastName']) ? $result_arrayDemo['results'][0]['LastName'] :'',
				'Demograph: Address'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['Address']) ? $result_arrayDemo['results'][0]['Address'] :'',
				'Demograph: City'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['City']) ? $result_arrayDemo['results'][0]['City'] :'',
				'Demograph: State'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['State']) ? $result_arrayDemo['results'][0]['State'] :'',
				'Demograph: Zip'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['Zip']) ? $result_arrayDemo['results'][0]['Zip'] :'',
				'Demograph: DOB'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['DOB']) ? $result_arrayDemo['results'][0]['DOB'] :'',
				'Demograph: AgeRange'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['AgeRange']) ? $result_arrayDemo['results'][0]['AgeRange'] :'',
				'Demograph: TimeStamp'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['TimeStamp']) ? $result_arrayDemo['results'][0]['TimeStamp'] :'',
				'Demograph: EthnicGroup'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['EthnicGroup']) ? $result_arrayDemo['results'][0]['EthnicGroup'] :'',
				'Demograph: SingleParent'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['SingleParent']) ? $result_arrayDemo['results'][0]['SingleParent'] :'',
				'Demograph: WorkingWoman'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['WorkingWoman']) ? $result_arrayDemo['results'][0]['WorkingWoman'] :'',
				'Demograph: SOHOIndicator'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['SOHOIndicator']) ? $result_arrayDemo['results'][0]['SOHOIndicator'] :'',
				'Demograph: Language'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['Language']) ? $result_arrayDemo['results'][0]['Language'] :'',
				'Demograph: Religion'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['Religion']) ? $result_arrayDemo['results'][0]['Religion'] :'',
				'Demograph: NumberOfChildren'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['NumberOfChildren']) ? $result_arrayDemo['results'][0]['NumberOfChildren'] :'',
				'Demograph: MaritalStatusInHousehold'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['MaritalStatusInHousehold']) ? $result_arrayDemo['results'][0]['MaritalStatusInHousehold'] :'',
				'Demograph: HomeOwnerRenter'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['HomeOwnerRenter']) ? $result_arrayDemo['results'][0]['HomeOwnerRenter'] :'',
				'Demograph: Education'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['Education']) ? $result_arrayDemo['results'][0]['Education'] :'',
				'Demograph: Occupation'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['Occupation']) ? $result_arrayDemo['results'][0]['Occupation'] :'',
				'Demograph: OccupationDetail'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['OccupationDetail']) ? $result_arrayDemo['results'][0]['OccupationDetail'] :'',
				'Demograph: Gender'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['Gender']) ? $result_arrayDemo['results'][0]['Gender'] :'',
				'Demograph: PresenceOfChildren'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['PresenceOfChildren']) ? $result_arrayDemo['results'][0]['PresenceOfChildren'] :'',
				'Interest: Magazines'=>isset($result_arrayDemo['results']) && isset($result_arrayDemo['results'][0]['Magazines']) ? $result_arrayDemo['results'][0]['Magazines'] :'',
				'Interest: ComputerAndTechnology'=>'YES',
				'Interest: ExerciseHealthGrouping'=>'YES',
				'Interest: MailOrderBuyer'=>'YES',
				'Interest: TravelGrouping'=>'YES',
				'Interest: OnlineEducation'=>'YES',
				'Interest: SportsGrouping'=>'YES',
				'Interest: SportsOutdoorsGrouping'=>'YES',
				'Interest: BooksAndReading'=>'YES',
				'Interest: ArtsAntiquesCollectibles'=>'YES',
				'Interest: PetOwner'=>'YES',
				'Interest: HealthBeautyWellness'=>'YES',
				'Interest: Music'=>'YES',
				'Interest: Movie'=>'YES',
				'Interest: SelfImprovement'=>'YES',
				'Interest: WomensApparel'=>'YES',
				'Finance:FirstName' =>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['FirstName']) ? $result_arrayFinance['results'][0]['FirstName'] :'',
				'Finance:MiddleName'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['MiddleName']) ? $result_arrayFinance['results'][0]['MiddleName'] :'',
				'Finance:LastName' =>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['LastName']) ? $result_arrayFinance['results'][0]['LastName'] :'',
				'Finance:Address'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['Address']) ? $result_arrayFinance['results'][0]['Address'] :'',
				'Finance:City' =>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['City']) ? $result_arrayFinance['results'][0]['City'] :'',
				'Finance:State'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['State']) ? $result_arrayFinance['results'][0]['State'] :'',
				'Finance:Zip' =>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['Zip']) ? $result_arrayFinance['results'][0]['Zip'] :'',
				'Finance:Country'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['Country']) ? $result_arrayFinance['results'][0]['Country'] :'',
				'Finance:TimeStamp'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['TimeStamp']) ? $result_arrayFinance['results'][0]['TimeStamp'] :'',
				'Finance: EstimatedHouseholdIncome'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['EstimatedHouseholdIncome']) ? $result_arrayFinance['results'][0]['EstimatedHouseholdIncome'] :'',
				'Finance: LengthOfResidence'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['LengthOfResidence']) ? $result_arrayFinance['results'][0]['LengthOfResidence'] :'',
				'Finance: HomePurchaseDate'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['HomePurchaseDate']) ? $result_arrayFinance['results'][0]['HomePurchaseDate'] :'',
				'Finance: HomePurchasePrice'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['HomePurchasePrice']) ? $result_arrayFinance['results'][0]['HomePurchasePrice'] :'',
				'Finance: DwellingType'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['DwellingType']) ? $result_arrayFinance['results'][0]['DwellingType'] :'',
				'Finance: HomeValue'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['HomeValue']) ? $result_arrayFinance['results'][0]['HomeValue'] :'',
				'Finance: NumberCreditLines'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['NumberCreditLines']) ? $result_arrayFinance['results'][0]['NumberCreditLines'] :'',
				'Finance: CreditCardUser'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['CreditCardUser']) ? $result_arrayFinance['results'][0]['CreditCardUser'] :'',
				'Finance: CardHolderGasDeptRetail'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['CardHolderGasDeptRetail']) ? $result_arrayFinance['results'][0]['CardHolderGasDeptRetail'] :'',
				'Finance: AutoYear'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['AutoYear']) ? $result_arrayFinance['results'][0]['AutoYear'] :'',
				'Finance: AutoMake'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['AutoMake']) ? $result_arrayFinance['results'][0]['AutoMake'] :'',
				'Finance: AutoModel'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['AutoModel']) ? $result_arrayFinance['results'][0]['AutoModel'] :'',
				'Finance: AutoEdition'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['AutoEdition']) ? $result_arrayFinance['results'][0]['AutoEdition'] :'',
				'Finance: EstWealth'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['EstWealth']) ? $result_arrayFinance['results'][0]['EstWealth'] :'',
				'Finance: UpscaleCardHolder'=>isset($result_arrayFinance['results']) && isset($result_arrayFinance['results'][0]['UpscaleCardHolder']) ? $result_arrayFinance['results'][0]['UpscaleCardHolder'] :'',


				]];


				//  Excel::download(new CollectionExport(), 'exportss.xlsx');




			/* if ($flag_check_phone == 0) {

				$tempUrlPhone = $this->createAccurateAppendUrl($datetree_id, $search_methods_phone);

				$client = new Client();
				$response = $client->request('GET', $tempUrlPhone);
				$result = $response->getBody()->getContents();

				// convert json string to arary
				$jsonString 	= json_decode($result, true); // decode the json string
				$result_array 	= $jsonString['Phones'];

				echo "<pre>"; print_r($jsonString);



            }  */
		}

	  // die;

	   return Excel::download(new CollectionExport($datass), 'exportss.xlsx');



		return $this->getResponse(422,'Something went wrong!',0);

	}


	// createUrl function
    // creates urls based on parameters passed
    public function createUrl($datetree_id, $search_methods, $table_name, $service ) {
        // api details
        $k2 = "mwvtwwxeiooupkh2jwvojzdc";
        $DataFinderUrl = "https://api.datafinder.com/qdf.php?service=" . $service . "&k2=";
        $Token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVc2VySUQiOiIxMjM3NDkiLCJBY2NvdW50SUQiOiIyMDA3ODQzIiwiVXNlck5hbWUiOiJEVEFQSV9BZmZvcmRhYmxlSG9tZXNfVUFUIiwiTmFtZSI6IlJvYmVydCBDYXlvdWV0dGUiLCJVc2VyRW1haWwiOiJCRGl4b25AZmlyc3RhbS5jb20iLCJJU1JlZmVyZW5jZVJlcXVpcmVkIjoiMCIsIkFjY291bnRUeXBlIjoiMCIsIkF2YWlsYWJsZVByb2R1Y3RzIjoiW1wiNTAwMVwiLFwiMTAwMVwiLFwiMTAwOFwiLFwiMTAwMlwiLFwiMTA1M1wiLFwiMTAxMFwiLFwiMTAwM1wiLFwiMjAyOFwiLFwiMTAwNVwiLFwiMTAwOVwiLFwiMTAwNlwiLFwiMTAxMVwiLFwiMjA1N1wiLFwiMjA3OFwiLFwiMjA1OFwiXSIsIm5iZiI6MTU2ODM4MDQ0MCwiZXhwIjoxNTY4Mzg3NjQwLCJpYXQiOjE1NjgzODA0NDAsImlzcyI6Imh0dHBzOi8vZHRhcGl1YXQuZGF0YXRyZWUuY29tIiwiYXVkIjoiV2ViQXBpQ29uc3VtZXJzLyJ9.k3Yg0rEUZz5oT7boHN5akF9qbO1pF4R9CUNRP6QIpF4";


        // examples of how url should look
        // $searchUrl = $DataFinderUrl . $k2 . '&d_' . $search_methods[0] . '=' . $input1 . '&d_' . $search_methods[1] . '=' . $input2 . '&d_' . $search_methods[2] . '=' . $input3;
        // $searchUrl = $DataFinderUrl . $k2 . '&d_address=' . $address . '&d_city=' . $city . "&d_state=" . $state;

        // variables necessary for url creation
        $searchUrl = $DataFinderUrl . $k2;
		$datatree_data = DB::table('datatree')->select('SitusHouseNumber','SitusStreetName','SitusMode','Owner1FirstName as first','OwnerLastname1 as last','SitusCity as city','SitusState as state','SitusZipCode as zip','SitusHouseNumber as address')->where('id', '=', $datetree_id)->first();
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

	public function createAccurateAppendUrl($datetree_id, $search_methods) {
        // api details
        $AccurateAppendUrl = 'https://api.accurateappend.com/Services/V2/AppendPhone/Residential/';
        $apiKey = 'e854dda0-f52f-4dff-b26c-9a1fb35dd1f0';
       // $hf = new HelperFunctions();

        // example of search url
        // https://api.accurateappend.com/Services/V2/AppendPhone/Residential/e854dda0-f52f-4dff-b26c-9a1fb35dd1f0/?firstname=Evander&lastname=Mendonca&address=17040%2060th%20Lane%20N&city=Loxahatchee&state=FL

        // variables necessary for url creation
        $searchUrl = $AccurateAppendUrl . $apiKey . '/?';

		$datatree_data = DB::table('datatree')->select('SitusHouseNumber','SitusStreetName','SitusMode','Owner1FirstName as firstname','OwnerLastname1 as lastname','SitusCity as city','SitusState as state','SitusZipCode as zip','SitusHouseNumber as address')->where('id', '=', $datetree_id)->first();


		$datatree_data->address  = $datatree_data->SitusHouseNumber." ".$datatree_data->SitusStreetName." ".$datatree_data->SitusMode." ".$datatree_data->city." ".$datatree_data->state." ".$datatree_data->zip;

		 // create the url to call
        for ($i = 0; $i < count($search_methods); $i++) {
            if ($search_methods[$i] === 'firstname' || $search_methods[$i] === 'lastname' || $search_methods[$i] === 'city' || $search_methods[$i] === 'state' || $search_methods[$i] === 'zip' || $search_methods[$i] === 'address') {

               // $input = $hf->requestSql($table_name, $search_methods[$i], $id);
                $tempSearchVar = $search_methods[$i]; // remove either 1 or 2 from end of string
                $searchUrl .= '&' . $tempSearchVar . '=' . $datatree_data->$tempSearchVar;
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
        $searchUrl = str_replace(' ', '%20', $searchUrl);

        // return the url
        return $searchUrl;
    }

	public function affiliateUsers(){
        $user = AffiliateUsers::get();
        return view('SuperadminDashboard.affiliate.affiliate',compact('user'));
	}

	public function affiliateList(Request $request)
    {
        $data = AffiliateUsers::with('aff_commission')->orderBy('id','desc');

        if(!empty($request->all()))
        {
            if( $request->search_name){
               $data->where('full_name', 'like', "%" . $request->search_name . "%");
            }
			if( $request->search_status){
               $data->where('status', '=',  $request->search_status);
            }
        }
      $user =  $data->get();

        if(request()->ajax()) {
			//echo "<pre>"; print_r($user); die;
            return DataTables::of($user)
            ->addColumn('name', function($row){

              return \ucfirst( $row->full_name);

            })
			->addColumn('service_code', function($row){
				if($row->service_code){
					return $row->service_code_prefix.$row->service_code;
				}
				return "-";
            })
			->addColumn('commission', function($row){
				if($row->aff_commission){
					return $row->aff_commission->commission."%";
				}
				return "-";
            })
            ->addColumn('join_date', function($row){
                return date('d-M-yy', strtotime(str_replace('-', '/', $row->created_at)));
            })
			->addColumn('status', function($row){
                if($row->status == 1){
                    return 'Approved';
                }
                return 'Pending';
            })
            ->addColumn('action', function($row) {
				$class = 'success';
				if($row->status == 0){
					$class = 'secondary';
				}
				$button = '<button data-title="Update Status" type="button" class="btn btn-'. $class .' update_status" data-is_affiliate="'. $row->status .'" data-user_id="'.$row->id.'">Update Status</button>';

				$button .= '  <button data-title="Update Commission" type="button" class="btn btn-'. $class .' update_commission" data-toggle="modal"  data-target="#commissionModal"  data-affiliate_id="'.$row->id.'">Commission</button>';
				//$button .= '  <button data-title="View Detail" type="button" class="btn btn-primary">View</button>';
                return $button;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('SuperadminDashboard.affiliate.affiliate',compact('user'));

    }

    public function varifyemail(Request $request)
    {
        if( $request->id ){
            $user = User::where('email', $request->email)->where('id','<>', $request->id)->get();
            if(count($user) > 0)
            {
                return "false";
            } else {
                return "true";
            }

        }else{
            $email = User::where('email', $request->email)->get();
            if(count($email) > 0)
            {
                return "false";
            } else {
                return "true";
            }
         }
    }

    public function SaveCommission(Request $request)
    {

        $validator =   Validator::make($request->all(), [
            'commission' =>  'required',
        ]);

        if ($validator->passes()) {
			$affiliate_id 	= 	$request->get('affiliate_id');
            $commission 	= 	$request->get('commission');

			$arr=array(
                'affiliate_id'=>$affiliate_id
            );

            $data=array(
                'commission'=>$commission
            );
            AffiliateCommission::updateOrCreate($arr,$data);
            return response()->json(['success'=>'Commission updated.']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);


    }
	private function CommissionConfirmationEmail($email,$amount)
    {
        //Retrieve the user from the database
        $user = AffiliateUsers::where('email',$email)->first();

        if(isset($user)){
			$data = array(
				"email" => $user->email,
				"fullname" =>$user->f_name,
				"amount" => $amount
			);
			return  $user->notify(new AffiliateCommissionConfirmation($data,''));

        }
        return "error";

    }
	public function affiliateAjaxHandling(Request $request)
    {
		if ($request->get("type") == "get_payment_detail" ) {

			$ids 	 = $request->get('wallet_ids');
			$order_id = $request->get('order_id');
			$wallet_ids 	 = explode(",",$ids);

			if($order_id){
				$order_data = AffiliateWallet::select('user_detail.f_name as name','users.email','tbl_affiliate_wallet.id','tbl_affiliate_wallet.status',DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as date'),'order_id','amount as revenue')->whereIN('tbl_affiliate_wallet.id',array_values($wallet_ids))->where('order_id',$order_id)->Join('users', 'tbl_affiliate_wallet.user_id', '=', 'users.id')->Join('user_detail', 'users.id', '=', 'user_detail.user_id')->get()->toArray();
			}else{
				$order_data = AffiliateWallet::select('user_detail.f_name as name','users.email','tbl_affiliate_wallet.id','tbl_affiliate_wallet.status',DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as date'),'order_id','amount as revenue')->whereIN('tbl_affiliate_wallet.id',array_values($wallet_ids))->Join('users', 'tbl_affiliate_wallet.user_id', '=', 'users.id')->Join('user_detail', 'users.id', '=', 'user_detail.user_id')->get()->toArray();
			}
			//echo "<pre>"; print_r($order_data); die;
			return response()->json(['success'=>true,'data'=>$order_data]);
		}

		if ($request->get("type") == "send_masspayment" ) {

			$ids 	 = $request->get('ids');
			$subject = $request->get('subject');
			$note = $request->get('note');
			$subtotal = $request->get('note');
			$wallet_ids 	 = explode(",",$ids);
			$affiliate_array = json_decode($request->get('affiliate_ids'));

			$data = AffiliateWallet::with('affiliate_detail')->select('affiliate_id','tbl_affiliate_wallet.id','tbl_affiliate_wallet.status',DB::raw('sum(amount) as commission'))->where('tbl_affiliate_wallet.status','due')->whereIN('tbl_affiliate_wallet.id',array_values($wallet_ids))->whereIN('affiliate_id',array_values($affiliate_array))->groupBy('status')->groupBy('affiliate_id')->get();

			$data_arr = array( 'sender_batch_header' => array( 'email_subject' => $subject,'email_message' => $subject ) );
			$emailData = [];
			foreach($data as $key => $value){
				$phone = preg_replace('/\D+/', '', $value->affiliate_detail->phone);
				$commission = $value->commission;

				$emailData[] = array('email' =>$value->affiliate_detail->email,'amount' => $value->commission );
				$data_arr['items'][] = array( 'recipient_type' => 'EMAIL' , 'amount' => array('value' => $value->commission,'currency'=>'USD'),'note' => $note,'receiver' => $value->affiliate_detail->paypal_email_address,'alternate_notification_method' => array('phone'=> array( 'country_code' =>'91','national_number' => $phone)));
			}
			$paypal_masspay_data = json_encode($data_arr);
			//$clientId = 'AfKUR9rxXm-7k0FCqwm8mCZNrTYqyRIx4nX_e2ngW1JLuzbLg9iyqiCILu58XbblecMKeiVxOEBH4rQ0';
			//$secret = 'EKuvbw7BFLKpPdn9150rbqPalUWJX2M2KjgyBHSY2pLyCVU0ddDVvVebsot1SYg2tGM_JFdj0acf51OM';

			$clientId = 'AS2RXRCpm65gExrSav39rWRHS7Ri97H0xrjbtA5eUqV6L1O3CfPefaNST_5U5LlGZnLcJ-W78oujANnu';
			$secret = 'EFji2-0kl6nbWEWdlqjjcNIbBUZZ15esVzPrAACusRID9sHKPH_acIaL9OLF5nD6Lw2a2rHT2Wd6YA1t';
			$client = new Client();
			try {
				$response = $client->request('POST', 'https://api.sandbox.paypal.com/v1/oauth2/token', [
						'headers' =>
							[
								'Accept' => 'application/json',
								'Accept-Language' => 'en_US',
							   'Content-Type' => 'application/x-www-form-urlencoded',
							],
						'body' => 'grant_type=client_credentials',

						'auth' => [$clientId, $secret, 'basic']
					]
				);
				$data = json_decode($response->getBody(), true);

				$access_token = $data['access_token'];
				$token=trim($access_token,'"');
				try {
					$response_masspay = $client->request('POST', 'https://api.sandbox.paypal.com/v1/payments/payouts', [
							'headers' =>
								[
									'Content-Type' => 'application/json',
									'Authorization'=> 'Bearer '.$token
								],
							'body' => $paypal_masspay_data
						]
					);
					$masspay_response = json_decode($response_masspay->getBody(), true);
					//echo "<pre>"; print_r($masspay_response);

					$data_re = array('status'=>'paid','order_id'=>$masspay_response['batch_header']['payout_batch_id'],'order_status'=>$masspay_response['batch_header']['batch_status'],'order_date'=>Carbon::now(),'links'=>$masspay_response['links'][0]['href']);

					DB::table('tbl_affiliate_wallet')->whereIN('tbl_affiliate_wallet.id',array_values($wallet_ids))->whereIN('affiliate_id',array_values($affiliate_array))->update($data_re);
					if(count($emailData)>0){
						foreach($emailData as $key => $value){

							$this->CommissionConfirmationEmail($value["email"],$value["amount"]);
						}

					}
					return response()->json(['error'=>false,'success'=>true,'message'=>'Payment initiated successfully!']);

				} catch (RequestException $e) {

					//print_r($e->getResponse());
					return response()->json(['error'=>true, 'message' => 'We are having some issues in sending your request. Please check back after some time']);


				}
			} catch (RequestException $e) {
				//print_r($e->getResponse());
				return response()->json(['error'=>true, 'message' => 'We are having some issues in sending your request. Please check back after some time']);
			}

		}

		if ($request->get("type") == "getMassPayDetail" ) {

			$wallet_ids 		= $request->get('wallet_ids');
			$affiliate_array 	= $request->get('mass_pay_affiliate_checkbox');
			$subject 			= $request->get('subject');
			$note 				= $request->get('note');
			$subtotal 			= 0.00;
			$extra 				= 0.00;
			$ids = [];
			foreach($wallet_ids as $key => $val){
				if(strpos($val,',')){
					$valarr = explode(",",$val);
					foreach($valarr as $id){
						array_push($ids,$id);

					}

				}else{
					$ids[] = $val;
				}
			}
			$data 				= AffiliateWallet::with('affiliate_detail')->select('affiliate_id',DB::raw('count(*) as records_count'),DB::raw('GROUP_CONCAT(tbl_affiliate_wallet.id) as ids'),'tbl_affiliate_wallet.status',DB::raw('sum(amount) as commission'))->where('tbl_affiliate_wallet.status','due')->whereIN('affiliate_id',array_values($affiliate_array))->whereIN('tbl_affiliate_wallet.id',array_values($ids))->groupBy('status')->groupBy('affiliate_id')->get();

			//echo "<pre>"; print_r($data); die;
			$total_recipient = $data->count();

			$data_arr = array( 'sender_batch_header' => array( 'email_subject' => $subject,'email_message' => $subject ) );

			if ( $total_recipient > 0 ) {
				foreach($data as $key => $value){
					$phone = preg_replace('/\D+/', '', $value->affiliate_detail->phone);
					$commission = $value->commission;
					$subtotal += $commission;
					$extra += 0.25;

					$data_arr['items'][] = array( 'recipient_type' => 'EMAIL' , 'amount' => array('value' => $value->commission,'currency'=>'USD'),'note' => $note,'receiver' => $value->affiliate_detail->paypal_email_address,'alternate_notification_method' => array('phone'=> array( 'country_code' =>'91','national_number' => $phone)));
				}
				$total = $subtotal+$extra;

				$paypal_masspay_data = json_encode($data_arr);

                return response()->json(['success'=>true, 'wallet_ids' => $ids,'affiliates' => json_encode($affiliate_array),'subject' => $subject,'note' => $note,'masspay_api_request_data' => $paypal_masspay_data,'total' => $total,'subtotal' =>$subtotal, 'extra' => $extra,'total_recipient' => $total_recipient]);

            } else {

                return response()->json(['error'=>true, 'message' => 'No data found']);
            }
        }

		return response()->json(['error'=>true, 'data' => '']);
	}

	public function affiliateMassPayDetail()
    {

		$data = AffiliateWallet::with('affiliate_detail')->select(DB::raw('GROUP_CONCAT(tbl_affiliate_wallet.id) as ids'),DB::raw('count(*) as records_count'),'affiliate_id','tbl_affiliate_wallet.status',DB::raw('sum(amount) as commission'))->where('tbl_affiliate_wallet.status','due')->groupBy('status')->groupBy('affiliate_id');

		  /* echo "<pre>->get()->toArray()"; print_r($pending_payment_data);
		die;  */
		$pending_payment_data = $data->get();
		if(request()->ajax()) {

			return DataTables::of($pending_payment_data)
			->addColumn('commission', function($row) {
					$data = "<input type='hidden' name='wallet_ids[]' value='".$row->ids."'>";
					return $data."$".$row->commission;
			})
			->rawColumns(['commission'])
			->make(true);

		}

		return view('SuperadminDashboard.affiliate.massPaymentDetail',compact('pending_payment_data'));
	}

	public function paymentDetail($order_id,$due)
    {


		if( $order_id !="" ){

			$order_detail_data = AffiliateWallet::select(DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as order_date'),'status','order_id',DB::raw('sum(amount) as total_amount'))->where([['status','paid'],['order_id',$order_id] ])->first();

			$order_data = AffiliateWallet::select('user_detail.f_name as name','users.email','tbl_affiliate_wallet.id','tbl_affiliate_wallet.status',DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as date'),'order_id','amount as revenue')->where('order_id',$order_id)->Join('users', 'tbl_affiliate_wallet.user_id', '=', 'users.id')->Join('user_detail', 'users.id', '=', 'user_detail.user_id')->get();

		}

		if($order_id == 0 && $due ==1){
			$order_detail_data = [];
			$order_data = AffiliateWallet::select('user_detail.f_name as name','users.email','tbl_affiliate_wallet.id','tbl_affiliate_wallet.status',DB::raw('DATE_FORMAT(tbl_affiliate_wallet.created_at, "%d-%b-%Y %H:%i:%s") as date'),'order_id','amount as revenue')->where('tbl_affiliate_wallet.status','due')->Join('users', 'tbl_affiliate_wallet.user_id', '=', 'users.id')->Join('user_detail', 'users.id', '=', 'user_detail.user_id')->get();


		}

		return view('SuperadminDashboard.affiliate.paymentOrderDetail',compact('order_data','order_detail_data'));
	}

	public function affiliateListPayments()
    {

		$data = AffiliateWallet::with('affiliate_detail')->select('affiliate_id',DB::raw('GROUP_CONCAT(tbl_affiliate_wallet.id) as ids'),'tbl_affiliate_wallet.id','tbl_affiliate_wallet.status',DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as order_date'),'order_id',DB::raw('sum(amount) as commission'))->groupBy('order_id')->groupBy('affiliate_id')->groupBy('tbl_affiliate_wallet.status')->orderBy('order_date','desc');

		//echo "<pre>"; print_r($payment_data); die;
		$payment_data = $data->get();
		if(request()->ajax()) {
			//echo "<pre>"; print_r($payment_data); die;
			return DataTables::of($payment_data)
			->addColumn('status', function($row) {
					if($row->status == 'paid'){
						$button = "<label class='badge badge-success'>Paid</label>";
					}
					if($row->status == 'due'){
						$button = "<label class='badge badge-warning'>Unpaid</label>";
					}

					return $button;
			})
			->addColumn('action', function($row) {

					$button = "<input type='hidden' value='".$row->ids."' name='wallet_ids'>";
					if($row->status == 'paid'){
						$button .= "<a href='".\url('superadmin/affiliate/order-detail/'.$row->order_id."/0" )."' data-ids='".$row->ids."' data-order_id='".$row->order_id."' data-toggle='modal'  data-target='#paymentDetailModal' class='btn btn-primary rounded-circle view_detail_button'><i class='fa fa-eye'></i></a>";

					}
					if($row->status == 'due'){
						$button .= "<a href='".\url('superadmin/affiliate/order-detail'."/0/1")."' data-ids='".$row->ids."' data-order_id='0' data-toggle='modal'  data-target='#paymentDetailModal' class='btn btn-primary rounded-circle view_detail_button'><i class='fa fa-eye'></i></a>";
					}

					return $button;
			})
			->addIndexColumn()
			->rawColumns(['action','status'])
			->make(true);

		}


		$pending_payout_data = AffiliateWallet::select(DB::raw('sum(amount) as total_pending_amount'),DB::raw('count(DISTINCT affiliate_id) as total_affiliate'))->where('status','due')->groupBy('affiliate_id')->groupBy('status')->get();

		$paid_payout_data = AffiliateWallet::select(DB::raw('sum(amount) as total_paid_amount'))->where('status','paid')->groupBy('affiliate_id')->groupBy('status')->get();

		$paid_amount_total = number_format($paid_payout_data->sum('total_paid_amount'),2);


		$total_pending_affiliate = 0;
		$pending_amount = 0;

		if(isset($pending_payout_data[0]->total_pending_amount)){

			$total_pending_affiliate = $pending_payout_data->sum('total_affiliate');
			$pending_amount = number_format($pending_payout_data->sum('total_pending_amount'),2);
		}
		$customerEntrolled 	= $this->totalCustomers();

		$prospectsJoined 	= $this->totalProspects();

		return view('SuperadminDashboard.affiliate.paymentDetail',compact('payment_data','pending_amount','total_pending_affiliate','paid_amount_total','customerEntrolled','prospectsJoined'));
	}

	public static function totalCustomers(){

		$data = DB::table('tbl_membership')->Join('users', function($query){
			$query->on( 'users.id', '=', 'tbl_membership.user_id');
			$query->where('users.mapped_to_affiliate','<>',0);
			$query->where('users.role', '0');
        })->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00')->whereNotNull('tbl_membership.expire_at') ->groupBy('tbl_membership.user_id')->get();

		return $data->count();
	}

	public static function totalProspects(){

		$data_nonmember = DB::table('users')->where('role', '0')->orderBy('users.id','desc')
        ->LeftJoin('tbl_membership', function($query){
            $query->on( 'users.id', '=', 'tbl_membership.user_id');
			$query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');

        })->where('users.mapped_to_affiliate','<>',0)
       ->whereNull('tbl_membership.expire_at')->get();

       return $data_nonmember->count();
	}



}
