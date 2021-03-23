<?php

namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Validator, Response, DB, DataTables,File;
use App\Model\Kickstarter;
use App\Model\Image;
use App\Model\Cities;

use App\Mail\MailNotify;
class KickStarterController extends Controller
{

	public function send()
	{
			// return $request;
			$email ="creativemamta17@gmail.com";
			// return $email;
			$tokenData = DB::table('password_resets')->where('email', $email)->first();
			$token = $tokenData->token;
			$link =  url('password/reset/') . '/' . $token . '?email=' . urlencode($email);
			$data1 = array('name'=>"$email(sender_name)", "link" => $link);
			$data = [
					'subject' => 'test',
					'message' => $email,
					'link' => $link,
				];
			$send = Mail::to($email)->send(new MailNotify($data));
			//Mail::to($email)->send(new MailNotify($data));
			if($send){
				return "send";

			}else{
				return "no";
			}
		}

	/* public function send(){

			$to_name = 'test';
			$to_email = "creativemamta17@gmail.com";
			$tokenData = DB::table('password_resets')
            ->where('email', $to_email)->first();
			$token = $tokenData->token;
			 $link = config('base_url') . 'password/reset/' . $token . '?email=' . urlencode($to_email);
			$data = array('name'=>"$to_email(sender_name)", "body" => "<a href='".$link."'>click to resent</a>");

			$send = Mail::to($to_email)->send($data);
			/*  $send = Mail('emails.mail', $data, function($message) use ($to_name, $to_email) {
				$message->to($to_email, $to_name)
				->subject('Laravel Test Mail');
				$message->from('creativemamta17@gmail.com','Test Mail');
			});
			if($send){
				echo "send";

			}else{
				echo "no";
			}
	} */


	 public function kickstarterAddNew(){

		$states = DB::table('state_county_fib')->select('state_name','state_val as id')->groupBy('state_val')->orderBy('id','asc')->get();
       // $states =  DB::table('us_states')->select('id', 'state_name')->get();
        return view('SuperadminDashboard/kickstarter/addKickstarter')->with('states',$states);
    }

    public function kickstarter(){

		$states = DB::table('state_county_fib')->select('state_name','state_val as id')->groupBy('state_val')->orderBy('id','asc')->get();
       // $states =  DB::table('us_states')->select('id', 'state_name')->get();
        return view('SuperadminDashboard/kickstarter/kickstarterList')->with('states',$states);
    }

    public function kickstarterDetail(Request $request,$id){
        $Kickstarter = Kickstarter::with('profile_image')->where("id",$id)->orderBy('id','desc')->first();
        $phone = $Kickstarter->phone;
        $Kickstarter->phone = preg_replace('/[^0-9]/', '',  $phone);
        //echo "<pre>"; print_r($Kickstarter->filename); die;

        $state =  DB::table('us_states')->where("id",$Kickstarter->state)->first();
        $city= DB::table("us_cities")
           ->where("id",$Kickstarter->city)->first();

        return view('SuperadminDashboard/kickstarter/kickstarterDetail',compact('Kickstarter','city','state'));
    }




    public function kickstarterList($value='')
    {
		$states =  DB::table('us_states')->select('id', 'state_name')->get();

        $Kickstarter = Kickstarter::with('profile_image')->orderBy('id','desc')->get();

        if(request()->ajax()) {
            return DataTables::of($Kickstarter)
                ->addColumn('image', function($row){
                    if(isset($row->profile_image->filename)){
                        return '<img class="user_avatar" width="50px" src="'.$row->profile_image->filename.'">';
                    }
                    return 'Not Avaliable';
                })
				->addColumn('search', function($row){
					$button = '<a  data-kick-id="'. $row->id.'" data-toggle="modal" data-title="Add Search Parameters" data-target="#addSearchModal" href="javascript:void(0)" class="btn btn-primary search_form_button">Add Search</a>'.'<span class="search_json" style="display:none" >'.json_encode($row->search).'</span>';
					return $button;
                })
                ->addColumn('action', function($Kickstarter) {
                    $userImage = '';
                    if(isset($Kickstarter->profile_image->filename)){
                        $userImage = $Kickstarter->profile_image->filename;
                    }
                    $button = '<span style="display:none;" class="address">'.$Kickstarter->address.'</span>
                    <span style="display:none;" class="city">'.$Kickstarter->city.'</span>
                    <span style="display:none;" class="state">'.$Kickstarter->state.'</span>
                    <span style="display:none;" class="country">'.$Kickstarter->country.'</span>
                    <span style="display:none;" class="postal_code">'.$Kickstarter->postal_code.'</span>
                    <span style="display:none;" class="description">'.$Kickstarter->description.'</span>
                    <span style="display:none;" class="image">'.$userImage.'</span>';
                    $button .= '<button data-url='.\URL::route('superadminKickstarterUpdate', $Kickstarter->id).'  data-title="Edit Kickstarter" type="button" class="btn btn-success" id="edit-item" data-kickstart_id="'.$Kickstarter->id.'">Edit</button>';
                    $button .= ' <a href='.\URL::route('kickstarter.detail', $Kickstarter->id).' class="btn btn-primary">View</a>';
                    $button .=' <a  class="btn btn-danger delKick" data-id="'. $Kickstarter->id.'" href='.\URL::route('superadminKickstarterDelete', $Kickstarter->id).' >delete</a>';
                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['search','action', 'image'])
                ->make(true);
        }
        return view('SuperadminDashboard/kickstarter/kickstarterList');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:kickstarter',
            'state' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
        ]);

