<?php

namespace App\Http\Controllers\Api;

use Anam\PhantomMagick\Converter;
use App\Http\Controllers\Api\MainController;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;
use App\Model\Search;
use App\Model\Detail;
use App\Model\DataTree;
use App\Model\UserProperty;
use Validator;
use Response;
use DB;
use Config;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use App\Model\Result;
use App\ManageGrid;
use App\Model\Cities;
use App\Model\PropertyGroupName;
use App\Model\PropertyResultId;
use Carbon\Carbon;
use DataTables;
use App\Model\Points;
use App\Model\Deposite;
use App\Model\PaymentMaster;
use App\Configuration;
use App\Model\ApiMode;
use App\Model\Saved;

use App\Traits\AdvanceSearchFilter;

class AdvanceSearchController extends MainController
{
    use AdvanceSearchFilter;
    private $dtapi_username;
    private $dtapi_password;
    private $dtapi_login_url;
    private $report_download_url;
    private $property_count_url;
    private $property_list_url;

    public function __construct()
    {
        $data = ApiMode::where('api_name', 'datatree')->first();
        $this->dtapi_username      = env('DTAPI_TEST_AUTHENTICATE_USERNAME');
        $this->dtapi_password      = env('DTAPI_TEST_AUTHENTICATE_PASSWORD');
        $this->dtapi_login_url     = env('DTAPI_TEST_AUTHENTICATE_URL');
        $this->report_download_url = env('DTAPI_TEST_REPORT_DOWNLOAD_URL');
        $this->property_count_url  = env('DTAPI_TEST_PROPERTY_COUNT_URL');
        $this->property_list_url   = env('DTAPI_TEST_PROPERTY_LIST_URL');

        if (isset($data) && $data->mode == 1) {
            $this->dtapi_username      = env('DTAPI_LIVE_AUTHENTICATE_USERNAME');
            $this->dtapi_password      = env('DTAPI_LIVE_AUTHENTICATE_PASSWORD');
            $this->dtapi_login_url     = env('DTAPI_LIVE_AUTHENTICATE_URL');
            $this->report_download_url = env('DTAPI_LIVE_REPORT_DOWNLOAD_URL');
            $this->property_count_url  = env('DTAPI_LIVE_PROPERTY_COUNT_URL');
            $this->property_list_url   = env('DTAPI_LIVE_PROPERTY_LIST_URL');
        }
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
        //'country'=>'required',
        'state'=>'required',
        'land'=>'required',
        'landRValue'=>'required',
        'landCValue'=>'required',
        'owner'=>'required',
        'ownerEValue'=>'required',
        'ownerOValue'=>'required',
        'salesFrom'=>'required',
        'salesTo'=>'required',
        'OpenAmountFrom'=>'required',
        'OpenAmountTo'=>'required',
        'MortgageFrom'=>'required',
        'MortgageTo'=>'required',
        'MortgageType'=>'required',
        'MortgageInterestFrom'=>'required',
        'MortgageInterestTo'=>'required',
        'MortgageMax'=>'required',
        'EquityFrom'=>'required',
        'EquityTo'=>'required',
        'ListingStatus'=>'required',
        'ListingAmountFrom'=>'required',
        'ListingAmountTo'=>'required',
        'ForeclosureStatus'=>'required',
        'ForeclosureFrom'=>'required',
        'ForeclosureTo'=>'required',
        'ForeclosureAmountFrom'=>'required',
        'ForeclosureAmountTo'=>'required',
        'Premium'=>'required',
        'OwnedFrom'=>'required',
        'OwnedTo'=>'required',
        'HOA'=>'required',
        'Phone'=>'required',
        'Email'=>'required',
        'Others'=>'required',
        'savedTitle'=>'required',
        'purchaseGroupName'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }

