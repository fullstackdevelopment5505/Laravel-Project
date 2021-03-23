<?php

namespace App\Http\Controllers\Api;

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
use App\Model\Contact;
use App\Model\Search;
use App\Model\Crm;
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
use App\Model\Image;
use App\Model\Saved;
use App\Model\Report;
use App\Model\News;
use App\Woc;
use App\ContactLog;
use App\Model\Result;
use Cartalyst\Stripe\Stripe;
use App\ManageGrid;
use App\Page;
use App\Model\Membership;
use App\AboutTeam;
use App\Slider;
use App\Category;
use App\Faq;
use App\Model\Cities;
use App\Model\PropertyGroupName;
use App\Model\PropertyResultId;
use Carbon\Carbon;
use DataTables;
use App\Configuration;
use App\Model\Points;
use App\UserSubscriptions;
use App\Model\Member;
use App\Model\Deposite;
use App\Model\PaymentMaster;

class ExtraController extends MainController
{
    public function testDelete(Request $request)
    {
        $email = env('CONTACT_US_TO_EMAIL');
        $stripe_key = env('STRIPE_KEY');
        $dtapi_auth_username = env('DTAPI_AUTHENTICATE_USERNAME');
        $dtapi_auth_password = env('DTAPI_AUTHENTICATE_PASSWORD');
        $DTAPI_AUTHENTICATE_URL = env('DTAPI_AUTHENTICATE_URL');
        $DTAPI_PROPERTY_COUNT_URL = env('DTAPI_PROPERTY_COUNT_URL');
        $DTAPI_PROPERTY_LIST_URL = env('DTAPI_PROPERTY_LIST_URL');
        $DTAPI_REPORT_DOWNLOAD_URL = env('DTAPI_REPORT_DOWNLOAD_URL');
        echo $stripe_key;
        echo $DTAPI_AUTHENTICATE_URL;
        echo $DTAPI_PROPERTY_COUNT_URL;
        echo $DTAPI_REPORT_DOWNLOAD_URL;
        echo $dtapi_auth_username;
        echo $dtapi_auth_password;
        return $this->getResponse(200, 'records deleted', 1);
    }