        if ($validator->passes()) {
			$phone = $request->get('phone');
			$phone = preg_replace('/[^0-9]/', '',  $phone);
            $data=array(
            	'user_id'=> uniqid(),
                'email'=> $request->get('email'),
                'name'=> $request->get('name'),
                'phone'=> $phone,
                'country'=>"us",
                'state'=>$request->get('state'),
                'city'=>$request->get('city'),
                'address'=>$request->get('address')?$request->get('address'):'',
                'postal_code'=>$request->get('postal_code'),
            	'description'=>$request->get('description')
            );

            $kick = Kickstarter::create($data);

            if ($request->hasFile('kickstart_image')) {
			    $cover = $request->file('kickstart_image');
				$extension = $cover->getClientOriginalExtension();
				Storage::disk('public')->put('kickstarter_image/'.$cover->getFilename().'.'.$extension,  File::get($cover));

                $image = array(
                    'filename'=>'kickstarter_image/'.$cover->getFilename().'.'.$extension
                );
                $kick_image = new Image();

                $kick_image->filename = $image['filename'];

                $arr=array(
                    'user_id'   => $kick->id,
                    'type'      => '2',
                );

                Image::updateOrCreate($arr, $image);
                $kick_image->save();
            }
			return response()->json(['success'=>'Added new records.']);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);