        // dd($request->all());
        $data=array(
        'user_id'=>Auth::id(),
        'country'=>'US',
        'state'=>$request->get('state'),
        'city'=>$request->get('city'),
        'zipcode'=>$request->get('zipcode'),
        'land'=>$request->get('land'),
        'residentials'=>$request->get('landRValue'),
        'commercial'=>$request->get('landCValue'),
        'owner'=>$request->get('owner'),
        'exemption'=>$request->get('ownerEValue'),
        'occupancy'=>$request->get('ownerOValue'),
        'sales_from'=>json_encode($request->get('salesFrom')),
        'sales_to'=>json_encode($request->get('salesTo')),
        'mortgage_amount_f'=>$request->get('OpenAmountFrom'),
        'mortgage_amount_t'=>$request->get('OpenAmountTo'),
        'mortgage_date_f'=>json_encode($request->get('MortgageFrom')),
        'mortgage_date_t'=>json_encode($request->get('MortgageTo')),
        'mortgage_type'=>$request->get('MortgageType'),
        'interest_rate_f'=>$request->get('MortgageInterestFrom'),
        'interest_rate_t'=>$request->get('MortgageInterestTo'),
        'max_open_lien'=>$request->get('MortgageMax'),
        'equity_from'=>json_encode($request->get('EquityFrom')),
        'equity_to'=>json_encode($request->get('EquityTo')),
        'listing_status'=>$request->get('ListingStatus'),
        'listing_amount_f'=>$request->get('ListingAmountFrom'),
        'listing_amount_t'=>$request->get('ListingAmountTo'),
        'foreclosure_status'=>$request->get('ForeclosureStatus'),
        'foreclosure_date_f'=>json_encode($request->get('ForeclosureFrom')),
        'foreclosure_date_t'=>json_encode($request->get('ForeclosureTo')),
        'foreclosure_amount_f'=>$request->get('ForeclosureAmountFrom'),
        'foreclosure_amount_t'=>$request->get('ForeclosureAmountTo'),
        'finance_scores'=>$request->get('Premium'),
        'owner_owned_f'=>$request->get('OwnedFrom'),
        'owner_owned_t'=>$request->get('OwnedTo'),
        'hoa'=>$request->get('HOA'),
        'phone'=>$request->get('Phone'),
        'email'=>$request->get('Email'),
        'other'=>$request->get('Others'),
        'title'=>$request->get('savedTitle'),
        'folder_name'=>$request->get('purchaseGroupName'),
    );

