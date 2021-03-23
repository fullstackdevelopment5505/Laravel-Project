<?php
/**
 * API Controller
 *
 * PHP version 7
 *
 * @category CustomerCardController
 * @package  API
 * @author   Equity <author@domain.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

namespace App\Http\Controllers\Api;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Api\MainController;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator, Response, DB, Config;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\User;
use App\Model\PropertyResultId;
use App\Model\Detail;
use App\Model\PropertyOpportunityStatus;
use App\ManageGrid;
use App\Model\UserProperty;
use App\Model\DataTree;
use App\Model\PropertyReminder;
use App\Notifications\PropertyReminderNotification;
use App\Mail\MailNotify;
use Illuminate\Support\Facades\Mail;

class PropertiesController extends MainController
{
    public function updateReminders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'    => 'required'
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
        $id = $request->get('id');
        $reminder_count = PropertyReminder::where([['user_id', Auth::id()],['id',$id]])->count();
		if($reminder_count==0){
			return $this->getResponse(422,'Invalid request',[],0);
        }
        $date = date('Y-m-d', strtotime($request->get('start_date')));
		$time = date('H:i:s', strtotime($request->get('start_time')));
        $updateQ = PropertyReminder::where([['user_id',Auth::id()],['id',$id]])
        ->update(['title' => $request->get('title'),'start_time'=>$time,'start_date'=>$date]);
        if($updateQ){
            return $this->getResponse(200,'Reminder updated successfully',[],1);
        }
        return $this->getResponse(422,'Invalid request',[],0);
    }
    public function deleteReminders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'    => 'required'
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
        $id = $request->get('id');
        $reminder_count = PropertyReminder::where([['user_id', Auth::id()],['id',$id]])->count();
		if($reminder_count==0){

			return $this->getResponse(422,'Invalid request',[],0);
        }
        $deletedQ = PropertyReminder::where([['id',$id],['user_id', Auth::id()]])->delete();
        if($deletedQ){
            return $this->getResponse(200,'Reminder deleted successfully',[],1);
        }
        return $this->getResponse(422,'Invalid request',[],0);
    }
    public function dismissReminders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'    => 'required'
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
        $id_in_arrays = explode( ',' , $request->input( 'id' ) );
        $reminder_count = PropertyReminder::where('user_id', Auth::id())->whereIN('id',$id_in_arrays)->count();
		if($reminder_count==0){

			return $this->getResponse(422,'Invalid request',[],0);
        }

        $dismissQ = PropertyReminder::where('user_id',Auth::id())
        ->whereIN('id',$id_in_arrays)
        ->update(['status'=> 0]);
        if($dismissQ){
            return $this->getResponse(200,'Reminders dismissed successfully',[],1);
        }
        return $this->getResponse(422,'Invalid request',[],0);
    }
    public function reminderDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'    => 'required'
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
        $id = $request->get('id');
        $reminder_count = PropertyReminder::with('properties')->where([['user_id', Auth::id()],['id',$id]])->count();
		if($reminder_count==0){
			return $this->getResponse(422,'Invalid request',[],0);
        }
        $data = PropertyReminder::with('properties')->select('id','user_property_id',DB::raw('CONCAT(start_date, \' \', start_time) as start'),DB::raw('CONCAT(start_date, \' \', start_time) as end'),
		'title',DB::raw("(CASE WHEN id > 0  THEN  'colors.red' END) as color"),DB::raw("(CASE WHEN id > 0  THEN  '' END) as actions"),
		DB::raw("(CASE WHEN id > 0  THEN  true END) as allDay"),DB::raw("(CASE WHEN id > 0  THEN  false END) as draggable"))
        ->where(['user_id'=>Auth::id(),'id'=>$id])->get();
        return $this->getResponse(200,'Reminder Detail',$data,1);
    }
    public function remindersByPropertyId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id' 	=> 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
        $property_id = $request->get('property_id');
        $reminder_count = PropertyReminder::with('properties')->where([['user_id', Auth::id()],['user_property_id',$property_id]])->count();
		if($reminder_count==0){

			return $this->getResponse(200,'No reminder found',[],0);
        }
		$data = PropertyReminder::with('properties')->select('id','user_property_id',DB::raw('CONCAT(start_date, \' \', start_time) as start'),DB::raw('CONCAT(start_date, \' \', start_time) as end'),
		'title',DB::raw("(CASE WHEN id > 0  THEN  'colors.red' END) as color"),DB::raw("(CASE WHEN id > 0  THEN  '' END) as actions"),
		DB::raw("(CASE WHEN id > 0  THEN  true END) as allDay"),DB::raw("(CASE WHEN id > 0  THEN  false END) as draggable"))
        ->where(['user_id'=>Auth::id(),'user_property_id'=>$property_id,'status'=>1])->get();

		return $this->getResponse(200,'Reminders List',$data,1);
    }
    public function pastActiveReminders()
    {

        $data = PropertyReminder::with('properties')->select('id','user_property_id',DB::raw('CONCAT(start_date, \' \', start_time) as start'),DB::raw('CONCAT(start_date, \' \', start_time) as end'),
		'title',DB::raw("(CASE WHEN id > 0  THEN  'colors.red' END) as color"),DB::raw("(CASE WHEN id > 0  THEN  '' END) as actions"),
		DB::raw("(CASE WHEN id > 0  THEN  true END) as allDay"),DB::raw("(CASE WHEN id > 0  THEN  false END) as draggable"))
        ->where(['user_id'=>Auth::id(),'status'=>1])
        ->whereDate('start_date', '<=',date('Y-m-d'))
        ->Where('start_time', '<=',date('H:i:s'))->get();
		return $this->getResponse(200,'All Reminders',$data,1);
    }

	public function listReminders()
    {
		$data = PropertyReminder::with('properties','datatree')->select('id','user_property_id',DB::raw('CONCAT(start_date, \' \', start_time) as start'),DB::raw('CONCAT(start_date, \' \', start_time) as end'),
		'title',DB::raw("(CASE WHEN id > 0  THEN  'colors.red' END) as color"),DB::raw("(CASE WHEN id > 0  THEN  '' END) as actions"),
		DB::raw("(CASE WHEN id > 0  THEN  true END) as allDay"),DB::raw("(CASE WHEN id > 0  THEN  false END) as draggable"))
		->where(['user_id'=>Auth::id(),'status'=>1])->get();
		return $this->getResponse(200,'All Reminders',$data,1);
	}
	public function saveReminders(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'property_id' 	=> 'required',
            'notes' 	=> 'required',
            'title' 	=> 'required',
            'start_time' 	=> 'required',
            'start_date' 	=> 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$property_id = $request->get('property_id');
		$prop_count = UserProperty::where([['user_id', Auth::id()],['id',$property_id]])->count();
		if($prop_count==0){

			return $this->getResponse(422,'Invalid property id',[],0);
		}
		$date = date('Y-m-d', strtotime($request->get('start_date')));
		$time = date('H:i:s', strtotime($request->get('start_time')));
		$saveQ = PropertyReminder::create(['user_id'=>Auth::id(),'user_property_id'=>$property_id,'notes' =>$request->get('notes'),
		'title' =>$request->get('title'),'start_time' =>$time,'start_date' =>$date]);
		$id = DB::getPdo()->lastInsertId();
		if($id){

			$data = PropertyReminder::find($id);
			return $this->getResponse(200,'Reminder added successfully',$data,1);
		}
	}
	public function PropertiesUpdateMarketData(Request $request)
    {
		$messages = array(
			'email.required_if' => 'Email address is required.',
			'phone.required_if' => 'Phone number is required.',
		);
		$validator = Validator::make($request->all(), [
            'property_id' 	=> 'required',
            'type' 	=> 'required',
            'email' 	=> 'required_if:type,email|email',
            'phone' 	=> 'required_if:type,phone|min:10|max:10',
        ],$messages);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$checkexist = UserProperty::where('id',$request->get('property_id'))->where('user_id',Auth::id())->count();
		if($checkexist==0){
			return $this->getResponse(422,"Invalid property id!",(Object)[],0);
		}
		$column = '';
		if($request->get('type') == 'email'){
			$column = 'email';
			$flagVar = 'email_search_flag';
			$flag = 1;
			$new_val = $request->get('email');
		}
		if($request->get('type') == 'phone'){
			$column = 'phone';
			$flagVar = 'phone_search_flag';
			$flag = 1;
			$new_val = $request->get('phone');
		}
		if($column !=''){
			$updated = UserProperty::where('id',$request->get('property_id'))->where('user_id',Auth::id())
			->update([$column=>$new_val,$flagVar =>$flag]);
			if($updated){
				if($request->get('type') == 'phone'){
					UserProperty::where('id',$request->get('property_id'))->where('user_id',Auth::id())
					->update(array('line_type'=>'CellLine'));
				}
				\Log::info("Property ".$column." updated to ".$new_val." ".date('d-M-Y H:i:s'));
				return $this->getResponse(200,ucfirst($column)." updated successfully!",[],1);
			}
			\Log::info("Error in updating property ".$column." to ".$new_val." ".date('d-M-Y H:i:s'));
			return $this->getResponse(422,"Something went wrong, please try after some time!",(Object)[],0);
		}
		\Log::info("Error in updating property ".$column." to ".$new_val." ".date('d-M-Y H:i:s'));
		return $this->getResponse(422,"Something went wrong, please try after some time!",(Object)[],0);

	}

	public function allGroupUserProperties(Request $request){

		$datatable_parameters 	= 	$request->get('dataTablesParameters');


		$columns 		= 	array_column($datatable_parameters['columns'], 'data');
		 /* $columns = array(
            0 =>'SitusHouseNumber',
            1 =>'LMSSalePrice',
            2 =>'user_property.status',
            3 =>'user_property.status',
            4 =>'date',
        );
		 */
		 $column_name = $columns[$datatable_parameters['order'][0]['column']];
		//$name 					= 	$request->get('name');
		$start 					= 	$datatable_parameters['start'];
		$draw 					= 	$datatable_parameters['draw'];
		$limit 					= 	$datatable_parameters['length'];
		//$named 					=  	urldecode($name);
		$search 				= 	$datatable_parameters['search']['value'];
		$order 					= 	$columns[$datatable_parameters['order'][0]['column']];
		$dir 					= 	$datatable_parameters['order'][0]['dir'];

		$recent_property_result= PropertyResultId::select('property_id',DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'))
		->where('user_id','=',Auth::id())
		->where('property_type','datatree')
		->orderBy('id','desc')->get()->toArray();

		$date = $recent_property_result[0]['date'];

		$recent_property_data_tree_id_arr = array_column($recent_property_result, 'property_id');

		if(empty($search))
		{

			$total_q=UserProperty::select('datatree.*',DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),
			DB::raw('"'.$date.'" as date'),'user_property.status','LMSSalePrice as amount','datatree.PropertyId as property_id','user_property.id as prop_id')
			->join('datatree','datatree.id','=','user_property.property_id')
			->where('user_property.user_id',Auth::id())
			->where('property_type','datatree')
			->whereIn("user_property.property_id",array_values($recent_property_data_tree_id_arr))
			->where('trash','0');

            //DB::raw("replace(replace('$','','LMSSalePrice'),',','')")
			$query = UserProperty::with('logs')->select('user_property.updated_at','user_property.phone_search_flag','email_search_flag','batch_search_email_flag',
			'batch_search_phone_flag','opportunity_status','user_property.email',DB::raw('(CASE WHEN line_type = "CellLine" THEN  user_property.phone ELSE "" END) as phone'),
			'datatree.*','datatree.id as datatree_id','user_property.id','user_property.id as prop_id',
			DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),
			DB::raw('"'.$date.'" as date'),'user_property.status',DB::raw("CAST(LMSSalePrice AS DECIMAL(10,2)) as LMSSalePrice"),'datatree.PropertyId as property_id')
			->join('datatree','datatree.id','=','user_property.property_id')
			->where('user_property.user_id',Auth::id())
			->where('property_type','datatree')
			->whereIn("user_property.property_id",array_values($recent_property_data_tree_id_arr))
			->where('trash','0');

			if($request->get('SitusZipCode') != ''){
				$zip  = str_replace( '-' , '', $request->get('SitusZipCode'));
				$zipn  =	ltrim( $zip, "0");
				$total_q->where('SitusZipCode',$zipn);
				$query->where('SitusZipCode',$zipn);
			}

			if($request->get('Owner1FirstName') != ''){

				$total_q->where('Owner1FirstName',$request->get('Owner1FirstName'));
				$query->where('Owner1FirstName',$request->get('Owner1FirstName'));
			}
			if($request->get('OwnerLastname1') != ''){

				$total_q->where('OwnerLastname1',$request->get('OwnerLastname1'));
				$query->where('OwnerLastname1',$request->get('OwnerLastname1'));
			}
			if($request->get('status') != ''){

				$total_q->where('user_property.status',$request->get('status'));
				$query->where('user_property.status',$request->get('status'));
			}
			if($request->get('phone') != ''){

				$total_q->where('phone',$request->get('phone'));
				$query->where('phone',$request->get('phone'));
			}
			if($request->get('email') != ''){

				$total_q->where('email',$request->get('email'));
				$query->where('email',$request->get('email'));
			}

			if($request->get('SitusCity') != ''){

				$total_q->where('SitusCity',$request->get('SitusCity'));
				$query->where('SitusCity',$request->get('SitusCity'));
			}
			if($request->get('SitusState') != ''){

				$total_q->where('SitusState',$request->get('SitusState'));
				$query->where('SitusState',$request->get('SitusState'));
			}
			$recordsTotal = $total_q->orderBy($order,$dir)->count();

			if($limit < 0){
				$limit = $recordsTotal;

			}
			$query->take($limit)
			->skip($start);

			if($column_name=='address'){
				$query->orderBy('address', $dir);
			}else{ $query->orderBy($order, $dir); }

			$data_u = $query->get();

		}else {

			$total_q=UserProperty::select('user_property.email','datatree.*',DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),DB::raw('"'.$date.'" as date'),'user_property.status','LMSSalePrice as amount','datatree.PropertyId as property_id','user_property.id as prop_id')->join('datatree','datatree.id','=','user_property.property_id')->where([['user_property.user_id',Auth::id()],['trash','0']])->whereIn("user_property.property_id",array_values($recent_property_data_tree_id_arr))->where(function($query) use($search) {
			return $query->where('status', '=', $search)
				->orWhere('Owner1FirstName', 'LIKE', "%{$search}%")
				->orWhere('OwnerLastname1',  'LIKE', "%{$search}%")
				->orWhere('SitusZipCode',  'LIKE', "%{$search}%")
				->orWhere('SitusState',  'LIKE', "%{$search}%")
				->orWhere('phone',  '=', $search)
				->orWhere('email',  '=', $search)
				->orWhere('SitusCity', 'LIKE', "%{$search}");
			})->orderBy($order,$dir)->get()->where('property_type','datatree');

			$queryd = UserProperty::with('logs')->select('user_property.updated_at','user_property.phone_search_flag','email_search_flag','batch_search_email_flag',
			'batch_search_phone_flag','opportunity_status','user_property.email',DB::raw('(CASE WHEN line_type = "CellLine" THEN  user_property.phone ELSE "" END) as phone'),
			'datatree.*','user_property.id','user_property.id as prop_id','datatree.id as datatree_id',
			DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),
			DB::raw('"'.$date.'" as date'),'user_property.status',DB::raw("CAST(LMSSalePrice AS DECIMAL(10,2)) as amount"),DB::raw("CAST(LMSSalePrice AS DECIMAL(10,2)) as LMSSalePrice"),'datatree.PropertyId as property_id',)
			->join('datatree','datatree.id','=','user_property.property_id')
			->where([['user_property.user_id',Auth::id()],['trash','0']])
			->where('property_type','datatree')
			->whereIn("user_property.property_id",array_values($recent_property_data_tree_id_arr))
			->where(function($query) use($search) {
			return $query->where('status', '=', $search)
				->orWhere('Owner1FirstName', 'LIKE', "%{$search}%")
				->orWhere('OwnerLastname1',  'LIKE', "%{$search}%")
				->orWhere('SitusZipCode',  'LIKE', "%{$search}%")
				->orWhere('SitusState',  'LIKE', "%{$search}%")
				->orWhere('phone',  '=', $search)
				->orWhere('email',  '=', $search)
				->orWhere('SitusCity', 'LIKE', "%{$search}");
			});
			if($request->get('SitusZipCode') != ''){
				$zip  = str_replace( '-' , '', $request->get('SitusZipCode'));
				$zipn  =	ltrim( $zip, "0");
				$total_q->where('SitusZipCode',$zipn);
				$queryd->where('SitusZipCode',$zipn);
			}
			if($request->get('Owner1FirstName') != ''){

				$total_q->where('Owner1FirstName',$request->get('Owner1FirstName'));
				$queryd->where('Owner1FirstName',$request->get('Owner1FirstName'));
			}
			if($request->get('OwnerLastname1') != ''){

				$total_q->where('OwnerLastname1',$request->get('OwnerLastname1'));
				$queryd->where('OwnerLastname1',$request->get('OwnerLastname1'));
			}
			if($request->get('status') != ''){

				$total_q->where('user_property.status',$request->get('status'));
				$queryd->where('user_property.status',$request->get('status'));
			}
			if($request->get('phone') != ''){

				$total_q->where('phone',$request->get('phone'));
				$queryd->where('phone',$request->get('phone'));
			}
			if($request->get('email') != ''){

				$total_q->where('email',$request->get('email'));
				$queryd->where('email',$request->get('email'));
			}

			if($request->get('SitusCity') != ''){

				$total_q->where('SitusCity',$request->get('SitusCity'));
				$queryd->where('SitusCity',$request->get('SitusCity'));
			}
			if($request->get('SitusState') != ''){

				$total_q->where('SitusState',$request->get('SitusState'));
				$queryd->where('SitusState',$request->get('SitusState'));
			}
			$recordsTotal = $total_q->orderBy($order,$dir)->count();
			if($limit < 0){
				$limit = $recordsTotal;

			}

			$queryd->take($limit)->skip($start);

			if($column_name=='address'){
				$queryd->orderBy('address', $dir);
			}else{ $queryd->orderBy($order, $dir); }

			$data_u = $queryd->get();

		}
		$data = array(
            'draw' => intval($draw),
            'recordsTotal' => intval($recordsTotal),
            'recordsFiltered' => intval($recordsTotal),
            'data' => $data_u->toArray()
           // 'purchase_group_name' => $named,
        );

        return $this->getResponse(200,'All group records',json_encode($data),1);
	}
	public function pendingGroupProperties(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'purchase_group_name' 	=> 'required',
            'type' 	=> 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		if($request->get('type') !='email' && $request->get('type') !='phone'){
			 return $this->getResponse(422,'Invalid request!',[],0);
		}

		$name = $request->get('purchase_group_name');
		$properties= PropertyResultId::select('property_id',DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'))->where('purchase_group_name','LIKE',$name)->where('user_id','=',Auth::id())->orderBy('id','desc')->get()->toArray();

		$date = $properties[0]['date'];

		$recent_property_data_tree_id_arr = array_column($properties, 'property_id');


		if($request->get('type') =='email' ){

			$records=UserProperty::where('user_id',Auth::id())->where('batch_Search_email_flag','0')->whereIn("property_id",array_values($recent_property_data_tree_id_arr))->orderBy('id','desc')->pluck('id');
		}

		if($request->get('type') =='phone' ){
			$records=UserProperty::where('user_id',Auth::id())->where('batch_Search_phone_flag','0')->whereIn("property_id",array_values($recent_property_data_tree_id_arr))->orderBy('id','desc')->pluck('id');
		}

		return $this->getResponse(200,'Pending '.$request->get('type').' properties',$records,1);
	}
	public function pullTrash(Request $request){
        $validator = Validator::make($request->all(), [
            'id'        => [
                'required',
                Rule::exists('user_property')->where(function ($query) {
                    $query->where([['user_id', Auth::id()],['trash','1']]);
                })
                ]
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$propdata =  UserProperty::where([['user_id', Auth::id()],['id',$request->get('id')]])->first();
		$property_id = $propdata->property_id;

        UserProperty::where('id',$request->get('id'))->update(['trash'=>'0']);
		PropertyResultId::where([['property_id',$property_id],['user_id', Auth::id()]])->update(['trash'=>'0']);
        return $this->getResponse(200,'unTrashed');

    }

	public function getTrash(Request $request)
    {
        $data=UserProperty::select(DB::raw('CONCAT(datatree.SitusHouseNumber, \' \', datatree.SitusStreetName, \' \', datatree.SitusMode) as address'),DB::raw('DATE_FORMAT(user_property.updated_at, "%d-%b-%Y %H:%i:%s") as date'),'user_property.created_at','user_property.status', 'LMSSalePrice as amount','datatree.PropertyId as property_id','user_property.id as prop_id')->join('datatree','datatree.id','=','user_property.property_id')->where('user_property.user_id',Auth::id())->where('trash','1')->orderBy('user_property.id','desc')->get();

        return $this->getResponse(200,'Trash',$data,1);

    }
	public function deletePermanent(Request $request){
        $validator = Validator::make($request->all(), [
            'id'        => [
                'required',
                Rule::exists('user_property')->where(function ($query) {
                    $query->where([['user_id', Auth::id()],['trash','1']]);
                })
                ]
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$propdata =  UserProperty::where([['user_id', Auth::id()],['id',$request->get('id')],['trash','1']])->first();
		$property_id = $propdata->property_id;

		UserProperty::where([['user_id', Auth::id()],['id',$request->get('id')],['trash','1']])->delete();
		PropertyResultId::where([['property_id',$property_id],['user_id', Auth::id()],['trash','1']])->delete();
		Report::where([['user_prop_id',$propdata->id],['user_id', Auth::id()]])->delete();
        return $this->getResponse(200,'Deleted');

    }
	public function pushTrash(Request $request){
        $validator = Validator::make($request->all(), [
            'id'        => [
                'required',
                Rule::exists('user_property')->where(function ($query) {
                    $query->where([['user_id', Auth::id()],['trash','0']]);
                })
                ]
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$propdata =  UserProperty::where([['user_id', Auth::id()],['id',$request->get('id')]])->first();
		$property_id = $propdata->property_id;

        UserProperty::where('id',$request->get('id'))->update(['trash'=>'1']);
        PropertyResultId::where([['property_id',$property_id],['user_id', Auth::id()]])->update(['trash'=>'1']);
         return $this->getResponse(200,'Trashed');

    }
	public function getAllLeadsByGroupname($name)
    {
		$named =  urldecode($name);


		$recent_property_result= PropertyResultId::select('property_id',DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'))->where('purchase_group_name','LIKE',$named)->where('user_id','=',Auth::id())->orderBy('id','desc')->get()->toArray();


			$date = $recent_property_result[0]['date'];

			$recent_property_data_tree_id_arr 		= 	array_column($recent_property_result, 'property_id');


			$data = UserProperty::with('logs')->select('opportunity_status','datatree.*',DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),DB::raw('"'.$date.'" as date'),'user_property.status','LMSSalePrice as amount','datatree.PropertyId as property_id','user_property.id as prop_id')->join('datatree','datatree.id','=','user_property.property_id')->where('user_property.user_id',Auth::id())->whereIn("user_property.property_id",array_values($recent_property_data_tree_id_arr))->where('trash','0')->orderBy('user_property.id','desc')->get();



			return $this->getResponse(200,'All Purchase group records',$data,1);
        //return $this->getResponse(200,'Purchase group records',(Object)array('count'=>count($recent_property_result),'data'=>$data));

    }
	public function getLeadsByGroupname(Request $request)
    {
		$datatable_parameters 	= 	$request->get('dataTablesParameters');

		//$columns 		= 	array_column($datatable_parameters['columns'], 'data');
		$columns = array(
            0 =>'SitusHouseNumber',
            1 =>'LMSSalePrice',
            2 =>'user_property.status',
            3 =>'user_property.status',
            4 =>'date',
        );

		$name 		= 	$request->get('name');
		$start 		= 	$datatable_parameters['start'];
		$draw 		= 	$datatable_parameters['draw'];
		$limit 		= 	$datatable_parameters['length'];
		$named 		=  	urldecode($name);
		$search 	= 	$datatable_parameters['search']['value'];
		$order 		= 	$columns[$datatable_parameters['order'][0]['column']];
		$dir 		= 	$datatable_parameters['order'][0]['dir'];

		$recent_property_result= PropertyResultId::select('property_id',DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'))->where('purchase_group_name','LIKE',$named)->where('user_id','=',Auth::id())->orderBy('id','desc')->get()->toArray();

		$date = $recent_property_result[0]['date'];

		$recent_property_data_tree_id_arr = array_column($recent_property_result, 'property_id');

		if(empty($search))
		{

			$recordsTotal=UserProperty::select('datatree.*',DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),DB::raw('"'.$date.'" as date'),'user_property.status','LMSSalePrice as amount','datatree.PropertyId as property_id','user_property.id as prop_id')->join('datatree','datatree.id','=','user_property.property_id')->where('user_property.user_id',Auth::id())->whereIn("user_property.property_id",array_values($recent_property_data_tree_id_arr))->where('trash','0')->orderBy($order,$dir)->count();

			if($limit < 0){
				$limit = $recordsTotal;

			}

			$data_u=UserProperty::with('logs')->select('user_property.phone_search_flag','email_search_flag','batch_search_email_flag','batch_search_phone_flag','opportunity_status',
			'user_property.email',DB::raw('(CASE WHEN line_type = "CellLine" THEN  user_property.phone ELSE "" END) as phone'),'datatree.*','datatree.id as datatree_id',
			'user_property.id','user_property.id as prop_id',DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),DB::raw('"'.$date.'" as date'),'user_property.status','LMSSalePrice as amount','datatree.PropertyId as property_id')->join('datatree','datatree.id','=','user_property.property_id')->where('user_property.user_id',Auth::id())->whereIn("user_property.property_id",array_values($recent_property_data_tree_id_arr))->where('trash','0')->take($limit)->skip($start)->orderBy($order,$dir)->get();

		}else {
			$recordsTotal_u=UserProperty::select('user_property.email','datatree.*',DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),DB::raw('"'.$date.'" as date'),'user_property.status','LMSSalePrice as amount','datatree.PropertyId as property_id','user_property.id as prop_id')->join('datatree','datatree.id','=','user_property.property_id')->where([['user_property.user_id',Auth::id()],['trash','0']])->whereIn("user_property.property_id",array_values($recent_property_data_tree_id_arr))->where(function($query) use($search) {
			return $query->where('SitusHouseNumber', '=', $search)
				->orWhere('SitusStreetName', 'LIKE', "%{$search}%")
				->orWhere('SitusMode',  'LIKE', "%{$search}%")
				->orWhere('LMSSalePrice', 'LIKE', "%{$search}");
			})->orderBy($order,$dir)->get();

			if($limit < 0){
				$limit = $recordsTotal_u->count();

			}

			$data_u=UserProperty::with('logs')->select('user_property.phone_search_flag','email_search_flag','batch_search_email_flag','batch_search_phone_flag','opportunity_status','user_property.email',DB::raw('(CASE WHEN line_type = "CellLine" THEN  user_property.phone ELSE "" END) as phone'),'datatree.*','user_property.id','user_property.id as prop_id','datatree.id as datatree_id',DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),DB::raw('"'.$date.'" as date'),'user_property.status','LMSSalePrice as amount','datatree.PropertyId as property_id',)->join('datatree','datatree.id','=','user_property.property_id')->where([['user_property.user_id',Auth::id()],['trash','0']])->whereIn("user_property.property_id",array_values($recent_property_data_tree_id_arr))->where(function($query) use($search) {
			return $query->where('SitusHouseNumber', '=', $search)
				->orWhere('SitusStreetName', 'LIKE', "%{$search}%")
				->orWhere('SitusMode',  'LIKE', "%{$search}%")
				->orWhere('LMSSalePrice', 'LIKE', "%{$search}");
			})->take($limit)->skip($start)->orderBy($order,$dir)->get();
			$recordsTotal=$recordsTotal_u->count();

		}

		$data = array(
            'draw' => intval($draw),
            'recordsTotal' => intval($recordsTotal),
            'recordsFiltered' => intval($recordsTotal),
            'data' => $data_u->toArray(),
            'purchase_group_name' => $named,
        );

        return $this->getResponse(200,'Purchase group records',json_encode($data),1);
        //return $this->getResponse(200,'Purchase group records',(Object)array('count'=>count($recent_property_result),'data'=>$data));

    }
	public function getLeads(Request $request)
    {
        $data=UserProperty::select(DB::raw('CONCAT(SitusHouseNumber, \' \',SitusStreetName, \' \',SitusMode) as address'),'user_property.created_at','user_property.status','LMSSalePrice as amount','datatree.PropertyId as property_id','user_property.id as prop_id')->join('datatree','datatree.id','=','user_property.property_id')->where('user_property.user_id',Auth::id())->where('trash','0')->orderBy('user_property.id','desc')->get();

        return $this->getResponse(200,'Search',$data,1);

    }
	public function renameSavedSearchTitle(Request $request)
    {

		$validator = Validator::make($request->all(), [
            'user_id'        	=> 	'required',
            'old_search_title'  	=> 	'required',
            'new_search_title'  	=> 	'required'
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$user_id 			= 	$request->get('user_id');
		$old_search_title 	=  	$request->get('old_search_title');
		$new_search_title 	= 	$request->get('new_search_title');

		$updated = Saved::where([['user_id',$user_id],['title',$old_search_title]])->update(array(
		'title' =>  $new_search_title,
		));
		if($updated){

			return $this->getResponse(200,'rename title successfully');
		}

		return $this->getResponse(422,'search title does not exist.',0);

	}
	public function renamePurchaseGroup(Request $request)
    {

		$validator = Validator::make($request->all(), [
            'user_id'           => 	'required',
            'old_group_name'  	=> 	'required',
            'new_group_name'  	=> 	'required'
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$user_id 		= 	$request->get('user_id');
		$old_group_name =  	$request->get('old_group_name');
		$new_group_name = 	$request->get('new_group_name');

		$groupname  = preg_replace('/[+%_-]/s','',$new_group_name);

		$result = PropertyResultId::where('user_id',Auth::id())->groupBy('result_id')->pluck('purchase_group_name');

		$arr =  (array)$result;
		$groupname_exists  =  array_values($arr);
		if(in_array($groupname,$groupname_exists[0])){

			return $this->getResponse(422,'Group name already exists',(Object)[],0);
		}

		$updated = PropertyResultId::where([['user_id',$user_id],['purchase_group_name',$old_group_name]])->update(array(
			'purchase_group_name' 	  =>  $new_group_name,
		));


		if($updated){

			return $this->getResponse(200,'rename group successfully');
		}

		return $this->getResponse(422,'error',0);

	}
	public function getPurchaseGroup(Request $request)
    {
		/* if( Auth::id() == 262 ){ */
			//SQL: select `id`, `user_idf`, `property_id`, DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date, `purchase_group_name`, count(result_id) as total from `property_result_id` where `user_id` = 23 and `purchase_group_name` is not null group by `result_id` order by `id` desc
			/* $data = PropertyResultId::select('property_result_id.ids','property_result_id.user_id','property_result_id.property_id','user_property.trash',DB::raw('DATE_FORMAT(property_result_id.created_at, "%d-%b-%Y %H:%i:%s") as date'),'property_result_id.purchase_group_name',DB::raw('count(property_result_id.result_id) as total'))->join('user_property','property_result_id.property_id','=','user_property.property_id')->where('property_result_id.user_id','=','user_property.user_id')->where('user_property.trash','0')->where('property_result_id.user_id', Auth::id())->whereNotNull('property_result_id.purchase_group_name')->groupBy('property_result_id.result_id')->orderBy('property_result_id.id','desc')->get();	 */

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
		,'purchase_group_name',DB::raw('count(result_id) as total'),'result_id')->where('user_id', Auth::id())->where('trash', '0')
		->whereNotNull('purchase_group_name')
		->groupBy('result_id')
		->orderBy('id','desc')->get();

		$wordCount = $data->count();

		$dataArr = PropertyResultId::select('id','user_id','property_id',
		DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'),'batch_process_email_status','batch_process_phone_status',
		'purchase_group_name','result_id')->where('user_id', Auth::id())->where('trash', '0')
		->whereNotNull('purchase_group_name')
		->orderBy('id','desc')->get()->toArray();
		//print_r($data->toArray() );
		$flagArr =[];
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

		//echo "<pre>"; print_r($dataArr); die;
		/* foreach($data as $val){

			$val['purchase_group_url'] = str_replace('%2F','%252F', urlencode($val->purchase_group_name));
			$vouchers = (object)$val;


		} */
	//$data->push($vouchers);

		return $this->getResponse(200,'Purchase Group ',(Object)array('total-records' => $wordCount,'data' => $flagArr));
	}

	public function SaveOpportunityStatus(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'Property_id' 	=> 'required',
            'opportunity_status_value' 	=> 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$property_id_in_arrays = $request->input( 'Property_id' );

		$updated = UserProperty::where('user_id',Auth::id())->whereIn('id',array_values($property_id_in_arrays))->update(array('opportunity_status' => $request->get('opportunity_status_value')));
		if($updated){

			$records= UserProperty::select('*')->whereIn('id',array_values($property_id_in_arrays))->get();

			return $this->getResponse(200,'Opportunity status added successfully',$records,1);
		}

        return $this->getResponse(422,'something went wrong!',[],0);
	}

	public function propertiesGridList($type)
    {
		if(!isset($type) || $type == '' || $type == 0){
			return $this->getResponse(422,'Grid type is null',[],0);
		}

        $data=ManageGrid::where([['user_id',Auth::id()],['type',$type]])->get();

        return $this->getResponse(200,'Properties Grid List',$data,1);
    }

	public function saveGridLog(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'gridSelect' 	=> 'required',
            'gridsStatus' 	=> 'required',
            'gridCol'   	=> 'required',
            'gridColName'  	=> 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		if($request->get('type') == '' || $request->get('type') == 0){
			return $this->getResponse(422,'Grid type is null',[],0);

		}

		/* type=> 1:warm prospects, 2: hot prospects, 3: purchased view records, 4: saved_search: 5: kickstarter, 6: Trash */

		$arr=array(
			'user_id'=>Auth::id(),
			'type'=>$request->get('type'),
		);

		$grid_data=array(
			'type'=>$request->get('type'),
			'grid_total_number'=>$request->get('gridSelect'),
			'column_status'=>json_encode($request->get('gridsStatus')),
			'selected_column'=>json_encode($request->get('gridCol')),
			'column_name'=>json_encode($request->get('gridColName')),
		);
		$savedgrid = ManageGrid::updateOrCreate($arr,$grid_data);

		if($savedgrid){
			$data=ManageGrid::where([['user_id',Auth::id()],['type',$request->get('type')]])->first();
			return $this->getResponse(200,'Grid Saved Successfully!',$data,1);
		}
        return $this->getResponse(422,'something went wrong!',0);

	}

	public function warmProspectsSaveGrid(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'gridSelect' 	=> 'required',
            'gridsStatus' 	=> 'required',
            'gridCol'   	=> 'required',
            'gridColName'  	=> 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$arr=array(
			'user_id'=>Auth::id(),
			'type'=>'1',
		);

		$grid_data=array(
			'type'=>'1',
			'grid_total_number'=>$request->get('gridSelect'),
			'column_status'=>json_encode($request->get('gridsStatus')),
			'selected_column'=>json_encode($request->get('gridCol')),
			'column_name'=>json_encode($request->get('gridColName')),
		);
		$savedgrid = ManageGrid::updateOrCreate($arr,$grid_data);

		if($savedgrid){
			$data=ManageGrid::where([['user_id',Auth::id()],['type','1']])->first();
			return $this->getResponse(200,'Warm prospects grid Saved Successfully!',$data,1);
		}
        return $this->getResponse(422,'something went wrong!',0);

	}

	public function hotProspectsSaveGrid(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'gridSelect' 	=> 'required',
            'gridsStatus' 	=> 'required',
            'gridCol'   	=> 'required',
            'gridColName'  	=> 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$arr=array(
			'user_id'=>Auth::id(),
			'type'=>'2',
		);

		$grid_data=array(
			'type'=>'2',
			'grid_total_number'=>$request->get('gridSelect'),
			'column_status'=>json_encode($request->get('gridsStatus')),
			'selected_column'=>json_encode($request->get('gridCol')),
			'column_name'=>json_encode($request->get('gridColName')),
		);
		$savedgrid = ManageGrid::updateOrCreate($arr,$grid_data);

		if($savedgrid){
			$data=ManageGrid::where([['user_id',Auth::id()],['type','2']])->first();
			return $this->getResponse(200,'Warm prospects grid Saved Successfully!',$data,1);
		}
        return $this->getResponse(422,'something went wrong!',0);

	}
}