        if ($validator->passes()) {
            if ($request->hasFile('kickstart_image')) {

               // $upld_profile_image = $request->file('kickstart_image')->store('kickstarter_image');

               /*  $image = array(
                    'filename'=>$upld_profile_image
                ); */

                $kick_image = new Image();

				$cover = $request->file('kickstart_image');
				$extension = $cover->getClientOriginalExtension();
				Storage::disk('public')->put('kickstarter_image/'.$cover->getFilename().'.'.$extension,  File::get($cover));

                $image = array(
                    'filename'=>'kickstarter_image/'.$cover->getFilename().'.'.$extension
                );

                $kick_image->filename = $image['filename'];

                $arr=array(
                    'user_id'   => $id,
                    'type'      => '2',
                );

                Image::updateOrCreate($arr, $image);
                $kick_image->save();

            }
            $KickstarterData=$request->all();
			if($request->get('phone')){
				$phone = $request->get('phone');
			    $KickstarterData["phone"] = preg_replace('/[^0-9]/', '',  $phone);
			}

            $Kickstarter=  Kickstarter::find($id);
            $updated =  $Kickstarter->update($KickstarterData);
            return response()->json(['success'=>'Records updated.']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }


    public function destroy(Request $request,$id)
    {

        $kickstarter = Kickstarter::destroy($id);
        if ($kickstarter) {

            return response()->json(['success'=>'kickstarter Deleted.']);
         } else {
            return response()->json(['error'=>'kickstarter not Deleted.']);
        }
    }

    public function varifyemail(Request $request)
    {
        if( $request->id ){
            $kickstart = Kickstarter::where('email', $request->email)->where('id','<>', $request->id)->get();
            if(count($kickstart) > 0)
            {
                return "false";
            } else {
                return "true";
            }

        }else{
            $email = Kickstarter::where('email', $request->email)->get();
            if(count($email) > 0)
            {
                return "false";
            } else {
                return "true";
            }
         }
    }

    //For fetching cities
    public function getCities($id)
    {
		if($id != '' || $id != 'undefined'){
			$state_data =DB::table('state_county_fib')->select('state_code')->where('state_val',$id)->first();
			if($state_data){
				$cities = DB::table('tbl_cities')->where("state_id",$state_data->state_code)->pluck('city','id');

				return response()->json($cities);

			}

		}
		$cities = [];

        return response()->json($cities);
    }

	public function getCounties($id)
    {
		//$data=DB::table('state_county_fib')->where('state_val',$id)->orderBy('county_val','asc')->pluck("county_name","county_val");

        $data= DB::table("state_county_fib")
                    ->where("state_val",$id)
                    ->pluck("county_val","county_name");

        return response()->json($data);
    }

	public function CityByCounty($value,$stateid)
    {

		$state_data =DB::table('state_county_fib')->select('state_code','state_val','state_name')->where('state_val', $stateid)->first();
    	$dataArr = explode(",",$value);
		$city_data =DB::table('tbl_cities')->where('state_id',$state_data->state_code)->whereIN('county_name',array_values($dataArr))
		->orderBy('city','asc')->pluck("id as ID","city as CITY");


       /*  $data = Cities::where(function($query) use($dataArr) {


            foreach($dataArr as $values) {
                $query->orWhere('COUNTY', 'like', '%'.$values.'%');
            };
        });
        $datad = $data->orderBy('ID','asc')->pluck("CITY","ID")->toArray(); */

		return response()->json($city_data);
    }

	public function SaveSearch(Request $request)
    {
    	//echo "<pre>"; print_r($request->all()); die;
		$state_id = $request->get('state');
		$statedata = DB::table('state_county_fib')->select('state_name')->where('state_val',$state_id)->first();
		$state_name =  $statedata->state_name;

		$county = $request->get('county');


		$data = [];
		$data['state'] = array('val' => $state_id, 'text' => $state_name);
		$data['countySelect'] = $request->get('countySelect');
		$data['county'] = [];
		$data['city'] = [];
		$data['land'] = [];


		$data['zipcode'] = [];

		//echo "<pre>"; print_r($countydata); die;
		if(!empty($county)){
			//print_r($county); die;
			$countydata = DB::table('state_county_fib')->select('county_name')->whereIn('county_val',array_values($county))->where('state_val',$state_id)->get()->toArray();
			foreach($county as $key =>  $val){
				$data['county'][] = array('val'=>$val,'text' => $countydata[$key]->county_name);

			}
		}
		$data['citySelect'] = $request->get('citySelect');
		$city = $request->get('city');
		if($city ){

			$cities = DB::table('tbl_cities')->whereIn('id',$city)->select("id as val","city as text")->get();
			$data['city'] = json_decode(json_encode($cities), true);
		}



		$data['zipSelect'] = $request->get('zipSelect');
		$data['zipcode'] = $request->get('zipcode');

		$landArr = $request->get('land');
		if(isset($landArr)){
			foreach($landArr as $key => $val){
				$arr = explode(';', $val);
				$data['land'][] = array("val"=>$arr[0],"text"=>$arr[1]);
			}
		}

		$exemptionArr = $request->get('exemption');
		if(isset($exemptionArr)){
			$data['exemption'] = [];
			foreach($exemptionArr as $key => $val){
				$arr = explode(';', $val);
				$data['exemption'][] = array("val"=>$arr[0],"text"=>$arr[1]);
			}
		}
		$occupancyArr = $request->get('occupancy');
		if(isset($occupancyArr)){
			$data['occupancy'] = [];
			foreach($occupancyArr as $key => $val){
				$arr = explode(';', $val);
				$data['occupancy'][] = array("val"=>$arr[0],"text"=>$arr[1]);
			}
		}

		$data['saleSelect'] = $request->get('saleSelect');

		$salesFrom = $request->get('salesFrom');
		if(isset($salesFrom)){
			$data['salesFrom'] = [];
			$salesFrom_timestamp = strtotime($salesFrom);
			$day 	= 	date("j", $salesFrom_timestamp);
			$month 	=	date("n", $salesFrom_timestamp);
			$year 	=	date("Y", $salesFrom_timestamp);
			$data['salesFrom'] =  array("year"=>$year,"month"=>$month,"day"=>$day);
		}//echo json_encode($data['occupancy'],true); die;



		$salesTo 			= 	$request->get('salesTo');
		if(isset($salesTo)){
			$data['salesTo']    = 	[];
			$salesTo_timestamp = strtotime($salesTo);
			$day 	= 	date("j", $salesTo_timestamp);
			$month 	=	date("n", $salesTo_timestamp);
			$year 	=	date("Y", $salesTo_timestamp);
			$data['salesTo'] = array("year"=>$year,"month"=>$month,"day"=>$day);
		}

		$data['mortgageAmountSelect'] = $request->get('mortgageAmountSelect');
		$data['mortgageAmountFrom'] = $request->get('mortgageAmountFrom');
		$data['mortgageAmountTo'] = $request->get('mortgageAmountTo');
		$data['mortgageRecordingDate'] = $request->get('mortgageRecordingDate');

		$mortgageRecordingFrom = $request->get('mortgageRecordingFrom');
		if(isset($mortgageRecordingFrom)){
			$data['mortgageRecordingFrom'] = [];
			$mortgageRecordingFrom_timestamp = strtotime($mortgageRecordingFrom);
			$day 	= 	date("j", $mortgageRecordingFrom_timestamp);
			$month 	=	date("n", $mortgageRecordingFrom_timestamp);
			$year 	=	date("Y", $mortgageRecordingFrom_timestamp);
			$data['mortgageRecordingFrom'] = array("year"=>$year,"month"=>$month,"day"=>$day);
		}

		$mortgageRecordingTo = $request->get('mortgageRecordingTo');
		if(isset($mortgageRecordingTo)){
			$data['mortgageRecordingTo'] = [];
			$mortgageRecordingTo_timestamp = strtotime($mortgageRecordingTo);
			$day 	= 	date("j", $mortgageRecordingTo_timestamp);
			$month 	=	date("n", $mortgageRecordingTo_timestamp);
			$year 	=	date("Y", $mortgageRecordingTo_timestamp);
			$data['mortgageRecordingTo'] = array("year"=>$year,"month"=>$month,"day"=>$day);
		}
		$mortgageTypeArr = $request->get('mortgageType');

		if(isset($mortgageTypeArr)){
			$data['mortgageType'] = [];
			foreach($mortgageTypeArr as $key => $val){
				$arr = explode(';', $val);
				$data['mortgageType'][] = array("val"=>$arr[0],"text"=>$arr[1]);
			}
		}
		$data['mortgageInterestStatus'] = $request->get('mortgageInterestStatus');


		$data['mortgageInterestFrom'] = $request->get('mortgageInterestFrom');
		$data['mortgageInterestTo'] = $request->get('mortgageInterestTo');

		$data['maxOpenLien'] = [];
		$maxOpenLien = $request->get('maxOpenLien');
		if(isset($maxOpenLien)){
			foreach($maxOpenLien as $key => $val){

				$data['maxOpenLien'][] = array("val"=>$val,"text"=>$val);
			}
		}

		$data['equityStatus'] = $request->get('equityStatus');
		$data['equityFrom'] = $request->get('equityFrom');
		$data['equityTo'] = $request->get('equityTo');
		$data['listingStatus'] = [];
		$listingStatus = $request->get('listingStatus');
		if(isset($listingStatus)){
			foreach($listingStatus as $key => $val){
				$arr = explode(';', $val);
				$data['listingStatus'][] = array("val"=>$arr[0],"text"=>$arr[1]);
			}
		}
		$data['listingPriceStatus'] = $request->get('listingPriceStatus');
		$data['listingPriceFrom'] = $request->get('listingPriceFrom');
		$data['listingPriceTo'] = $request->get('listingPriceTo');


		$data['forclosureStatus'] = '';
		$forclosureStatus = $request->get('forclosureStatus');
		if(isset($forclosureStatus)){

			$arr = explode(';', $forclosureStatus);
			$data['forclosureStatus'] = array("val"=>$arr[0],"text"=>$arr[1]);

		}


		$data['forclosureDateStatus'] = $request->get('forclosureDateStatus');


		$forclosureDateFrom = $request->get('forclosureDateFrom');
		if(isset($forclosureDateFrom)){
			$data['forclosureDateFrom'] = [];
			$forclosureDateFrom_timestamp = strtotime($forclosureDateFrom);
			$day 	= 	date("j", $forclosureDateFrom_timestamp);
			$month 	=	date("n", $forclosureDateFrom_timestamp);
			$year 	=	date("Y", $forclosureDateFrom_timestamp);
			$data['forclosureDateFrom'] = array("year"=>$year,"month"=>$month,"day"=>$day);
		}

		$forclosureDateTo = $request->get('forclosureDateTo');
		if(isset($forclosureDateTo)){
			$data['forclosureDateTo'] = [];
			$forclosureDateTo_timestamp = strtotime($forclosureDateTo);
			$day 	= 	date("j", $forclosureDateTo_timestamp);
			$month 	=	date("n", $forclosureDateTo_timestamp);
			$year 	=	date("Y", $forclosureDateTo_timestamp);
			$data['forclosureDateTo'] = array("year"=>$year,"month"=>$month,"day"=>$day);
		}

		$data['forclosureAmountStatus'] = $request->get('forclosureAmountStatus');
		$data['forclosureAmountFrom'] = $request->get('forclosureAmountFrom');
		$data['forclosureAmountTo'] = $request->get('forclosureAmountTo');
		//echo "<pre>"; print_r($data); die;
		$searchDataJson = json_encode($data,true);
		$id = $request->get('kick_id');
		$dataSave=array(
            'search'=>$searchDataJson
        );
		//die;
		// Kickstarter::where(['id' => $id])->update(['search'=>$searchDataJson]);
		 $updated=Kickstarter::updateOrCreate(['id' => $id],$dataSave);
		//echo json_encode($data,true);
		//echo "<pre>"; print_r($data);
		//die;
		return  redirect()->back()->with(['success'=>'Search Added.']);
    }



}