        Search::create($data);
        return $this->getResponse(200, 'Successfull Submitted');
    }


    public function getCount(Request $request)
    {
        $client = new Client([ 'headers' => ['Content-Type' => 'application/json']]);
        $auth   = ['Username' => $this->dtapi_username, 'Password' => $this->dtapi_password];

        try {
            $response = $client->post($this->dtapi_login_url, ['body' => json_encode($auth)]);
        } catch (RequestException $e) {
            return $this->getResponse(422, 'We are having some issues in finding your properties now. Please check back after some time', 0);
        }

        $token  = $response->getBody()->getContents();
        $token  = trim($token, '"');
        $filter = $this->advanceSearchFilters($request);

        $clients  = new Client(['headers' => ['Content-Type' => 'application/json', 'Authorization' => $token]]);
        $data     = [
                        "CountOnly"   => true,
                        "MaxReturn"   => 1000,
                        "ProductName" => "SearchLite",
                        "SpatialType" => "Geography",
                        "Filters"     => $filter
                    ];

        try {
            $responses=$clients->post($this->property_count_url, ['body' => json_encode($data)]);
            $result=$responses->getBody()->getContents();

            return $this->getResponse(200, 'Count List', json_decode($result));
        } catch (RequestException $e) {
            return $this->getResponse(422, 'We are having some issues in finding your properties now. Please check back after some time', 0);
        }
    }

    public function getResult(Request $request)
    {
        $filter = $this->advanceSearchFilters($request);
        $data   = [
            "MaxReturn"     => 1000,
            "CountOnly"     => true,
            "ProductNames"  => "PropertyDetailExport",
            "Filters"       => $filter
        ];

        try {
            $client = new Client(['headers' => ['Content-Type' => 'application/json']]);

            $auth   = [
                'Username' => $this->dtapi_username,
                'Password' => $this->dtapi_password
            ];

            try {
                $response = $client->post($this->dtapi_login_url, ['body' => json_encode($auth)]);
            } catch (RequestException $e) {
                return $this->getResponse(422, 'We are having some issues in finding your properties now. Please check back after some time'.$e->getMessage(), 0);
            }

            $token    = $response->getBody()->getContents();
            $token    = trim($token, '"');
            $clients  = new Client(['headers' => ['Content-Type' => 'application/json', 'Authorization'=> $token]]);

            try {
                $responses = $clients->post($this->property_list_url, ['body' => json_encode($data)]);
            } catch (RequestException $e) {
                return $this->getResponse(422, 'DTAPI_PROPERTY_LIST_URL '.$e->getMessage(), 0);
            }

            $result           = $responses->getBody()->getContents();
            $json             = json_decode($result);
            $total_records    = json_encode($json->MaxResultsCount);
            $properties_array = json_decode(json_encode($json->Reports[0]->Data->PropertyData), true);

            $credit  = Points::where('user_id', Auth::id())->where('type', '1')->groupBy('user_id')->orderBy('id', 'desc')->sum('amount');
            $debit   = Points::where('user_id', Auth::id())->where('type', '2')->where('instant', 0)->groupBy('user_id')->orderBy('id', 'desc')->sum('amount');

            $current_wallet_amount = $credit-$debit;
            $total_properties      = count($properties_array);
            $extra_records         = $total_properties-$total_records;
            $exact                 = array_splice($properties_array, $total_records);
            $purchase              = Configuration::where('type', 'purchase_record_price')->first();
            $per_property_rate     = (isset($purchase->price) && $purchase->price!='')  ? $purchase->price : 0;

            //$total_amount_to_be_paid = $total_properties*$per_property_rate;
            $total_amount_to_be_paid = $total_records * $per_property_rate;

            if ($current_wallet_amount < $total_amount_to_be_paid) {
                return $this->getResponse(422, 'We are having some issues in finding your properties now. Please check back after some time totalamount '.$total_amount_to_be_paid.'  total prop ='.$total_properties.'current '.$current_wallet_amount, 0);
            }

            /* debit amount from wallet */
            $pointRate = DB::table('tbl_static')->select('point_per_dollar')->first();
            $points    = [
                'user_id' => Auth::id(),
                'type'    => '2',
                'point'   => $total_amount_to_be_paid * $pointRate->point_per_dollar, //amount is in dollar so, convert in points.
                'amount'  => $total_amount_to_be_paid, //add amount in dollar
                'transaction_detail'  => 'Purchase Records'
                ];

            $point_data = Points::create($points);

            /* add data in payment */
            $payment = [
                'user_id'           => Auth::id(),
                'point_id'          => $point_data->id,
                'payment_type'      => '1',
                'amount'            => $total_amount_to_be_paid, //add amount in dollar
                'total_records'     => $total_properties,
                'payment_type_text' => 'Purchase Records'
                ];

            PaymentMaster::create($payment);

            $results_id = 0;
            if (count($properties_array) > 0) {
                $results = Result::create(['user_id'=>Auth::id()]);
                $results_id = $results->id;
            }

            $purchase_group_name = date('Ymd') . '-' . time() . '-' . Auth::id();

            if ($request->get('purchaseGroupName') != '') {
                $purchase_group_name = $request->get('purchaseGroupName');
            }

            $userid = Auth::id();
            /* convert object of properties to array */
            //$properties_array 		= 	json_decode(json_encode($json->LitePropertyList), true);
            $total_api_properties = count($properties_array);

            /* get apn,propertyId from properties array */
            $apn_prop_id_arr = array_column($properties_array, 'APNFormatted', 'PropertyId');

            /* get datatree data based on  apn and propertyId  */
            $datatree_result_exist_count = DataTree::select('id', 'PropertyId', 'APNFormatted')
                                                    ->whereIn('APNFormatted', array_values($apn_prop_id_arr))
                                                    ->whereIn('PropertyId', array_keys($apn_prop_id_arr))
                                                    ->get()->count();

            $purchase = Configuration::where('type', 'purchase_record_price')->first();
            $purchase_property_price = (isset($purchase->price) && $purchase->price!='')  ? $purchase->price : 0;
            //case 1
            if ($datatree_result_exist_count==0) {
                //echo "case 1";
                //add all records to datatree
                //die;
                foreach (array_chunk($properties_array, 100) as $t) {
                    $dataTreeSaved= DataTree::insert($t); //save properties which are not exists in datatree
                }

                $datatree_new_result = DataTree::select('id as property_id', DB::raw('(CASE WHEN PropertyId <> "" THEN  "'.$userid.'" ELSE "'.$userid.'" END) as user_id'))
                                                ->whereIn('APNFormatted', array_values($apn_prop_id_arr))
                                                ->whereIn('PropertyId', array_keys($apn_prop_id_arr))
                                                ->get()->toArray();

                foreach (array_chunk($datatree_new_result, 100) as $t) {
                    $inserted = UserProperty::insert($t);
                }
            } elseif ($total_api_properties == $datatree_result_exist_count) {
                //echo "case 2";
                //update datatree
                $datatree_result = DataTree::select('id as property_id', DB::raw('(CASE WHEN PropertyId <> "" THEN  "'.$userid.'" ELSE "'.$userid.'" END) as user_id'), DB::raw('(CASE WHEN PropertyId <> "" THEN  "'.Carbon::now().'" ELSE "'.Carbon::now().'" END) as created_at'), DB::raw('(CASE WHEN PropertyId <> "" THEN  "'.Carbon::now().'" ELSE "'.Carbon::now().'" END) as updated_at'))
                                            ->whereIn('APNFormatted', array_values($apn_prop_id_arr))
                                            ->whereIn('PropertyId', array_keys($apn_prop_id_arr))
                                            ->get()->toArray();

                //echo "datatree_result ".count($datatree_result);
                $datatree_property_id_arr = array_column($datatree_result, 'property_id');

                $user_prop_result = UserProperty::select('property_id', 'user_id')
                                                  ->whereIn('property_id', array_values($datatree_property_id_arr))
                                                  ->where('user_id', Auth::id())
                                                  ->get()->toArray();

                if (count($user_prop_result) == 0) {
                    //echo "case 2 user count 0";
                    foreach (array_chunk($datatree_result, 100) as $t) {
                        $inserted = UserProperty::insert($t);
                    }
                    //insert into property_result_id
                } elseif (count($user_prop_result) == count($datatree_result)) {
                    //echo "else if";
                } else {
                    //echo "case 2 user count else";
                    $user_property_id_arr      = array_column($user_prop_result, 'property_id');
                    $new_user_properties_data  = array_diff($datatree_property_id_arr, $user_property_id_arr);
                    $datatree_resultNew        = DataTree::select('id as property_id', DB::raw('(CASE WHEN PropertyId <> "" THEN  "'.$userid.'" ELSE "'.$userid.'" END) as user_id'))
                                                                       ->whereIn('id', array_values($new_user_properties_data))->get()->toArray();

                    foreach (array_chunk($datatree_resultNew, 100) as $t) {
                        UserProperty::insert($t);
                    }
                }
            } else {
                //case 3
                //echo "case 3";
                //update datatree
                /* get apn and propertyID which exist in Datatree DB  */
                $datatree_result = DataTree::select('APNFormatted', 'PropertyId')
                                            ->whereIn('APNFormatted', array_values($apn_prop_id_arr))
                                            ->whereIn('PropertyId', array_keys($apn_prop_id_arr))
                                            ->get()->toArray();

                $data_tree_apns_arr = array_column($datatree_result, 'APNFormatted', 'PropertyId');

                //echo "API".$total_api_properties;
                /* get difference between API apn/propertyID with which exists in db i.e. get new data coming in API response  */
                // echo "datatree_result".count($datatree_result);

                $new_properties_data = array_diff_key($apn_prop_id_arr, $data_tree_apns_arr);
                /*  echo "datatree ids ".count($data_tree_apns_arr)."<br />";
        				  echo "new ids ".count($new_properties_data);
        					echo "data_tree_apns_arr";
        					print_r($new_properties_data); */
                /* filter data from api response and remove that which exist in db */
                $newArr = [];
                foreach ($properties_array as $key => $value) {
                    if (in_array($value["PropertyId"], array_keys($new_properties_data)) && in_array($value["APNFormatted"], array_values($new_properties_data))) {
                        $newArr[] = $properties_array[$key];
                    }
                }
                //echo "data_tree_apns_arr".count($newArr);
                /* reset index  */
                //$new_propertyList = array_values($properties_array);
                foreach (array_chunk($newArr, 100) as $t) {
                    $dataTreeSaved= DataTree::insert($t); //save properties which are not exists in datatree
                }

                /* user property data start */
                $datatree_result = DataTree::select('id as property_id', DB::raw('(CASE WHEN PropertyId <> "" THEN  "'.$userid.'" ELSE "'.$userid.'" END) as user_id'))
                                            ->whereIn('APNFormatted', array_values($apn_prop_id_arr))
                                            ->whereIn('PropertyId', array_keys($apn_prop_id_arr))
                                            ->get()->toArray();

                $datatree_property_id_arr = array_column($datatree_result, 'property_id');
                //echo "all data".count($datatree_result);
                $user_prop_result = UserProperty::select('property_id', 'user_id')
                                                  ->whereIn('property_id', array_values($datatree_property_id_arr))
                                                  ->where('user_id', Auth::id())
                                                  ->get()->toArray();

                //echo "user_prop_result".count($user_prop_result);

                if (count($user_prop_result) == 0) {
                    //echo "case 3 user prop 0";
                    foreach (array_chunk($datatree_result, 100) as $t) {
                        $inserted = UserProperty::insert($t);
                    }
                    //insert into property_result_id
                } elseif (count($user_prop_result) == $datatree_result_exist_count) {
                    // echo "case 3 user prop else if";
                    //insert into property_result_id

                    /* foreach (array_chunk($user_prop_result,100) as $t)
                    {
                    $inserted = PropertyResultId::insert($user_prop_result);
                    } */
                } else {
                    //echo "case 3 user prop else";
                    $user_property_id_arr     = array_column($user_prop_result, 'property_id');
                    $new_user_properties_data = array_diff($datatree_property_id_arr, $user_property_id_arr);
                    //echo "new_user_properties_data".count($new_user_properties_data);

                    $datatree_resultNew = DataTree::select('id as property_id', DB::raw('(CASE WHEN id <> "" THEN  "'.$userid.'" ELSE "'.$userid.'" END) as user_id'))
                                                    ->whereIn('id', array_values($new_user_properties_data))->get()->toArray();

                    foreach (array_chunk($datatree_resultNew, 100) as $t) {
                        $inserted = UserProperty::insert($t);
                    }
                }
                /* user property data End */
            }

            /* Finally insert intp property_result_id table start */
            $datatree_result = DataTree::select('id as property_id')
                                        ->whereIn('APNFormatted', array_values($apn_prop_id_arr))
                                        ->whereIn('PropertyId', array_keys($apn_prop_id_arr))
                                        ->get()->toArray();

            $datatree_property_id_arr = array_column($datatree_result, 'property_id');

            $all_user_prop_result = UserProperty::select(
                DB::raw('(CASE WHEN batch_search_email_flag = "1" THEN  "2" ELSE "1" END) as batch_process_email_status'),
                DB::raw('(CASE WHEN batch_search_phone_flag = "1" THEN  "2" ELSE "1" END) as batch_process_phone_status'),
                'property_id',
                'user_id',
                'trash',
                DB::raw('(CASE WHEN property_id <> "" THEN  "'.$results_id.'" ELSE "'.$results_id.'" END) as result_id'),
                DB::raw('(CASE WHEN property_id <> "" THEN  "'.$purchase_group_name.'" ELSE "'.$purchase_group_name.'" END) as purchase_group_name'),
                DB::raw('(CASE WHEN property_id <> "" THEN  "'.Carbon::now().'" ELSE "'.Carbon::now().'" END) as created_at'),
                DB::raw('(CASE WHEN property_id <> "" THEN  "'.Carbon::now().'" ELSE "'.Carbon::now().'" END) as updated_at'),
                DB::raw('(CASE WHEN property_id <> "" THEN  "'.$purchase_property_price.'" ELSE "'.$purchase_property_price.'" END) as per_property_rate')
            )->whereIn('property_id', array_values($datatree_property_id_arr))
                                                  ->where('user_id', Auth::id())
                                                  ->get()->toArray();

            /*   echo "<pre>";
            print_r($all_user_prop_result);
            die;   */
            //echo "all_user_prop_result".count($all_user_prop_result);
            $inserted = PropertyResultId::insert($all_user_prop_result);
            /* Finally insert intp property_result_id table End */
            $recent_property_result= PropertyResultId::select('property_id')->where("result_id", $results_id)->where('user_id', '=', Auth::id())->orderBy('id', 'desc')->get()->toArray();
            //echo "recent_property_result".count($recent_property_result);
            $recent_property_data_tree_id_arr = array_column($recent_property_result, 'property_id');

            $recent_purchased_properties = UserProperty::select(
                'datatree.*',
                DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),
                DB::raw('DATE_FORMAT(user_property.created_at, "%d-%b-%Y %H:%i:%s") as date'),
                'user_property.status',
                'LMSSalePrice as amount',
                'datatree.PropertyId as propertyid',
                'user_property.id as prop_id',
                'batch_search_email_flag',
                'batch_search_phone_flag',
                'opportunity_status'
            )->join('datatree', 'datatree.id', '=', 'user_property.property_id')
                                                        ->where('user_property.user_id', Auth::id())
                                                        ->whereIn("user_property.property_id", array_values($recent_property_data_tree_id_arr))
                                                        ->orderBy('user_property.id', 'desc')->get();
            //removed ->where('trash','0')

            $wordCount = $recent_purchased_properties->count();
            return $this->getResponse(200, 'County List', (Object) array('count'=>$wordCount,'data'=>$recent_purchased_properties,'purchase_group_name'=>$purchase_group_name,'results_id'=>$results_id));
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $exception =  json_decode($e->getResponse()->getBody(), true);
                return $this->getResponse(422, 'if We are having some issues in finding your properties now. Please check back after some time.'.$e->getMessage(), 0);
            //return $this->getResponse(402,$exception["Message"],0);
            } else {
                //return $this->getResponse($e->getMessage(), 503);
                return $this->getResponse(422, 'else We are having some issues in finding your properties now. Please check back after some time'.$e->getMessage(), 0);
            }

            return $this->getResponse(422, 'outside We are having some issues in finding your properties now. Please check back after some time'.$e->getMessage(), 0);
        }
    }
}