    public function duplicatePurchasegroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_group_name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }
        $purchase_group_name = $request->get('purchase_group_name');
        $groupname  = preg_replace('/[+%_-]/s', '', $purchase_group_name);
        $result = PropertyResultId::where('user_id', Auth::id())->groupBy('result_id')->pluck('purchase_group_name');
        $arr =  (array)$result;
        $groupname_exists  =  array_values($arr);
        if (in_array($purchase_group_name, $groupname_exists[0])) {
            return $this->getResponse(422, 'Group name already exists', (Object)[], 0);
        }
        return $this->getResponse(200, 'success', [], 1);
    }


    public function updateUserTermsStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }

        if ($request->get('status') == 0 || $request->get('status') ==1) {
            $updated = User::where('id', Auth::id())->update(['accepted_terms' => $request->get('status')]);
            if ($updated) {
                return $this->getResponse(200, 'terms & conditions accepted', [], 1);
            }
        }
        return $this->getResponse(401, 'Something went wrong! please try after some time.', (Object)[], 0);
    }

    public function termsUpdatedNotification()
    {
        $terms_popup_content = Page::select('page_content as content', 'page_title as title')->where([['deleted_at', null],['page_name', 'terms_popup']])->first();
        $userdata = User::with('subscription')->where('id', Auth::id())->first();
        $prospect = 0;
        if (isset($userdata->subscription)) {
            $end = date('Y-m-d', strtotime($userdata->subscription->plan_period_end) );
            if ($end < date('Y-m-d')) {
                $prospect = 1;
            }
        } else {
            $prospect = 1;
        }
        if ($prospect==1) {
            return $this->getResponse(200, 'Data', (Object)[], 1);
        }
        if ($userdata->accepted_terms == 0) {
            return $this->getResponse(200, 'Data', $terms_popup_content, 1);
        }
        return $this->getResponse(200, 'Data', (Object)[], 1);
    }

    public function privacyPolicyUpdatedNotification()
    {
        $policy_popup_content = Page::select('page_content as content', 'page_title as title')->where([['deleted_at', null],['page_name', 'privacy_policy_popup']])->first();
        $userdata = User::with('subscription')->where('id', Auth::id())->first();
        $prospect = 0;
        if (isset($userdata->subscription)) {
            $end = date( 'Y-m-d', strtotime( $userdata->subscription->plan_period_end ) );
            if ($end < date('Y-m-d')) {
                $prospect = 1;
            }
        } else {
            $prospect = 1;
        }
        if ($prospect==1) {
            return $this->getResponse(200, 'Data', (Object)[], 1);
        }
        if ($userdata->privacy_policy_updated == 0) {
            return $this->getResponse(200, 'Data', $policy_popup_content, 1);
        }
        return $this->getResponse(200, 'Data', (Object)[], 1);
    }
    public function updateUserPrivacyPolicyStatus(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'status' => 'required',
        ] );
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }

        if ($request->get('status') == 0 || $request->get('status') ==1) {
            $updated = User::where('id', Auth::id())->update(['privacy_policy_updated' => $request->get('status')]);
            if ($updated) {
                return $this->getResponse(200, 'Privacy policy accepted', [], 1);
            }
        }
        return $this->getResponse(401, 'Something went wrong! please try after some time.', (Object)[], 0);
    }
    public function sessionCookieContent()
    {
        $cookie     =   Page::select('page_content')->where([['deleted_at', null],['page_name', 'cookie']])->first();
        $session     =   Page::select('page_content', 'page_title')->where([['deleted_at', null],['page_name', 'session']])->first();

        return $this->getResponse(200, 'Data', (Object)array('cookie'=>$cookie,'session'=>$session), 1);
    }

    public function contact(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'phone'      => 'required',
            'description'=> 'required',
        ] );
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }

        $data=array(
            'first_name'=>$request->get('first_name'),
            'last_name'=>$request->get('last_name'),
            'email'=>$request->get('email'),
            'phone'=>$request->get('phone'),
            'address'=>$request->get('address'),
            'description'=>$request->get('description'),
        );
        $created = Contact::create($data);
        $contactRequestId = $created->id;
        $this->sendContactRequestEmail($contactRequestId);

        return $this->getResponse(200, 'Successfully Submitted', $contactRequestId);
    }

    public function sendContactRequestEmail($id)
    {
        $contact_details = Contact::find($id);
        if (isset($contact_details)) {
        //Here send the link with CURL with an external email API
            $email = env('CONTACT_US_TO_EMAIL');

            $data = array(
                'contact_email' => $contact_details->email,
                'name'  => ucfirst($contact_details->first_name.' '.$contact_details->last_name),
                'phone' => $contact_details->phone,
                'description' => $contact_details->description
            );
            try {
                return $contact_details->notify(new ContactRequest($data, 'You received a message from : '.ucfirst($contact_details->first_name.' '.$contact_details->last_name), $email));
            } catch (\Exception $e) { // Using a generic exception
                return $e;
            }
        } else {
            return "error";
        }
    }

    public function getQueries()
    {
        $data = Contact::orderBy("created_at", "desc")->get();
        return $this->getResponse(200, 'Queries Data', $data);
    }

    public function faq()
    {
        $data=DB::table('cms')->select('faq')->first();
        return $this->getResponse(200, 'Detail', $data);
    }

    public function about()
    {
        $data = Page::where('deleted_at', null)->where('page_name', 'about')->first();
        $sliderData = Slider::where('deleted_at', null)->where('type', '1')->get();
        return $this->getResponse(200, 'Detail', (Object)array('AboutData'=>$data,'slider'=>$sliderData));
    }

    public function terms()
    {
        $data1 = DB::table('cms')->select('terms')->first();
        $terms_content = json_decode($data1->terms, true);
        $data = array(
            'page_title' =>  isset($terms_content['page_title']) ? $terms_content['page_title'] : '',
            'page_content' =>  isset($terms_content['page_content']) ? $terms_content['page_content'] : '',
        );
        return $this->getResponse(200, 'Detail', $data);
    }

    public function privacy()
    {
        $data1=DB::table('cms')->select('privacy')->first();
        $privacy_content=json_decode($data1->privacy, true);
        $data=array(
            'page_title' =>  isset($privacy_content['page_title']) ? $privacy_content['page_title'] : '',
            'page_content' =>  isset($privacy_content['page_content']) ? $privacy_content['page_content'] : '',
        );
        return $this->getResponse(200, 'Detail', $data);
    }

    public function career()
    {
        $data=DB::table('cms')->select('career')->first();
        return $this->getResponse(200, 'Detail', $data);
    }


    public function action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'        => 'required',
            'status'         => 'required',
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }
        UserProperty::where('id', $request->get('id'))->update(['status'=>(string)$request->get('status')]);
        return $this->getResponse(200, 'Successfull Submitted');
    }

    public function detail($value)
    {
        $data=DataTree::with('user_property.logs')->select(
            'datatree.*',
            DB::raw('(CASE WHEN LENGTH(datatree.SitusZipCode) = 4 THEN  CONCAT(\'0\',datatree.SitusZipCode) ELSE datatree.SitusZipCode END) as SitusZipCode'),
            'APNFormatted as APN_FORMATTED',
            'MailState',
            'user_property.*',
            'user_property.id as prop_id',
            'LMSSalePrice'
        )
        ->join('user_property', 'user_property.property_id', '=', 'datatree.id')->where('user_id', Auth::id())->where('datatree.PropertyId', $value)->first();
        return $this->getResponse(200, 'Detail', $data);
    }


    public function state()
    {
        $data=DB::table('state_county_fib')->select('state_name', 'state_val as state_id', 'state_code')->groupBy('state_val')->orderBy('id', 'asc')->get();
        return $this->getResponse(200, 'State List', $data);
    }

    public function county($value)
    {
        $data=DB::table('tbl_county_info')->select('county_name', 'county_id')->where('state_name', $value)->orderBy('county_id', 'asc')->get();
        return $this->getResponse(200, 'County List', $data);
    }

    public function countybyStateId($id)
    {
        $data=DB::table('state_county_fib')->select('county_name', 'county_val as county_id')->where('state_val', $id)->orderBy('county_val', 'asc')->get();
        return $this->getResponse(200, 'County List', $data);
    }


    public function UsState()
    {
        $data=DB::table('state_county_fib')->select('state_val as ID', 'state_name as STATE_NAME', 'state_code as STATE_CODE')->groupBy('state_val')->orderBy('id', 'asc')->get();
        return $this->getResponse(200, 'us states', $data);
    }

    public function UsCity($value)
    {
        if ($value != '' || $value != 'undefined') {
            $state_data =DB::table('state_county_fib')->select('state_code')->where('state_val', $value)->first();
            if ($state_data) {
                $data = DB::table('tbl_cities')->select('id as ID', DB::raw('(CASE WHEN state_id <> "" THEN  "'.$value.'" ELSE "'.$value.'" END) as ID_STATE'), 'city as CITY', 'county_name as COUNTY', 'lat as LATITUDE', 'lng as LONGITUDE')->where('state_id', $state_data->state_code)->orderBy('city', 'ASC')->get();
                return $this->getResponse(200, 'us cities', $data);
            }
        }
        return $this->getResponse(422, 'Invalid request', 0);
    }

    public function CityByCounty($state, $county)
    {
        $state_data =DB::table('state_county_fib')->select('state_code', 'state_val', 'state_name')->where('state_val', $state)->first();
        $city_data =DB::table('tbl_cities')->get()->toArray();
        $state_id = $state;
        $dataArr = explode(",", $county);
        $city_data =DB::table('tbl_cities')->select('id as ID', DB::raw('(CASE WHEN state_id <> "" THEN  "'.$state_data->state_val.'" ELSE "'.$state_data->state_val.'" END) as ID_STATE'), 'city as CITY', 'county_name as COUNTY', 'lat as LATITUDE', 'lng as LONGITUDE')->where('state_id', $state_data->state_code)->whereIN('county_name', array_values($dataArr))
        ->orderBy('city', 'asc')->get()->toArray();
        return $this->getResponse(200, 'cities', $city_data);
    }

    public function array_flatten($array)
    {
        if (!is_array($array)) {
            return false;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    public static function unique_key($array, $keyname)
    {
        $new_array = array();
        foreach ($array as $key=>$value) {
            if (!isset($new_array[$value[$keyname]])) {
                $new_array[$value[$keyname]] = $value;
            }
        }
        $new_array = array_values($new_array);
        return $new_array;
    }

    public function getLeads(Request $request)
    {
        $data=UserProperty::select(DB::raw('CONCAT(SitusHouseNumber, \' \',SitusStreetName, \' \',SitusMode) as address'), 'user_property.created_at', 'user_property.status', 'LMSSalePrice as amount', 'datatree.PropertyId as property_id', 'user_property.id as prop_id')->join('datatree', 'datatree.id', '=', 'user_property.property_id')->where('user_property.user_id', Auth::id())->where('trash', '0')->orderBy('user_property.id', 'desc')->get();
        return $this->getResponse(200, 'Search', $data, 1);
    }

    public function getAllLeadsByGroupname($name)
    {
        $named =  urldecode($name);
        $recent_property_result= PropertyResultId::select('property_id', DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'))
        ->where('purchase_group_name', 'LIKE', $named)->where('property_type', 'datatree')->where('user_id', '=', Auth::id())->orderBy('id', 'desc')->get()->toArray();
        $date = $recent_property_result[0]['date'];
        $recent_property_data_tree_id_arr 		= 	array_column($recent_property_result, 'property_id');
        $data = UserProperty::with('logs')->select(
            'user_property.updated_at',
            'opportunity_status',
            'datatree.*',
            DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),
            DB::raw('"'.$date.'" as date'),
            'user_property.status',
            'LMSSalePrice as amount',
			'user_property.*',
            'datatree.PropertyId as property_id',
            'user_property.id as prop_id'
        )
        ->join('datatree', 'datatree.id', '=', 'user_property.property_id')
        ->where('user_property.user_id', Auth::id())
        ->where('property_type', 'datatree')
        ->whereIn("user_property.property_id", array_values($recent_property_data_tree_id_arr))
        ->where('trash', '0')->orderBy('user_property.updated_at', 'desc')->get();
        return $this->getResponse(200, 'All Purchase group records', $data, 1);
    }

    public function getLeadsByGroupname(Request $request)
    {
        $datatable_parameters = $request->get('dataTablesParameters');
        $columns = array_column($datatable_parameters['columns'], 'data');
        $column_name = $columns[$datatable_parameters['order'][0]['column']];
        $name  = $request->get('name');
        $start = $datatable_parameters['start'];
        $draw  = $datatable_parameters['draw'];
        $limit = $datatable_parameters['length'];
        $named = urldecode($name);
        $search= $datatable_parameters['search']['value'];
        $order = $columns[$datatable_parameters['order'][0]['column']];
        $dir   = $datatable_parameters['order'][0]['dir'];
        if ($column_name=='address') {
            $columns =array('SitusHouseNumber' => 'desc', 'SitusStreetName' => 'desc');
        } else {
            $columns =array($column_name => 'desc');
        }
        $recent_property_result= PropertyResultId::select('property_id', DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'))
        ->where( 'purchase_group_name', 'LIKE', $named )->where( 'property_type', 'datatree' )->where( 'user_id', '=', Auth::id() )->orderBy('id','desc')->get()->toArray();
        $date = $recent_property_result[0]['date'];
        $recent_property_data_tree_id_arr = array_column($recent_property_result, 'property_id');
        $total_q=UserProperty::select(
            'datatree.*',
            DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),
            DB::raw('"'.$date.'" as date'),
            'user_property.status',
            'LMSSalePrice as amount',
            'datatree.PropertyId as property_id',
            'user_property.id as prop_id'
        )
        ->join('datatree', 'datatree.id', '=', 'user_property.property_id')
        ->where('user_property.user_id', Auth::id())
        ->where('property_type', 'datatree')
        ->whereIn("user_property.property_id", array_values($recent_property_data_tree_id_arr))->where('trash', '0');
        /*reference to Use cast in query*/
        //DB::raw("CAST(SitusHouseNumber AS CHAR) as address")
        $query = UserProperty::with('logs')->select(
            'user_property.updated_at',
            'user_property.phone_search_flag',
            'email_search_flag',
            'batch_search_email_flag',
            'batch_search_phone_flag',
            'opportunity_status',
            'user_property.email',
            'phone',
            'datatree.*',
            'datatree.id as datatree_id',
            DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),
            DB::raw('"'.$date.'" as date'),
            'user_property.status',
            DB::raw("CAST(LMSSalePrice AS DECIMAL(10,2)) as LMSSalePrice"),
            DB::raw("CAST(LMSSalePrice AS DECIMAL(10,2)) as amount"),
			'user_property.*',
			'user_property.id',
            'user_property.id as prop_id',
			'datatree.PropertyId as property_id',
        )
        ->join('datatree', 'datatree.id', '=', 'user_property.property_id')->where('user_property.user_id', Auth::id())
        ->whereIn("user_property.property_id", array_values($recent_property_data_tree_id_arr))
        ->where('property_type', 'datatree')
        ->where('trash', '0');

        if ($request->get('SitusZipCode') != '') {
            $zip  = str_replace('-', '', $request->get('SitusZipCode'));
            $zipn  =	ltrim($zip, "0");
            $total_q->where('SitusZipCode', $zipn);
            $query->where('SitusZipCode', $zipn);
        }
        if ($request->get('status') != '') {
            $total_q->where('user_property.status', $request->get('status'));
            $query->where('user_property.status', $request->get('status'));
        }
        if ($request->get('SitusCity') != '') {
            $total_q->where('SitusCity', $request->get('SitusCity'));
            $query->where('SitusCity', $request->get('SitusCity'));
        }
        if ($request->get('SitusState') != '') {
            $total_q->where('SitusState', $request->get('SitusState'));
            $query->where('SitusState', $request->get('SitusState'));
        }
        if ($request->get('Owner1FirstName') != '') {
            $total_q->where('Owner1FirstName', $request->get('Owner1FirstName'));
            $query->where('Owner1FirstName', $request->get('Owner1FirstName'));
        }
        if ($request->get('OwnerLastname1') != '') {
            $total_q->where('OwnerLastname1', $request->get('OwnerLastname1'));
            $query->where('OwnerLastname1', $request->get('OwnerLastname1'));
        }
        if ($request->get('phone') != '') {
            $total_q->where('phone', $request->get('phone'));
            $query->where('phone', $request->get('phone'));
        }
        if ($request->get('email') != '') {
            $total_q->where('email', $request->get('email'));
            $query->where('email', $request->get('email'));
        }
        $recordsTotal = $total_q->orderBy($order, $dir)->count();
        if ($limit > 0) {
            $query->offset($start)->limit($limit);
        } else {
            $limit = $recordsTotal;
            $query->offset($start)->limit($limit);
        }
        if ($column_name=='address') {
            $query->orderBy('address', $dir);
        } else {
            $query->orderBy($order, $dir);
        }
        $data_u = $query->get();

        $data = array(
            'draw' => intval($draw),
            'recordsTotal' => intval($recordsTotal),
            'recordsFiltered' => intval($recordsTotal),
            'data' => $data_u->toArray(),
            'purchase_group_name' => $named,
        );
        return $this->getResponse(200, 'Purchase group records', json_encode($data), 1);
    }

    public function deletePermanent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => [ 'required', Rule::exists( 'user_property' )->where( function ($query) {
                $query->where([['user_id', Auth::id()],['trash','1']]);
            })]
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }
        $propdata =  UserProperty::where([['user_id', Auth::id()],['id',$request->get('id')],['trash','1']])->first();
        $property_id = $propdata->property_id;
        UserProperty::where([['user_id', Auth::id()],['id',$request->get('id')],['trash','1']])->delete();
        PropertyResultId::where([['property_id',$property_id],['user_id', Auth::id()],['trash','1']])->delete();
        Report::where([['user_prop_id',$propdata->id],['user_id', Auth::id()]])->delete();
        return $this->getResponse(200, 'Deleted');
    }

    public function pushTrash(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', Rule::exists( 'user_property' )->where(function ($query) {
                $query->where([['user_id', Auth::id()],['trash','0']]);
            })]
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }
        $propdata =  UserProperty::where([['user_id', Auth::id()],['id',$request->get('id')]])->first();
        $property_id = $propdata->property_id;

        UserProperty::where('id', $request->get('id'))->update(['trash'=>'1']);
        PropertyResultId::where([['property_id',$property_id],['user_id', Auth::id()]])->update(['trash'=>'1']);
        return $this->getResponse(200, 'Trashed');
    }

    public function getTrash(Request $request)
    {
        $data=UserProperty::with('logs')->select(
            'user_property.updated_at',
            'user_property.id',
            'user_property.email',
            'user_property.phone_search_flag',
            'email_search_flag',
            'batch_search_email_flag',
            'batch_search_phone_flag',
            'opportunity_status',
            DB::raw('CONCAT(datatree.SitusHouseNumber, \' \', datatree.SitusStreetName, \' \', datatree.SitusMode) as address'),
            'SitusHouseNumber',
            'SitusStreetName',
            'SitusMode',
            DB::raw('(CASE WHEN line_type = "CellLine" THEN  user_property.phone ELSE "" END) as phone'),
            'Owner1FirstName',
            'OwnerLastname1',
            DB::raw('DATE_FORMAT(user_property.updated_at, "%d-%b-%Y %H:%i:%s") as date'),
            'SitusCity',
            'SitusState',
            DB::raw('(CASE WHEN LENGTH(datatree.SitusZipCode) = 4 THEN  CONCAT(\'0\',datatree.SitusZipCode) ELSE datatree.SitusZipCode END) as SitusZipCode'),
            'user_property.created_at',
            'user_property.status',
            'EstimatedValue as amount',
            'datatree.PropertyId as property_id',
            'user_property.id as prop_id'
        )
        ->join('datatree', 'datatree.id', '=', 'user_property.property_id')
        ->where('user_property.user_id', Auth::id())
        ->where('trash', '1')
        ->orderBy('user_property.updated_at', 'desc')->get();
        return $this->getResponse(200, 'Trash', $data, 1);
    }

    public function pullTrash(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'        => [
                'required',
                Rule::exists('user_property')->where(function ($query) {
                    $query->where([['user_id', Auth::id()],['trash','1']]);
                })
                ]
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }
        $propdata =  UserProperty::where([['user_id', Auth::id()],['id',$request->get('id')]])->first();
        $property_id = $propdata->property_id;

        UserProperty::where('id', $request->get('id'))->update(['trash'=>'0']);
        PropertyResultId::where([['property_id',$property_id],['user_id', Auth::id()]])->update(['trash'=>'0']);
        return $this->getResponse(200, 'unTrashed');
    }

    public function profile(Request $request)
    {
        $user=User::with('member', 'subscription', 'details', 'Image')->where('id', Auth::id())->first();
        $member = 0;
        if ($user->subscription == null) {
            $member = 0;
        } elseif ($user->subscription['status']=="canceled") {
            $member = 0;
        } else {
            $member = 1;
        }
        $user->reg_status= $member;
        $user->username = Config::get('app.website_url').'shareaffiliate#'.$user->username;
        return $this->getResponse(200, 'user profile', $user, 1);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name'  => 'required',
            'postal'  => 'required',
            'industry'=> 'required',
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }
        $data=array(
            'f_name'=>$request->get('f_name'),
            'phone'=>$request->get('phone'),
            'postal'=>$request->get('postal'),
            'info'=>$request->get('info'),
            'address'=>$request->get('address'),
            'industry'=>$request->get('industry'),
        );

        if ($request->hasfile('file')) {
            $upld_profile_image = $request->file('file')->store('profile_image');

            $arr=array(
                'user_id'=>Auth::id(),
                'type'=>'1',
            );

            $image=array(
                'filename'=>$upld_profile_image
            );
            Image::updateOrCreate($arr, $image);
        }

        $updated=Detail::updateOrCreate(['user_id' => Auth::id()], $data);

        if ($updated) {
            return $this->getResponse(200, 'Updated Successfully');
        } else {
            return $this->getResponse(422, 'Server issue');
        }
    }

    public function interestedPropertyAll(Request $request)
    {
        $count=UserProperty::with('datatree')->where([['user_id',Auth::id()],['status','1'],['trash','0']])->where('property_type', 'datatree')->count();
        $data=UserProperty::join('datatree', 'datatree.id', '=', 'user_property.property_id')
        ->select(
            'user_property.updated_at',
            'user_property.phone_search_flag',
            'email_search_flag',
            'batch_search_email_flag',
            'batch_search_phone_flag',
            'opportunity_status',
            'user_property.email',
			'datatree.id as datatree_property_id',
            DB::raw('(CASE WHEN line_type = "CellLine" THEN  user_property.phone ELSE "" END) as phone'),
            'datatree.*',
            DB::raw('(CASE WHEN LENGTH(SitusZipCode) = 4 THEN  CONCAT(\'0\',SitusZipCode) ELSE SitusZipCode END) as SitusZipCode'),
            'user_property.id as prop_id',
			'user_property.*'
        )
        ->where([['user_id',Auth::id()],['user_property.status','1'],['trash','0']])
        ->where('property_type', 'datatree')
        ->orderBy('user_property.updated_at', 'desc')
        ->get();
        return $this->getResponse(200, 'List', (Object)array('count'=>$count,'data'=>$data));
    }
    public static function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = self::getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('url', $slug)) {
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('url', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique url');
    }
    public static function getRelatedSlugs($slug, $id = 0)
    {
        return Woc::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }

    public function saveContactLog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id'    => 'required',
            'way_of_contact' => 'required',
            'description'     => 'required',
        ]);

        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }

        $dataP = UserProperty::find($request->get('property_id'));

        if (empty($dataP)) {
            return $this->getResponse(422, 'Invalid property id!', [], 0);
        }
        $woc = $request->get('way_of_contact');
        $data=array(
            'user_property_id'=>$request->get('property_id'),
            'description'=>$request->get('description'),
            'type'=>$woc,
            'user_id' => Auth::id(),
            'contact_date'=>Carbon::now(),
            'contact_time'=>Carbon::now()->toDateTimeString(),
        );
        $contact_log = ContactLog::insert($data);
        if ($contact_log) {
            $userProperty =  UserProperty::find($request->get('property_id'));
            $userProperty->touch();
            return $this->getResponse(200, 'Contact log added successfully', 1, 1);
        }
        return $this->getResponse(422, 'something went wrong!', 0);
    }

    public function contactLogList($property_id)
    {
        $count=ContactLog::with('Woc')->where([['user_id',Auth::id()],['user_property_id',$property_id]])->count();
        $data=ContactLog::with(array('Woc'=>function ($query) {
            $query->select('id', 'name', 'slug');
        }))->select('id', 'user_property_id', 'description', 'contact_date', 'contact_time', 'type', 'woc_id')->where([['user_id',Auth::id()],['user_property_id',$property_id]])->get();
        return $this->getResponse(200, 'Contact log List', (Object)array('count'=>$count,'data'=>$data));
    }

    public function interestedProperty(Request $request)
    {
        $datatable_search =$request->get('search');
        $datatable_order =$request->get('order');

        $columns=array_column($request->get('columns'), 'data');
        $start = $request->get('start');
        $draw = $request->get('draw');
        $limit= $request->get('length');

        $search_s= $datatable_search['value'];
        $order= $columns[$datatable_order[0]['column']];
        $dir = $datatable_order[0]['dir'];
        $search =ltrim($search_s, "0");
        $total_q = UserProperty::join('datatree', 'datatree.id', '=', 'user_property.property_id')
        ->where([['user_property.user_id',Auth::id()],['user_property.status','1'],['trash','0']]);
        $data_q=UserProperty::with('logs')->select(
            'user_property.updated_at',
            'user_property.phone_search_flag',
            'email_search_flag',
            'batch_search_email_flag',
            'batch_search_phone_flag',
            'opportunity_status',
            'user_property.id',
            'user_property.email',
            DB::raw('(CASE WHEN line_type = "CellLine" THEN  user_property.phone ELSE "" END) as phone'),
            'Owner1FirstName',
            'OwnerLastname1',
            'user_property.id as property_id',
            'MktTotalValue',
            'EstimatedValue',
            DB::raw("CAST(LMSSalePrice AS DECIMAL(10,2)) as LMSSalePrice"),
            'SitusCity',
            'SitusState',
            DB::raw('(CASE WHEN LENGTH(datatree.SitusZipCode) = 4 THEN  CONCAT(\'0\',datatree.SitusZipCode) ELSE datatree.SitusZipCode END) as SitusZipCode'),
            'SitusHouseNumber',
            'SitusStreetName',
            'SitusMode',
            DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),
            'datatree.PropertyId',
            'user_property.status',
            'trash',
        )->join('datatree', 'datatree.id', '=', 'user_property.property_id')
         ->where([['user_id',Auth::id()],['user_property.status','1'],['trash','0']]);

        if ($request->get('SitusZipCode') != '') {
            $zip  = str_replace('-', '', $request->get('SitusZipCode'));
            $zipn  =	ltrim($zip, "0");
            $total_q->where('SitusZipCode', $zipn);
            $data_q->where('SitusZipCode', $zipn);
        }
        if ($request->get('SitusCity') != '') {
            $total_q->where('SitusCity', $request->get('SitusCity'));
            $data_q->where('SitusCity', $request->get('SitusCity'));
        }
        if ($request->get('SitusState') != '') {
            $total_q->where('SitusState', $request->get('SitusState'));
            $data_q->where('SitusState', $request->get('SitusState'));
        }
        if ($request->get('Owner1FirstName') != '') {
            $total_q->where('Owner1FirstName', $request->get('Owner1FirstName'));
            $data_q->where('Owner1FirstName', $request->get('Owner1FirstName'));
        }
        if ($request->get('OwnerLastname1') != '') {
            $total_q->where('OwnerLastname1', $request->get('OwnerLastname1'));
            $data_q->where('OwnerLastname1', $request->get('OwnerLastname1'));
        }
        if ($request->get('phone') != '') {
            $total_q->where('phone', $request->get('phone'));
            $data_q->where('phone', $request->get('phone'));
        }
        if ($request->get('email') != '') {
            $total_q->where('email', $request->get('email'));
            $data_q->where('email', $request->get('email'));
        }
        if (!empty($search)) {
            $total_q->where(function ($query) use ($search) {
                return $query->where('Owner1FirstName', 'LIKE', "%{$search}%")
                    ->orWhere('OwnerLastname1', 'LIKE', "%{$search}%")
                    ->orWhere('LMSSalePrice', 'LIKE', "%{$search}%")
                    ->orWhere('SitusCity', 'LIKE', "%{$search}%")
                    ->orWhere('SitusState', 'LIKE', "%{$search}%")
                    ->orWhere('SitusZipCode', 'LIKE', "%{$search}%")
                    ->orWhere('SitusHouseNumber', '=', $search)
                    ->orWhere('SitusStreetName', 'LIKE', "%{$search}%")
                    ->orWhere('SitusMode', 'LIKE', "%{$search}%");
            });

            $data_q->where(function ($query) use ($search) {
                return $query->where('Owner1FirstName', 'LIKE', "%{$search}%")
                    ->orWhere('OwnerLastname1', 'LIKE', "%{$search}%")
                    ->orWhere('LMSSalePrice', 'LIKE', "%{$search}%")
                    ->orWhere('SitusCity', 'LIKE', "%{$search}%")
                    ->orWhere('SitusState', 'LIKE', "%{$search}%")
                    ->orWhere('SitusZipCode', 'LIKE', "%{$search}%")
                    ->orWhere('SitusHouseNumber', '=', $search)
                    ->orWhere('SitusStreetName', 'LIKE', "%{$search}%")
                    ->orWhere('SitusMode', 'LIKE', "%{$search}%");
            });
        }
        $total = $total_q->count();
        if ($limit > 0) {
            $data = $data_q->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $data = $data_q->orderBy($order, $dir)->get();
        }
        $data_R = array(
            'draw' => intval($draw),
            'recordsTotal' => intval($total),
            'recordsFiltered' => intval($total),
            'data' => $data->toArray(),
        );
        return $this->getResponse(200, 'List', json_encode($data_R), 1);
    }

    public function prospectsWithEmailData(Request $request)
    {
        $count=UserProperty::with('datatree')->where('property_type', 'datatree')
        ->where([['user_id',Auth::id()],['email_search_flag',1]])->count();
        $data=UserProperty::with('logs')->join('datatree', 'datatree.id', '=', 'user_property.property_id')
        ->select(
            'opportunity_status',
            'user_property.email',
            'user_property.id as property_id',
            'user_property.status',
            'datatree.*',
            'user_property.id',
            'datatree.id as datatree_id',
            'user_property.updated_at',
            DB::raw('(CASE WHEN LENGTH(SitusZipCode) = 4 THEN  CONCAT(\'0\',SitusZipCode) ELSE SitusZipCode END) as SitusZipCode')
        )
        ->where('property_type', 'datatree')
        ->where([['user_id',Auth::id()],['trash','0'],['email_search_flag',1]])->get();
        return $this->getResponse(200, 'List', (Object)array('count'=>$count,'data'=>$data));
    }

    public function prospectsWithPhoneData(Request $request)
    {
        $count = UserProperty::with('logs')->where('property_type', 'datatree')
        ->where([['user_id',Auth::id()],['trash','0'],['phone_search_flag',1],['line_type','CellLine']])->count();
        $data  = UserProperty::with('logs')->join('datatree', 'datatree.id', '=', 'user_property.property_id')
        ->select(
            'opportunity_status',
            'user_property.phone',
            'user_property.id as property_id',
            'user_property.status',
            'datatree.*',
            'user_property.id',
            'datatree.id as datatree_id',
            'datatree.updated_at as updated_datatree',
            'user_property.updated_at',
            DB::raw('(CASE WHEN LENGTH(SitusZipCode) = 4 THEN  CONCAT(\'0\',SitusZipCode) ELSE SitusZipCode END) as SitusZipCode')
        )
        ->where('property_type', 'datatree')
        ->where([['user_id',Auth::id()],['trash','0'],['phone_search_flag',1],['line_type','CellLine']])->get();

        return $this->getResponse(200, 'List', (Object)array('count'=>$count,'data'=>$data));
    }

    public function highlyInterestedPropertyAll(Request $request)
    {
        $count=UserProperty::with('logs')->where([['user_id',Auth::id()],['status','2'],['trash','0']])->where('property_type', 'datatree')->count();
        $data=UserProperty::with('logs')->join('datatree', 'datatree.id', '=', 'user_property.property_id')->select(
            'user_property.updated_at',
            'user_property.phone_search_flag',
            'email_search_flag',
            'batch_search_email_flag',
            'batch_search_phone_flag',
            'opportunity_status',
            'user_property.email',
            DB::raw('(CASE WHEN line_type = "CellLine" THEN  user_property.phone ELSE "" END) as phone'),
            'datatree.*',
            'user_property.id',
            'datatree.id as datatree_id',
            DB::raw('(CASE WHEN LENGTH(SitusZipCode) = 4 THEN  CONCAT(\'0\',SitusZipCode) ELSE SitusZipCode END) as SitusZipCode'),
			'user_property.*'
        )
        ->where([['user_id',Auth::id()],['user_property.status','2'],['trash','0']])
        ->where('property_type', 'datatree')
        ->orderBy('user_property.updated_at', 'desc')
        ->get();
        return $this->getResponse(200, 'List', (Object)array('count'=>$count,'data'=>$data));
    }

    public function highlyInterestedProperty(Request $request)
    {
        $datatable_search = $request->get('search');
        $datatable_order = $request->get('order');

        $columns= array_column($request->get('columns'), 'data');
        $start= $request->get('start');
        $draw = $request->get('draw');
        $limit = $request->get('length');

        $search_s = $datatable_search['value'];
        $order = $columns[$datatable_order[0]['column']];
        $dir = $datatable_order[0]['dir'];
        $search =ltrim($search_s, "0");

        $total_q = UserProperty::join('datatree', 'datatree.id', '=', 'user_property.property_id')->where('property_type', 'datatree')->where([['user_property.user_id',Auth::id()],['user_property.status','2'],['trash','0']]);

        $data_q=UserProperty::with('logs')->select(
            'user_property.updated_at',
            'user_property.phone_search_flag',
            'email_search_flag',
            'batch_search_email_flag',
            'batch_search_phone_flag',
            'opportunity_status',
            'user_property.email',
            DB::raw('(CASE WHEN line_type = "CellLine" THEN  user_property.phone ELSE "" END) as phone'),
            'user_property.id',
            'Owner1FirstName',
            'OwnerLastname1',
            'user_property.id as property_id',
            'MktTotalValue',
            DB::raw("CAST(LMSSalePrice AS DECIMAL(10,2)) as LMSSalePrice"),
            'EstimatedValue',
            'SitusCity',
            'SitusState',
            'SitusHouseNumber',
            'SitusStreetName',
            'SitusMode',
            DB::raw('(CASE WHEN LENGTH(SitusZipCode) = 4 THEN  CONCAT(\'0\',SitusZipCode) ELSE SitusZipCode END) as SitusZipCode'),
            DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode, \' \', SitusCity, \' \', SitusState) as address'),
            'datatree.PropertyId',
            'user_property.status',
            'trash'
        )->join('datatree', 'datatree.id', '=', 'user_property.property_id')
        ->where([['user_id',Auth::id()],['user_property.status','2'],['trash','0']])
        ->where('property_type', 'datatree');
        if ($request->get('SitusZipCode') != '') {
            $zip  = str_replace('-', '', $request->get('SitusZipCode'));
            $zipn  =	ltrim($zip, "0");
            $total_q->where('SitusZipCode', $zipn);
            $data_q->where('SitusZipCode', $zipn);
        }
        if ($request->get('SitusCity') != '') {
            $total_q->where('SitusCity', $request->get('SitusCity'));
            $data_q->where('SitusCity', $request->get('SitusCity'));
        }
        if ($request->get('SitusState') != '') {
            $total_q->where('SitusState', $request->get('SitusState'));
            $data_q->where('SitusState', $request->get('SitusState'));
        }
        if ($request->get('Owner1FirstName') != '') {
            $total_q->where('Owner1FirstName', $request->get('Owner1FirstName'));
            $data_q->where('Owner1FirstName', $request->get('Owner1FirstName'));
        }
        if ($request->get('OwnerLastname1') != '') {
            $total_q->where('OwnerLastname1', $request->get('OwnerLastname1'));
            $data_q->where('OwnerLastname1', $request->get('OwnerLastname1'));
        }
        if ($request->get('phone') != '') {
            $total_q->where('phone', $request->get('phone'));
            $data_q->where('phone', $request->get('phone'));
        }
        if ($request->get('email') != '') {
            $total_q->where('email', $request->get('email'));
            $data_q->where('email', $request->get('email'));
        }
        if (!empty($search)) {
            $total_q->where(function ($query) use ($search) {
                return $query->where('Owner1FirstName', 'LIKE', "%{$search}%")
                    ->orWhere('OwnerLastname1', 'LIKE', "%{$search}%")
                    ->orWhere('LMSSalePrice', 'LIKE', "%{$search}%")
                    ->orWhere('SitusCity', 'LIKE', "%{$search}%")
                    ->orWhere('SitusState', 'LIKE', "%{$search}%")
                    ->orWhere('SitusZipCode', 'LIKE', "%{$search}%")
                    ->orWhere('SitusHouseNumber', '=', $search)
                    ->orWhere('SitusStreetName', 'LIKE', "%{$search}%")
                    ->orWhere('SitusMode', 'LIKE', "%{$search}%");
            });
            $data_q->where(function ($query) use ($search) {
                return $query->where('Owner1FirstName', 'LIKE', "%{$search}%")
                    ->orWhere('OwnerLastname1', 'LIKE', "%{$search}%")
                    ->orWhere('LMSSalePrice', 'LIKE', "%{$search}%")
                    ->orWhere('SitusCity', 'LIKE', "%{$search}%")
                    ->orWhere('SitusState', 'LIKE', "%{$search}%")
                    ->orWhere('SitusZipCode', 'LIKE', "%{$search}%")
                    ->orWhere('SitusHouseNumber', '=', $search)
                    ->orWhere('SitusStreetName', 'LIKE', "%{$search}%")
                    ->orWhere('SitusMode', 'LIKE', "%{$search}%");
            });
        }
        $total = $total_q->count();

        if ($limit > 0) {
            $data = $data_q->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $data = $data_q->orderBy($order, $dir)->get();
        }
        $data_R = array(
            'draw' => intval($draw),
            'recordsTotal' => intval($total),
            'recordsFiltered' => intval($total),
            'data' => $data->toArray(),
        );
        return $this->getResponse(200, 'List', json_encode($data_R), 1);
    }

    public function trendingProperties()
    {
        $data=UserProperty::with('datatree')->where([['status','2'],['trash','0']])->groupBy("property_id")->havingRaw("COUNT(*) > 5")->get();
        $wordCount = $data->count();
        return $this->getResponse(200, 'List', (Object)array('count'=>$wordCount,'data'=>$data));
    }
    public function home($type)
    {
        $content = DB::table('cms')->select('home')->first();
        $home_content = json_decode($content->home, true);
        if ($type == "banner") {
            $banner["home_slider_title"]         =   isset($home_content['home_slider_title']) ? $home_content['home_slider_title'] : '';
            $banner["home_slider_conent"]        =   isset($home_content['home_slider_conent']) ? $home_content['home_slider_conent'] : '';
            $banner["home_slider_video_title"]   =   isset($home_content['home_slider_video_title']) ? $home_content['home_slider_video_title'] : '';
            $banner["home_slider_video"]         =   isset($home_content['home_slider_video']) ? $home_content['home_slider_video'] : '';
            $banner["home_slider_image"]         =  isset($home_content['home_slider_image']) ? url($home_content["home_slider_image"]) : '';
            return $this->getResponse(200, 'Home Banner', compact('banner'));
        }
        if ($type  == "service") {
            $data = array(
            'service_title_1'           =>  isset($home_content['service_title_1']) ? $home_content['service_title_1'] : '',
            'service_title_1_image'     =>  isset($home_content['service_title_1_image']) ? url($home_content["service_title_1_image"]) : '',
            'service_title_1_content'   =>  isset($home_content['service_title_1_content']) ? $home_content['service_title_1_content'] : '',
            'service_title_2'           =>  isset($home_content['service_title_2']) ? $home_content['service_title_2'] : '',
            'service_title_2_image'     =>  isset($home_content['service_title_2_image']) ? url($home_content["service_title_2_image"]) : '',
            'service_title_2_content'   =>  isset($home_content['service_title_2_content']) ? $home_content['service_title_2_content'] : '',
            'service_title_3'           =>  isset($home_content['service_title_3']) ? $home_content['service_title_3'] : '',
            'service_title_3_image'     =>  isset($home_content['service_title_3_image']) ? url($home_content["service_title_3_image"]) : '',
            'service_title_3_content'   =>  isset($home_content['service_title_3_content']) ? $home_content['service_title_3_content'] : '',
            );
            return $this->getResponse(200, 'Home Services', compact('data'));
        }
        if ($type  == "kickstarter") {
            $data = array(
                'kickstart_section_title'   =>  isset($home_content['kickstart_section_title']) ? $home_content['kickstart_section_title'] : '',
                'kickstart_content'         =>  isset($home_content['kickstart_content']) ? $home_content['kickstart_content'] : '',
            );
            return $this->getResponse(200, 'Home Kickstarter section', compact('data'));
        }
        if ($type  == "counter") {
            $data = array(
                'ca_heading'                =>  isset($home_content['ca_heading']) ? $home_content['ca_heading'] : '',
                'counter_1'                 =>  isset($home_content['counter_1']) ? $home_content['counter_1'] : '',
                'title_1'                   =>  isset($home_content['title_1']) ? $home_content['title_1'] : '',
                'counter_2'                 =>  isset($home_content['counter_1']) ? $home_content['counter_2'] : '',
                'title_2'                   =>  isset($home_content['title_1']) ? $home_content['title_2'] : '',
                'counter_3'                 =>  isset($home_content['counter_1']) ? $home_content['counter_3'] : '',
                'title_3'                   =>  isset($home_content['title_1']) ? $home_content['title_3'] : '',
                'counter_4'                 =>  isset($home_content['counter_1']) ? $home_content['counter_4'] : '',
                'title_4'                   =>  isset($home_content['title_1']) ? $home_content['title_4'] : '',
                'counter_5'                 =>  isset($home_content['counter_1']) ? $home_content['counter_5'] : '',
                'title_5'                   =>  isset($home_content['title_1']) ? $home_content['title_5'] : '',
            );
            return $this->getResponse(200, 'Home Counter section', compact('data'));
        }
        if ($type  == "playstore") {
            $play_store_images  = Slider::where('deleted_at', null)->where('type', '2')->get();
            $data = array(
                'playstore_content'         =>  isset($home_content['playstore_content']) ? $home_content['playstore_content'] : '',
                'playstore_title'           =>  isset($home_content['playstore_title']) ? $home_content['playstore_title'] : '',
            );
            return $this->getResponse(200, 'Home Playstore section', compact('data', 'play_store_images'));
        }
        return $this->getResponse(422, 'Invalid request');
    }
    public function cms(Request $request)
    {
        if ($request->get("page") == "footer-copyright") {
            $content = DB::table('cms')->select('home')->first();
            $home_content = json_decode($content->home, true);
            $footer = array();
            $footer["footer_copyright"] = $home_content["footer_copyright"];
            return $this->getResponse(200, 'Copyright Content', $footer);
        }

        if ($request->get("page") == "faqs") {
            $data=Faq::select('id', 'question as title', 'answer as content')->orderBy('id', 'ASC')->get();

            return $this->getResponse(200, 'Faqs', $data);
        }

        if ($request->get("page") == "affiliate") {
            $data_arr  			=   Page::where('deleted_at', null)->where('page_name', 'affiliate')->first();
            $extra_content 	= 	[];
            if ($data_arr) {
                $extra_content    = json_decode($data_arr->extra_content, true);
            }
            $data  = [];
            $data['become_affiliate_button']= isset($extra_content['become_affiliate_button']) ? $extra_content['become_affiliate_button'] : '';
            $data['banner']['banner_title'] = isset($extra_content['banner']['banner_title']) ? $extra_content['banner']['banner_title'] : '';
            $data['banner']['banner_content'] = isset($extra_content['banner']['banner_content']) ? $extra_content['banner']['banner_content'] : '';
            $data['get_started']['title'] = isset($extra_content['get_started']['title']) ? $extra_content['get_started']['title'] : '';
            $data['get_started']['description'] = isset($extra_content['get_started']['description']) ? $extra_content['get_started']['description'] : '';
            $data['get_started']['box']['title_1'] = isset($extra_content['get_started']['box']['title_1']) ? $extra_content['get_started']['box']['title_1'] : '';
            $data['get_started']['box']['content_1'] = isset($extra_content['get_started']['box']['content_1']) ? $extra_content['get_started']['box']['content_1'] : '';
            $data['get_started']['box']['title_2'] = isset($extra_content['get_started']['box']['title_2']) ? $extra_content['get_started']['box']['title_2'] : '';
            $data['get_started']['box']['content_2'] = isset($extra_content['get_started']['box']['content_2']) ? $extra_content['get_started']['box']['content_2'] : '';
            $data['get_started']['box']['title_3'] = isset($extra_content['get_started']['box']['title_3']) ? $extra_content['get_started']['box']['title_3'] : '';
            $data['get_started']['box']['content_3'] = isset($extra_content['get_started']['box']['content_3']) ? $extra_content['get_started']['box']['content_3'] : '';
            $data['after_getstarted']['title'] = isset($extra_content['after_getstarted']['title']) ? $extra_content['after_getstarted']['title'] : '';
            $data['after_getstarted']['description'] = isset($extra_content['after_getstarted']['description']) ? $extra_content['after_getstarted']['description'] : '';
            $data['after_getstarted']['box']['title_1'] = isset($extra_content['after_getstarted']['box']['title_1']) ? $extra_content['after_getstarted']['box']['title_1'] : '';
            $data['after_getstarted']['box']['content_1'] = isset($extra_content['after_getstarted']['box']['content_1']) ? $extra_content['after_getstarted']['box']['content_1'] : '';
            $data['after_getstarted']['box']['title_2'] = isset($extra_content['after_getstarted']['box']['title_2']) ? $extra_content['after_getstarted']['box']['title_2'] : '';
            $data['after_getstarted']['box']['content_2'] = isset($extra_content['after_getstarted']['box']['content_2']) ? $extra_content['after_getstarted']['box']['content_2'] : '';
            $data['after_getstarted']['box']['title_3'] = isset($extra_content['after_getstarted']['box']['title_3']) ? $extra_content['after_getstarted']['box']['title_3'] : '';
            $data['after_getstarted']['box']['content_3'] = isset($extra_content['after_getstarted']['box']['content_1']) ? $extra_content['after_getstarted']['box']['content_1'] : '';
            $data['after_getstarted']['box']['title_4'] = isset($extra_content['after_getstarted']['box']['title_4']) ? $extra_content['after_getstarted']['box']['title_4'] : '';
            $data['after_getstarted']['box']['content_4'] = isset($extra_content['after_getstarted']['box']['content_4']) ? $extra_content['after_getstarted']['box']['content_4'] : '';
            $data['after_getstarted']['box']['title_5'] = isset($extra_content['after_getstarted']['box']['title_5']) ? $extra_content['after_getstarted']['box']['title_5'] : '';
            $data['after_getstarted']['box']['content_5'] = isset($extra_content['after_getstarted']['box']['content_5']) ? $extra_content['after_getstarted']['box']['content_5'] : '';
            $data['after_getstarted']['box']['title_6'] = isset($extra_content['after_getstarted']['box']['title_6']) ? $extra_content['after_getstarted']['box']['title_6'] : '';
            $data['after_getstarted']['box']['content_6'] = isset($extra_content['after_getstarted']['box']['content_6']) ? $extra_content['after_getstarted']['box']['content_6'] : '';
            $data['program_benefits']['title'] = isset($extra_content['program_benefits']['title']) ? $extra_content['program_benefits']['title'] : '';
            $data['program_benefits']['description'] = isset($extra_content['program_benefits']['description']) ? $extra_content['program_benefits']['description'] : '';
            return $this->getResponse(200, 'Affiliate', $data);
        }
        if ($request->get("page") == "become_member_popup") {
            $data  =   Page::where('deleted_at', null)->where('page_name', 'popup')->first();
            $extra_content 	= 	[];
            if ($data) {
                $extra_content    =
                json_decode($data->extra_content, true);
            }

            $data   =   array(
                'become_member_popup_title'   =>  isset($extra_content['become_member_popup_title']) ? $extra_content['become_member_popup_title'] : '',
                'become_member_popup_content'   =>  isset($extra_content['become_member_popup_content']) ? $extra_content['become_member_popup_content'] : '',
            );
            return $this->getResponse(200, 'Become member popup', $data);
        }
        if ($request->get("page") == "career") {
            $data=DB::table('cms')->select('career')->first();

            return $this->getResponse(200, 'Career Page', $data);
        }
        if ($request->get("page") == "contact") {
            $data = Page::where('deleted_at', null)->where('page_name', 'contact')->first();

            return $this->getResponse(200, 'Contact Page', $data);
        }
        if ($request->get("page") == "home") {
            $content = DB::table('cms')->select('home')->first();
            $home_content = json_decode($content->home, true);
            if (!empty($home_content["home_slider_image"])) {
                $home_content["home_slider_image"] = url($home_content["home_slider_image"]);
            }
            if (!empty($home_content["service_title_1_image"])) {
                $home_content["service_title_1_image"] = url($home_content["service_title_1_image"]);
            }
            if (!empty($home_content["service_title_2_image"])) {
                $home_content["service_title_2_image"] = url($home_content["service_title_2_image"]);
            }
            if (!empty($home_content["service_title_3_image"])) {
                $home_content["service_title_3_image"] = url($home_content["service_title_3_image"]);
            }
            if (!empty($home_content["footer_logo"])) {
                $home_content["footer_logo"] = url($home_content["footer_logo"]);
            }
            $imagesArr  = Slider::where('deleted_at', null)->where('type', '2')->get();
            return $this->getResponse(200, 'Home Page', (Object)array('play_store_images'=>$imagesArr,'data'=>$home_content));
        }
        if ($request->get("page") == "membership") {
            $data = Page::where('deleted_at', null)->where('page_name', 'membership')->first();
            $extra_content = json_decode($data->extra_content, true);
            if (!empty($extra_content["box_image_1"])) {
                $extra_content["box_image_1"] = url($extra_content["box_image_1"]);
            }
            if (!empty($extra_content["box_image_2"])) {
                $extra_content["box_image_2"] = url($extra_content["box_image_2"]);
            }
            if (!empty($extra_content["box_image_3"])) {
                $extra_content["box_image_3"] = url($extra_content["box_image_3"]);
            }
            $data->extra_content = $extra_content;
            $plan = Membership::first();

            return $this->getResponse(200, 'Membership Page', (Object)array('membership_plan_data'=>$plan,'data'=>$data));
        }
        if ($request->get("page") == "signup") {
            $data = Page::where('deleted_at', null)->where('page_name', 'signup')->first();
            $extra_content = $data->extra_content;
            return $this->getResponse(200, 'Signup Page', $extra_content);
        }
        if ($request->get("page") == "login") {
            $data = Page::where('deleted_at', null)->where('page_name', 'login')->first();
            return $this->getResponse(200, 'Login Page', $data);
        }
        return $this->getResponse(422, 'page not found');
    }

    public function removeIntrested(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }
        UserProperty::where([['user_id',Auth::id()],['id',$request->get('id')]])->update(['status'=>'0']);
        return $this->getResponse(200, 'Updated Successfully');
    }

    public function renamePurchaseGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'old_group_name' => 'required',
            'new_group_name' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }

        $user_id = $request->get('user_id');
        $old_group_name =  $request->get('old_group_name');
        $new_group_name = $request->get('new_group_name');

        $groupname  = preg_replace('/[+%_-]/s', '', $new_group_name);

        $result = PropertyResultId::where('user_id', Auth::id())->groupBy('result_id')->pluck('purchase_group_name');

        $arr =  (array)$result;
        $groupname_exists  =  array_values($arr);
        if (in_array($groupname, $groupname_exists[0])) {
            return $this->getResponse(422, 'Group name already exists', (Object)[], 0);
        }
        $updated = PropertyResultId::where([['user_id',$user_id],['purchase_group_name',$old_group_name]])->update(array(
            'purchase_group_name' => $new_group_name,
        ));
        if ($updated) {
            return $this->getResponse(200, 'rename group successfully');
        }
        return $this->getResponse(422, 'error', 0);
    }

    public function renameSavedSearchTitle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
            'old_search_title'=>'required',
            'new_search_title'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }
        $user_id = $request->get('user_id');
        $old_search_title= $request->get('old_search_title');
        $new_search_title= $request->get('new_search_title');

        $updated = Saved::where([['user_id',$user_id],['title',$old_search_title]])->update(array('title' =>  $new_search_title,
        ));
        if ($updated) {
            return $this->getResponse(200, 'rename title successfully');
        }

        return $this->getResponse(422, 'search title does not exist.', 0);
    }

    public function getPurchaseGroup(Request $request)
    {
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
            'id',
            'user_id',
            'property_id',
            DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'),
            'batch_process_email_status',
            'batch_process_phone_status',
            'purchase_group_name',
            DB::raw('count(result_id) as total'),
            'result_id'
        )->where('user_id', Auth::id())->where('trash', '0')
        ->whereNotNull('purchase_group_name')
        ->where('property_type', 'datatree')
        ->groupBy('result_id')
        ->orderBy('id', 'desc')->get();
        $wordCount = $data->count();
        $dataArr = PropertyResultId::select(
            'id',
            'user_id',
            'property_id',
            DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'),
            'batch_process_email_status',
            'batch_process_phone_status',
            'purchase_group_name',
            'result_id'
        )->where('user_id', Auth::id())->where('trash', '0')
        ->whereNotNull('purchase_group_name')
        ->where('property_type', 'datatree')
        ->orderBy('id', 'desc')->get()->toArray();
        $flagArr =[];
        $datan =[];
        foreach ($data as $key => $val) {
            $totalGrey = 0;
            $totalTeal = 0;
            $totalGreen = 0;
            $totalGreyE = 0;
            $totalGreyP = 0;
            $green_e =0;
            $green_p =0;
            $tt_ee = 0;
            foreach ($dataArr as $key => $value) {
                if ($val->result_id == $value['result_id']) {
                    if ($value['batch_process_email_status']=="1") {
                        $totalGreyE = $totalGreyE+1;
                    }
                    if ($value['batch_process_phone_status']=="1") {
                        $totalGreyP = $totalGreyP+1;
                    }
                    if ($value['batch_process_phone_status']=="3" || $value['batch_process_email_status']=="3" || $value['batch_process_phone_status']=="2" || $value['batch_process_email_status']=="2") {
                        $totalGreen = $totalGreen+1;
                    }
                    if ($value['batch_process_phone_status']=="3"  || $value['batch_process_phone_status']=="2") {
                        $green_e = $green_e+1;
                    }
                    if ($value['batch_process_email_status']=="3"  || $value['batch_process_email_status']=="2") {
                        $green_p = $green_p+1;
                    }
                }
                $totalGrey_e = $val->total-$green_e;
                $totalGrey_p = $val->total-$green_p;
                $totalGrey = $totalGrey_e+$totalGrey_p;
                $green_total_both = $green_e+$green_p;
            }
            $overall_total = 2*$val->total;
            if ($green_total_both == $overall_total) {
                $val['green_flag']=1;
            }
            if ($green_total_both < $overall_total && $totalGrey != $overall_total) {
                $val['teal_flag']=1;
            }
            if ($totalGrey == $overall_total) {
                $val['grey_flag']=1;
            }
            $val['total_green_flag_e']=$green_e;
            $val['total_grey_flag_e']=$totalGrey_e;
            $val['total_teal_flag_e']=$totalTeal;
            $val['total_green_flag_p']=$green_p;
            $val['total_grey_flag_p']=$totalGrey_p;
            $val['total_teal_flag_p']=$totalTeal;
            array_push($flagArr, $val);
        }
        if ($wordCount>0) {
            array_push($datan, $flagArr);
        }

        /* reference to use of push
        foreach($data as $val){
            $val['purchase_group_url'] = str_replace('%2F','%252F', urlencode($val->purchase_group_name));
            $vouchers = (object)$val;

        } */
        //$data->push($vouchers);

        return $this->getResponse(200, 'Purchase Group ', (Object)array('total-records' => $wordCount,'data' => $flagArr));
    }

    public function saveSearch(Request $request)
    {
        $savedTitle = date('Ymd') . '-' . time() . '-' . Auth::id();

        if ($request->get('savedTitle') !="") {
            $savedTitle = $request->get('savedTitle');
        }
        $search=array(
            'country'=>'US',
            'state'=>$request->get('state'),
            'county'=>$request->get('county'),
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
        );
        $data=array(
            'unique_id'=>uniqid(),
            'user_id'=>Auth::id(),
            'search'=>json_encode($request->except('savedTitle', 'purchaseGroupName')),
            'title'=>$savedTitle,
            'folder_name'=>$savedTitle,
        );
        Saved::create($data);
        return $this->getResponse(200, 'Result Saved');
    }

    public function savedSearch()
    {
        $data=Saved::select("*", DB::raw("DATE_FORMAT(created_at,'%d-%b-%Y %H:%i:%s') AS date"))->where('user_id', Auth::id())->orderBy('id', 'desc')->orderBy('created_at', 'desc')->skip(0)->take(5)->get(); //punch2
        return $this->getResponse(200, 'Saved Searches', $data);
    }

    public function savedSearchUser($value)
    {
        $data=Saved::where([['user_id',Auth::id()],['unique_id',$value]])->first();
        return $this->getResponse(200, 'Saved ', json_decode($data->search));
    }

    public function note(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => 'required',
            'note' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->getResponse(422, $validator->errors()->first(), $validator->errors(), 0);
        }
        UserProperty::where([['user_id',Auth::id()],['id',$request->get('id')]])->update(['notes'=>$request->get('note')]);
        return $this->getResponse(200, 'Successfully Updated');
    }

    public function dashboard()
    {
        $intrestedCount=UserProperty::with('datatree')->where('property_type', 'datatree')->where([['user_id',Auth::id()],['status','1'],['trash','0']])->count();
        $intrestedData=UserProperty::with('datatree', 'logs')->where('property_type', 'datatree')->where([['user_id',Auth::id()],['status','1'],['trash','0']])->orderBy('user_property.updated_at', 'desc')->skip(0)->take(4)->get();
        $highlyCount=UserProperty::with('datatree')->where('property_type', 'datatree')->where([['user_id',Auth::id()],['status','2'],['trash','0']])->count();
        $highlyData=UserProperty::with('datatree', 'logs')->where('property_type', 'datatree')->where([['user_id',Auth::id()],['status','2'],['trash','0']])->orderBy('user_property.updated_at', 'desc')->skip(0)->take(4)->get();
        $reportCount=Report::where('tbl_purchased_records.user_id', Auth::id())->count();
        $searchCount=Saved::where('user_id', Auth::id())->count();
        return $this->getResponse(200, 'Dashboard', (Object)array('intrestedCount'=>$intrestedCount,'highlyCount'=>$highlyCount,'reportCount'=>$reportCount,'searchCount'=>$searchCount,'intrestedData'=>$intrestedData,'highlyData'=>$highlyData,));
    }

    public function newsList(Request $request)
    {
        $data=News::with("category_detail", "role_detail")->select(DB::raw("(CASE WHEN vimeo_id !='' THEN  CONCAT('https://player.vimeo.com/video/',vimeo_id) ELSE '' END) as vimeo_url"), 'id', 'category', 'url', 'title', 'posted_by_role', DB::raw('DATE_FORMAT(date, "%d-%b-%Y") as date'), 'small_description', 'filename', 'vimeo_id')->orderBy('id', 'desc')->skip(0)->take(20)->get();
        $recent=News::with("category_detail", "role_detail")->select(DB::raw("(CASE WHEN vimeo_id !='' THEN  CONCAT('https://player.vimeo.com/video/',vimeo_id) ELSE '' END) as vimeo_url"), 'id', 'category', 'url', 'title', 'posted_by_role', 'date', 'small_description', 'filename', 'vimeo_id')->orderBy('id', 'desc')->orderBy('id', 'desc')->skip(0)->take(8)->get();
        $category = Category::select('tbl_category.*')->Join('news', 'tbl_category.id', '=', 'news.category')->orderBy('tbl_category.id', 'desc')->groupBy('news.category')->get();
        return $this->getResponse(200, 'News List', (Object)array('data'=>$data,'recent'=>$recent,'category'=>$category));
    }

    public function newsListCatgory($id)
    {
        $data=News::with("category_detail", "role_detail")->where("category", $id)->orderBy('id', 'desc')->get();
        $total = $data->count();
        return $this->getResponse(200, 'News List', (Object)array('total'=>$total,'data'=>$data));
    }

    public function newsDetail($url)
    {
        $data = News::with(array('category_detail'=>function ($query) {
            $query->select('id', 'category_url', 'name');
        }))->with(array('role_detail'=>function ($query) {
            $query->select('id', 'role');
        }))->select(DB::raw("(CASE WHEN vimeo_id !='' THEN  CONCAT('https://player.vimeo.com/video/',vimeo_id) ELSE '' END) as vimeo_url"), 'id', 'category', 'title', 'posted_by_role', DB::raw('DATE_FORMAT(date, "%d-%b-%Y") as date'), 'description', 'filename', 'views', 'vimeo_id')->where('url', $url)->first();
        $related_news = News::where('category', $data->category)->where('id', '<>', $data->id)->orderBy('id', 'desc')->get();
        $category_recent_news=News::where('category', $data->category)->select('id', 'category', 'url', 'title')->orderBy('id', 'desc')->skip(0)->take(8)->get();
        $category= Category::with(array('newsList'=>function ($query) {
            $query->select('url', 'category');
            $query->orderBy('id', 'desc');
        }))->has('newsList')->orderBy('id', 'desc')->get();
        return $this->getResponse(200, 'News Detail', (Object)array('data'=>$data,'related_news'=>$related_news,'category_recent_news'=>$category_recent_news,'category'=>$category));
    }


    public function teamList(Request $request)
    {
        $data = AboutTeam::where('deleted_at', null)->orderBy(DB::raw('CASE WHEN designation="CEO" THEN "1" WHEN designation="CAO" THEN "2" WHEN designation="Manager" THEN "3"  WHEN designation="Partner" THEN "4"
        ELSE "5" END'), 'ASC')->get();
        $category=AboutTeam::select('designation')->distinct()->get();
        return $this->getResponse(200, 'Team List', (Object)array('team_list'=>$data));
    }

    public function teamDetail($id)
    {
        $data=AboutTeam::where('id', $id)->first();
        return $this->getResponse(200, 'Team Detail', compact('data'));
    }


    public function getFooterContent()
    {
        $content = DB::table('cms')->select('home')->first();
        $home_content = json_decode($content->home, true);
        $footer = array();
        $footer["footer_content"] = $home_content["footer_content"];
        $footer["fb_url"] = $home_content["fb_url"];
        $footer["twt_url"] = $home_content["twt_url"];
        $footer["pin_url"] = $home_content["pin_url"];
        $footer["insta_url"] = $home_content["insta_url"];
        $footer["linkedin_url"] = $home_content["linkedin_url"];
        $footer["youtube_url"] = isset($home_content["youtube_url"]) ? $home_content["youtube_url"] : '';
        if (!empty($home_content["footer_logo"])) {
            $footer["footer_logo"] = url($home_content["footer_logo"]);
        }
        $data=News::with("category_detail", "role_detail")->select(DB::raw("(CASE WHEN vimeo_id !='' THEN  CONCAT('https://player.vimeo.com/video/',vimeo_id) ELSE '' END) as vimeo_url"), 'url', 'title', 'category', 'posted_by_role', 'date', 'small_description', 'filename', 'vimeo_id', 'created_at')->orderBy('id', 'desc')->skip(0)->take(2)->get();
        return $this->getResponse(200, 'News List', compact('data', 'footer'));
    }


    public function getPurchaseRecords()
    {
        $data = DB::table('tbl_purchased_records')->select(
            'tbl_purchased_records.report_name AS name',
            'tbl_purchased_records.created_at AS date',
            'points_transaction.point',
            DB::raw("DATE_FORMAT(tbl_purchased_records.created_at,'%h:%i %p') AS time")
        )
            ->leftJoin('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
            ->leftJoin('users', 'tbl_purchased_records.user_id', '=', 'users.id')
            ->where('tbl_purchased_records.user_id', Auth::id())->get();
        $wordCount = $data->count();
        return $this->getResponse(200, 'Purchased record list', (Object)array('count'=>$wordCount,'data'=>$data));
    }

    public function getPropertyImage($value='')
    {
        $property=DataTree::with('property_image')->select(DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode, \' \', SitusCity, \' \', SitusState , \' \', SitusZipCode) as Address'), 'PropertyId')->where('PropertyId', $value)->first();
        $data=@json_decode(file_get_contents("https://maps.googleapis.com/maps/api/place/textsearch/json?query=".urlencode($property->Address)."&key=AIzaSyD8Aphh9TfxhOqU6-RzeMWt0l8oIzVa8MU"));

        if (isset($data->results) &&  count($data->results)>0 && isset($data->results[0]->geometry) && isset($data->results[0]->geometry->location) && isset($data->results[0]->geometry->location->lat) && isset($data->results[0]->geometry->location->lng)) {
            $lat=$data->results[0]->geometry->location->lat;
            $lng=$data->results[0]->geometry->location->lng;
        } else {
            $lat=0;
            $lng=0;
        }
        if ($property->property_image==null) {
            if (isset($data->results) && count($data->results)>0 && isset($data->results[0]->photos) && count($data->results[0]->photos)>0 && isset($data->results[0]->photos[0]->photo_reference)) {
                $imgUrl="https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=".$data->results[0]->photos[0]->photo_reference."&key=AIzaSyD8Aphh9TfxhOqU6-RzeMWt0l8oIzVa8MU";
                $time='property_image/'.md5(uniqid().time()).'.png';
                copy($imgUrl, storage_path('app/'.$time));
                $profile_image_data = array(
                        'type' => 3,
                        'user_id' => $value,
                        'filename' => $time,
                    );
                $added_img = Image::create($profile_image_data);
            } else {
                $profile_image_data = array(
                    'type' => 3,
                    'user_id' => $value,
                    'filename' => 'property_image/property.jpg',
                );
                $added_img = Image::create($profile_image_data);
            }
            $prop=DataTree::with('property_image')->select('Address', 'PropertyId')->where('PropertyId', $value)->first();

            return $this->getResponse(200, 'Image url', (Object)array('image_url'=>$prop->property_image->filename,'lat'=>$lat,'lng'=>$lng));
        } else {
            return $this->getResponse(200, 'Image url', (Object)array('image_url'=>$property->property_image->filename,'lat'=>$lat,'lng'=>$lng));
        }
    }

    public function send_email()
    {
        $to_name = '';
        $to_email = '';
        $data = array('name'=>"Ogbonna Vitalis(sender_name)", "body" => "A test mail");
        Mail::send('emails.mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
            ->subject('Laravel Test Mail');
            $message->from('SENDER_EMAIL_ADDRESS', 'Test Mail');
        });
    }

    public function getProspectsEmail(Request $request)
    {
        // declare variables
        $search_methods = array('first1', 'last1', 'address', 'city', 'state', 'zip'); // search parameters
        $table_name = 'datatree';
        $property_id_in_arrays = explode(',', $request->input('property_id'));
        $numRows = count($property_id_in_arrays);
        /**
         *
         *
         * EMAIL SEARCH
         *
         *
        */
        $data = [];
        // build urls and dispatch jobs
        for ($i = 0; $i < $numRows; $i++) {
            $items = DB::table('user_property')->select('email_search_flag', 'property_id')->where('id', '=', $property_id_in_arrays[$i])->get();

            $flag_check 	= 	$items[0]->email_search_flag;
            $datetree_id 	= 	$items[0]->property_id;

            if ($flag_check == 0) {
                $tempUrl = $this->createUrl($datetree_id, $search_methods, 'user_property', 'email');
                $client = new Client();
                $response = $client->request('GET', $tempUrl);
                $result = $response->getBody()->getContents();
                // convert json string to arary
                 $jsonString = json_decode($result, true); // decode the json string
                $resut_array = $jsonString['datafinder'];
                if (!empty($resut_array)) {
                    $data[] =  $resut_array;
                }
            }
        }
        return $this->getResponse(200, 'Email Data', $data, 1);
    }

    // createUrl function
    // creates urls based on parameters passed
    public function createUrl($datetree_id, $search_methods, $table_name, $service)
    {
        // api details
        $k2 = "mwvtwwxeiooupkh2jwvojzdc";
        $DataFinderUrl = "https://api.datafinder.com/qdf.php?service=" . $service . "&k2=";
        $Token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVc2VySUQiOiIxMjM3NDkiLCJBY2NvdW50SUQiOiIyMDA3ODQzIiwiVXNlck5hbWUiOiJEVEFQSV9BZmZvcmRhYmxlSG9tZXNfVUFUIiwiTmFtZSI6IlJvYmVydCBDYXlvdWV0dGUiLCJVc2VyRW1haWwiOiJCRGl4b25AZmlyc3RhbS5jb20iLCJJU1JlZmVyZW5jZVJlcXVpcmVkIjoiMCIsIkFjY291bnRUeXBlIjoiMCIsIkF2YWlsYWJsZVByb2R1Y3RzIjoiW1wiNTAwMVwiLFwiMTAwMVwiLFwiMTAwOFwiLFwiMTAwMlwiLFwiMTA1M1wiLFwiMTAxMFwiLFwiMTAwM1wiLFwiMjAyOFwiLFwiMTAwNVwiLFwiMTAwOVwiLFwiMTAwNlwiLFwiMTAxMVwiLFwiMjA1N1wiLFwiMjA3OFwiLFwiMjA1OFwiXSIsIm5iZiI6MTU2ODM4MDQ0MCwiZXhwIjoxNTY4Mzg3NjQwLCJpYXQiOjE1NjgzODA0NDAsImlzcyI6Imh0dHBzOi8vZHRhcGl1YXQuZGF0YXRyZWUuY29tIiwiYXVkIjoiV2ViQXBpQ29uc3VtZXJzLyJ9.k3Yg0rEUZz5oT7boHN5akF9qbO1pF4R9CUNRP6QIpF4";
        // examples of how url should look
        // $searchUrl = $DataFinderUrl . $k2 . '&d_' . $search_methods[0] . '=' . $input1 . '&d_' . $search_methods[1] . '=' . $input2 . '&d_' . $search_methods[2] . '=' . $input3;
        // $searchUrl = $DataFinderUrl . $k2 . '&d_address=' . $address . '&d_city=' . $city . "&d_state=" . $state;

        // variables necessary for url creation
        $searchUrl = $DataFinderUrl . $k2;
        $datatree_data = DB::table('datatree')->select('SitusHouseNumber', 'SitusStreetName', 'SitusMode', 'Owner1FirstName as first', 'OwnerLastname1 as last', 'SitusCity as city', 'SitusState as state', 'SitusZipCode as zip', 'SitusHouseNumber as address')->where('id', '=', $datetree_id)->first();
        $datatree_data->address  = $datatree_data->SitusHouseNumber." ".$datatree_data->SitusStreetName." ".$datatree_data->SitusMode." ".$datatree_data->city." ".$datatree_data->state." ".$datatree_data->zip;
        // create the url to call
        for ($i = 0; $i < count($search_methods); $i++) {
            if ($search_methods[$i] === 'first' || $search_methods[$i] === 'last' || $search_methods[$i] === 'city' || $search_methods[$i] === 'state' || $search_methods[$i] === 'zip' || $search_methods[$i] === 'address') {
                $tempSearchVar = $search_methods[$i]; // remove either 1 or 2 from end of string
                $searchUrl .= '&d_' . $tempSearchVar . '=' . $datatree_data->$tempSearchVar;
            }
        }

        // fill in blank spaces with %20
        $searchUrl = str_replace(' ', '%20', $searchUrl);

        // return the url
        return $searchUrl;
    }

    public function maintenanceBanner(Request $request)
    {
        $data = Configuration::where('type', 'maintenance_banner')->first();

        if ($data) {
            $content = unserialize($data->settings);
            $paymentDate = date('Y-m-d H:i:sa');
            $paymentDate=date('Y-m-d H:i:sa', strtotime($paymentDate));
            $start_date = isset($content['start_date']) ? $content['start_date']: '';
            $end_date = isset($content['end_date']) ? $content['end_date']: '';
            $start_time = isset($content['start_time']) ? $content['start_time']: '';
            $end_time = isset($content['end_time']) ? $content['end_time']: '';
            $status = isset($content['status']) ? $content['status'] : '';
            $combinedDTS = date('Y-m-d H:i:sa', strtotime("$start_date $start_time"));
            $combinedDTE = date('Y-m-d H:i:sa', strtotime("$end_date $end_time"));
            if (($paymentDate >= $combinedDTS) && ($paymentDate <= $combinedDTE) && $status == '1') {
                $content_arr = array(
                'status' =>  $status,
                'maintenance_banner_title' =>  isset($content['maintenance_banner_title']) ? $content['maintenance_banner_title'] : '',
                'maintenance_banner_content' =>  isset($content['maintenance_banner_content']) ? $content['maintenance_banner_content'] : '',
                'start_date'=> $start_date,
                'end_date' => $end_date,
                'start_time'=> $start_time,
                'end_time' => $end_time,
                );
                return $this->getResponse(200, 'Maintenance data', $content);
            } else {
                return $this->getResponse(200, 'Maintenance data', (Object)[]);
            }
        }
        return $this->getResponse(422, 'no data found', 0);
    }
}
