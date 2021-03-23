<?php
/**
 * API Controller
 *
 * PHP version 7
 *
 * @category AffiliateController
 * @package  API
 * @author   Equity <author@domain.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Api\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator, Response, DB, Config;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Mail\MailNotify;
use App\User;
use App\AffiliateUsers;
use App\Notifications\AffiliateWelcome;
use App\AffiliateCommission;
use App\Notifications\ResetPassword;
use App\Notifications\ForgotPassword;
use App\Model\PropertyResultId;
use App\AffiliateWallet;
use App\Model\Detail;

class AffiliateController extends MainController
{


	public function UpdateProfile(Request $request){

		$validator = Validator::make($request->all(),[
			'name'       	=> 'required',
			'postal'		=> 'required',
			'state'      	=> 'required',
			'city'      	=> 'required',
			'phone'      	=> 'required',
			'taxid'      	=> 'required',
			'paypal_email'  => 'required'
        ]);

        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$data=array(
            'full_name'  	=> $request->get('name'),
            'zipcode'  	    => $request->get('postal'),
	        'state'  	    => $request->get('state'),
	        'city'  	    => $request->get('city'),
			'phone'     	=> $request->get('phone'),
			'taxid'     	=> $request->get('taxid'),
			'paypal_email'  => $request->get('paypal_email'),
			'address'     	=> $request->get('address') ? $request->get('address') : '',
			'info'     		=> $request->get('info') ? $request->get('info') : '',
        );

		$updated=AffiliateUsers::updateOrCreate(['id' => Auth::user()->id],$data);

		if($updated){
			return $this->getResponse(200,'Updated Successfully');
		}else{
			return $this->getResponse(422,'Server issue');
		}
    }

	public function profile(){
        $data=AffiliateUsers::find(Auth::user()->id);
		$data->username = Config::get('app.website_url').'shareaffiliate#'.$data->username;
        return $this->getResponse(200,'affiliate profile',$data);
    }

	public function login(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email'         => 'required|exists:affiliate_users,email',
            'password'      => 'required|between:6,20'
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$userCheckAccoutnActivted = AffiliateUsers::where("email", "=", request('email'))->where("status","1")->first();

		if(!isset($userCheckAccoutnActivted)){
			return $this->getResponse(422,"Account is not activated",(Object)[],0);

		}
		$user = AffiliateUsers::where("email", "=", request('email'))->whereNull('affiliate_token')->where("status","1")->first();

		if(!isset($user)){
			return $this->getResponse(422,"Please check your email and complete signup process first",(Object)[],0);

		}
        if(Auth::guard('affiliate')->attempt(['email' => $request->email, 'password' => $request->password,'status' => '1']))
        {
			//please check your email and complete signup process first
			$user=Auth::guard('affiliate')->user();
			//	echo "<pre>"; print_r($user); die;
			$data['token'] =  $user->createToken('affiliates')->accessToken;

			$user->token=$data['token'];
			AffiliateUsers::where("id", "=", $user->id)->update(["api_token" => $data['token'], "last_login" => date('Y-m-d H:i:s')]);
			unset($user->id);
			unset($user->email_verified_at);
			unset($user->status);
			return $this->getResponse(200,"You are loggedin successfully",$user,1);
        }
        else{
            return $this->getResponse(422,"Please enter valid credentials",(Object)[],0);
        }
    }

	public function affiliate_register(Request $request)
    {
		$validator = Validator::make($request->all(),[
			'f_name'       	=> 'required',
			'postal'		=> 'required',
			'state'      	=> 'required',
			'city'      	=> 'required',
			'phone'      	=> 'required',
			'password'      => 'required',
            'email'      	=> 'required|unique:affiliate_users,email',
        ]);

        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$password = $request->get('password');//Str::random(10);
		$newUsername = $this->getUsername($request->get('f_name'));
		//$digits = 3;
		//$service_code = rand(pow(10, $digits-1), pow(10, $digits)-1);
		$service_code = 121;
		$lastinserted = AffiliateUsers::orderBy('id','desc')->pluck('service_code')->first();
		if($lastinserted){

			$service_code = $lastinserted+1;
		}

        $data=array(
            'email'     	=> $request->get('email'),
            'password'  	=> Hash::make($password),
            'username'  	=> $newUsername,
			'service_code'  => $service_code,
            'service_code_prefix'  => '',
            'full_name'  	=> $request->get('f_name'),
            'zipcode'  	    => $request->get('postal'),
	        'state'  	    => $request->get('state'),
	        'city'  	    => $request->get('city'),
			'phone'     	=> $request->get('phone'),
			'address'     	=> $request->get('address') ? $request->get('address') : '',
            'status'  		=> 0,
        );

        $user=AffiliateUsers::create($data);

		$token['token']=$user->createToken('affiliate')->accessToken;
        AffiliateUsers::where('id',$user->id)->update(['api_token'=>$token['token']]);

		$commission_data=array(
            'affiliate_id'  => $user->id,
            'commission'  	=> 10
        );

		AffiliateCommission::create($commission_data);

        unset($user->id);
        $user->token=$token['token'];
		if($user){
			$this->signupWelcomeEmailAffiliate($user->email,$password);
		}
		return $this->getResponse(200, 'Registration Successful. Please check your email for further steps.',$user, 1);
    }

	public function customerDetail($id)
    {

		$affiliateId =  Auth::user()->id;

		$total_commission_earned = 0;

		$user_detail =  User::with('details','member','subscription','Image')->where('id', $id)->first();
		$member = 0;
		if($user_detail->subscription == null){
			$member = 0;
		}else if($user_detail->subscription['status']=="canceled"){
			$member = 0;
		}else{
			$member = 1;
		}


		$user_detail->reg_status= $member;
		$previous_order = AffiliateWallet::select('tbl_deposite.amount','tbl_affiliate_wallet.user_id','status',DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as order_date'),'order_id','tbl_affiliate_wallet.amount as commission')->join('tbl_deposite','tbl_affiliate_wallet.deposit_id','=','tbl_deposite.id')->where([['affiliate_id',$affiliateId],['tbl_affiliate_wallet.user_id',$id],['status','paid']])->orderBy('order_date','desc')->get();

		$commsison_rows = AffiliateWallet::select(DB::raw('sum(amount) as total_commission'))->where([['affiliate_id',$affiliateId],['tbl_affiliate_wallet.user_id',$id],['status','paid']])->orderBy('order_date','desc')->get();


		if(!empty($commsison_rows)){
			$total_commission_earned = $commsison_rows[0]['total_commission'];
		}

		return $this->getResponse(200,"customer detail",(Object)array('user_detail'=>$user_detail,'previous_order'=>$previous_order,'total_commission_earned'=>$total_commission_earned),1);
	}


	public function prospectCustomerList()
    {

		$userId =  Auth::user()->id;

		$customers = DB::table('users')->where('role','0')->where('users.mapped_to_affiliate',$userId)
        ->join('tbl_membership','tbl_membership.user_id','=','users.id')
        ->join('user_detail','user_detail.user_id','=','users.id')
        ->select(DB::raw('DATE_FORMAT(users.created_at, "%d-%b-%Y %H:%i:%s") as date'),'users.id','user_detail.f_name as name','users.email',DB::raw('sum(users.id) as total_commission'),)
        ->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00')
        ->groupBy('tbl_membership.user_id')->get();

		//$customerArr  = json_decode(json_encode($customers), true);
		//$cus_ids =	array_column($customerArr, 'id');

		/* $customers_commission_data = AffiliateWallet::select(DB::raw('DATE_FORMAT(users.created_at, "%d-%b-%Y %H:%i:%s") as date'),'users.id','user_detail.f_name as name','users.email',DB::raw('sum(amount) as total_commission'),)
		->leftJoin('users', 'tbl_affiliate_wallet.user_id', '=', 'users.id')
		->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id')->whereIn('tbl_affiliate_wallet.user_id',array_values($cus_ids))->where('affiliate_id',$userId)->groupBy('tbl_affiliate_wallet.user_id')->orderBy('tbl_affiliate_wallet.id','desc')->get()->toArray(); */

		$customers_commission_data = [];

		foreach($customers as $key => $value){

			$aff_data = AffiliateWallet::select(DB::raw('sum(amount) as total_commission'))->
			where('tbl_affiliate_wallet.user_id',$value->id)->where('affiliate_id',$userId)->groupBy('tbl_affiliate_wallet.user_id')->orderBy('tbl_affiliate_wallet.id','desc')->get()->toArray();
			if(isset($aff_data[0]['total_commission'])){

				$value->total_commission = $aff_data[0]['total_commission'];
			}else{
				$value->total_commission = 0;
			}

		}

		$prospects=DB::table('users')->where('users.mapped_to_affiliate',$userId)->where('role', '0')->orderBy('users.id','desc')
            ->LeftJoin('tbl_membership', function($query){
                $query->on( 'users.id', '=', 'tbl_membership.user_id');
                $query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');
            })
            ->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id')
            ->select('users.id','users.email','user_detail.f_name as name','user_detail.phone',DB::raw('DATE_FORMAT(users.created_at, "%d-%b-%Y %H:%i:%s") as date'))
           ->whereNull('tbl_membership.expire_at')->get();

        return $this->getResponse(200,'Dashboard',(Object)array('prospects'=>$prospects,'customers'=>$customers));

    }


	public function dashboard()
    {
		$userId =  Auth::user()->id;

		$customerEntrolled 	= $this->totalMember($userId);

		$prospectsJoined 	= $this->totalNonMember($userId);

		$total_commission_earned = $this->calculateCommission($userId);

        $customers_data = $this->customersList($userId);

		$graph = $this->graph($userId);

		$prospects_data = $this->prospectsList($userId);

		$month = ["january","february","march","april","may","june","july","august","september","october","november","december"];

        return $this->getResponse(200,'Dashboard',(Object)array('total_prospects'=>$prospectsJoined,'total_customers'=>$customerEntrolled, 'total_commission_earned' => $total_commission_earned,'customers'=>$customers_data,'prospects'=>$prospects_data,'month'=>$month,'graph'=>$graph));

    }

	public static function graph($userId){

		$graph = [];

		for($i=1; $i<=12; $i++){

			$payment_data = AffiliateWallet::select(DB::raw(DB::raw('sum(amount) as total_amount')))->where('affiliate_id',$userId)->whereMonth('created_at',$i)
			->whereYear('created_at', date('Y'))->get()->toArray();

			if(count($payment_data)>0){
				$new = array_sum(array_column($payment_data, 'total_amount'));
				$graph[] = $new;


			}else{
			  $graph[] = 0;
			}
		}
		return $graph;

	}


	public function commissionReport()
    {
		$affiliateId =  Auth::user()->id;


		$report_data = AffiliateWallet::select('tbl_affiliate_wallet.user_id','f_name as name','tbl_affiliate_wallet.status',DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as order_date'),'order_id',DB::raw('sum(amount) as total_commission'))->join('users','tbl_affiliate_wallet.user_id','=','users.id')->join('user_detail','user_detail.user_id','=','users.id')->where('affiliate_id',$affiliateId)->where('tbl_affiliate_wallet.status','paid')->groupBy('order_id')->orderByRaw('sum(amount) DESC')->groupBy('tbl_affiliate_wallet.user_id')->get();

		return $this->getResponse(200,"commission report",(Object)array('total'=>$report_data->count(),'data'=>$report_data),1);
	}

	public function customerReport()
    {
		$affiliateId =  Auth::user()->id;


		$report_data = AffiliateWallet::select('tbl_affiliate_wallet.user_id','f_name as name','email','tbl_affiliate_wallet.status',DB::raw('DATE_FORMAT(tbl_affiliate_wallet.created_at, "%d-%b-%Y %H:%i:%s") as date'),DB::raw('sum(amount) as total_commission'))->join('users','tbl_affiliate_wallet.user_id','=','users.id')->join('user_detail','user_detail.user_id','=','users.id')->where('affiliate_id',$affiliateId)->orderBy('tbl_affiliate_wallet.created_at','desc')->groupBy('tbl_affiliate_wallet.user_id')->get();


		return $this->getResponse(200,"customer report",(Object)array('total'=>$report_data->count(),'data'=>$report_data),1);
	}

	public function paymentReport()
    {

		$affiliateId =  Auth::user()->id;

		$payment_report_data = AffiliateWallet::select('id','status',DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as order_date'),'order_id',DB::raw('sum(amount) as total_amount'))->where('affiliate_id',$affiliateId)->orderBy('order_date','desc')->groupBy('status')->groupBy('user_id')->get();


		return $this->getResponse(200,"payment report",(Object)array('total'=>$payment_report_data->count(),'data'=>$payment_report_data),1);
	}

	public function paymentReportDetail($order_id,$id)
    {

		$affiliateId =  Auth::user()->id;
		$order_detail_data = [];
		$order_data = [];

		if($order_id!=''){

			$order_data = AffiliateWallet::select('tbl_affiliate_wallet.user_id','user_detail.f_name as name','tbl_affiliate_wallet.id','tbl_affiliate_wallet.status',DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as date'),'order_id','amount as revenue')->where([['affiliate_id',$affiliateId],['order_id',$order_id] ])->Join('users', 'tbl_affiliate_wallet.user_id', '=', 'users.id')->Join('user_detail', 'users.id', '=', 'user_detail.user_id')->get();


			$order_detail_data = AffiliateWallet::select(DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as order_date'),'status','order_id',DB::raw('sum(amount) as total_amount'))->where([['affiliate_id',$affiliateId],['order_id',$order_id] ])->first();

		}

		if($order_id == 0 && $id > 0){

			$order_data = AffiliateWallet::select('tbl_affiliate_wallet.user_id','user_detail.f_name as name','users.email','tbl_affiliate_wallet.id','tbl_affiliate_wallet.status',DB::raw('DATE_FORMAT(tbl_affiliate_wallet.created_at, "%d-%b-%Y %H:%i:%s") as date'),'order_id','amount as revenue')->where([['affiliate_id',$affiliateId],['tbl_affiliate_wallet.status','due' ]])->Join('users', 'tbl_affiliate_wallet.user_id', '=', 'users.id')->Join('user_detail', 'users.id', '=', 'user_detail.user_id')->get();

		}

		$affiliate_address_detail = AffiliateUsers::where("id",$affiliateId)->select('address','city','state','zipcode','phone')->first();
		if($affiliate_address_detail->city > 0){

			$data_city=DB::table('us_cities')->select('CITY')->where('ID',$affiliate_address_detail->city)->first();
			$affiliate_address_detail->city = $data_city->CITY;

		}
		if($affiliate_address_detail->state > 0){

			$data_state=DB::table('us_states')->select('STATE_NAME')->where('ID',$affiliate_address_detail->state)->first();
			$affiliate_address_detail->state = $data_state->STATE_NAME;
		}

		return $this->getResponse(200,"payment detail",(Object)array('data'=>$order_data,'affiliate_address_detail'=>$affiliate_address_detail,'order_detail_data'=>$order_detail_data),1);
	}

	public static function customersList($userId)
    {

		$customers = DB::table('users')->where('role','0')->where('users.mapped_to_affiliate',$userId)
        ->join('tbl_membership','tbl_membership.user_id','=','users.id')
        ->join('user_detail','user_detail.user_id','=','users.id')
        ->select(DB::raw('DATE_FORMAT(users.created_at, "%d-%b-%Y %H:%i:%s") as date'),'users.id','user_detail.f_name as name','users.email',DB::raw('sum(users.id) as total_commission'),)
        ->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00')
        ->groupBy('tbl_membership.user_id')->get();

		foreach($customers as $key => $value){

			$aff_data = AffiliateWallet::select(DB::raw('sum(amount) as total_commission'))->
			where('tbl_affiliate_wallet.user_id',$value->id)->where('affiliate_id',$userId)->groupBy('tbl_affiliate_wallet.user_id')->orderBy('tbl_affiliate_wallet.id','desc')->get()->toArray();
			if(isset($aff_data[0]['total_commission'])){

				$value->total_commission = $aff_data[0]['total_commission'];
			}else{
				$value->total_commission = 0;
			}

		}


        return $customers;

    }

	public static function prospectsList($userId)
    {

		$prospects=DB::table('users')->where('users.mapped_to_affiliate',$userId)->where('role', '0')->orderBy('users.id','desc')
            ->LeftJoin('tbl_membership', function($query){
                $query->on( 'users.id', '=', 'tbl_membership.user_id');
                $query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');
            })
            ->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id')
            ->select('users.id','users.email','user_detail.f_name as name','user_detail.phone',DB::raw('DATE_FORMAT(users.created_at, "%d-%b-%Y %H:%i:%s") as date'))
           ->whereNull('tbl_membership.expire_at')->get();

        return $prospects;

    }

	public static function calculateCommission($user_id){

		$commsison_rows = AffiliateWallet::select(DB::raw('sum(amount) as total_commission'))->where('affiliate_id',$user_id)->groupBy('affiliate_id')->get()->toArray();

		if(!empty($commsison_rows)){
			return $commsison_rows[0]['total_commission'];
		}

		return 0;

	}

	public static function totalNonMember($user_id,$type=''){
		if($type == 'last_month'){

			$data_nonmember = DB::table('users')->where('role', '0')->orderBy('users.id','desc')
			->LeftJoin('tbl_membership', function($query) use($user_id){
				$query->on( 'users.id', '=', 'tbl_membership.user_id');
				$query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');

			})->where('users.mapped_to_affiliate','=',$user_id)->whereMonth(DB::raw('users.created_at'), Carbon::now()->subMonth()->month)
		   ->whereNull('tbl_membership.expire_at')->get();

			return $data_nonmember->count();
		}

		$data_nonmember = DB::table('users')->where('role', '0')->orderBy('users.id','desc')
        ->LeftJoin('tbl_membership', function($query) use($user_id){
            $query->on( 'users.id', '=', 'tbl_membership.user_id');
			$query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');

        })->where('users.mapped_to_affiliate','=',$user_id)
       ->whereNull('tbl_membership.expire_at')->get();

       return $data_nonmember->count();
	}

	public static function totalMember($user_id,$type=''){
		if($type == 'last_month'){
			$data = DB::table('tbl_membership')->Join('users', function($query) use($user_id){
				$query->on( 'users.id', '=', 'tbl_membership.user_id');
				$query->where('users.mapped_to_affiliate',$user_id);
				$query->where('users.role', '0');
			})->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00')->whereNotNull('tbl_membership.expire_at')->whereMonth(DB::raw('tbl_membership.created_at'),  Carbon::now()->subMonth()->month)->groupBy('tbl_membership.user_id')->get();
			return $data->count();
		}
		$data = DB::table('tbl_membership')->Join('users', function($query) use($user_id){
			$query->on( 'users.id', '=', 'tbl_membership.user_id');
			$query->where('users.mapped_to_affiliate',$user_id);
			$query->where('users.role', '0');
        })->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00')->whereNotNull('tbl_membership.expire_at') ->groupBy('tbl_membership.user_id')->get();

		return $data->count();
	}


	public function paymentDetail()
    {
		$affiliateId =  Auth::user()->id;

		$total_amount_paid=0;

		$last_payment_date='';


		$payment_data = AffiliateWallet::select('id','status',DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as order_date'),'order_id',DB::raw('sum(amount) as total_amount'))->where('affiliate_id',$affiliateId)->groupBy('status')->groupBy('order_id')->groupBy('affiliate_id')->orderBy('order_date','desc')->get();

		$total_amount_data = AffiliateWallet::select(DB::raw('sum(amount) as total_amount'),'order_date')->where('affiliate_id',$affiliateId)->where('status','paid')->orderBy('order_date','desc')->groupBy('status')->get();

		$last_order_data = AffiliateWallet::select(DB::raw('DATE_FORMAT(order_date, "%d-%b-%Y %H:%i:%s") as last_payment_date'))->where('affiliate_id',$affiliateId)->where('status','paid')->orderBy('order_date','desc')->get();


		if(isset($last_order_data[0]['last_payment_date'])){

			$last_payment_date = $last_order_data[0]['last_payment_date'];
		}

		if(isset($total_amount_data[0]['total_amount'])){

			$total_amount_paid = $total_amount_data[0]['total_amount'];
		}

		return $this->getResponse(200,"payment detail",(Object)array('total'=>$payment_data->count(),'data'=>$payment_data,'total_amount_paid'=>$total_amount_paid,'last_payment_date'=>$last_payment_date),1);
	}


	private function signupWelcomeEmailAffiliate($email,$password)
    {
        //Retrieve the user from the database
        $user = AffiliateUsers::where('email',$email)->first();

        if(isset($user)){
			$data = array(
				"email" => $user->email,
				"fullname" =>$user->f_name,
				"password" => $password
			);
			return  $user->notify(new AffiliateWelcome($data,''));

			//return "send";


        }
        return "error";

    }


	public function affiliateSaveTaxPaypal(Request $request){
		//echo url('/affiliate')."/dsadsad"; die;
		$validator = Validator::make($request->all(),[
			'taxid'       		=> 'required',
			'paypal_email'		=> 'required',
			'token'				=> 'required',
        ]);

        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$token 					= 	$request->get("token");
		$taxid 					= 	$request->get('taxid');
		$paypal_email_address 	= 	$request->get('paypal_email');


		$user = AffiliateUsers::where(['affiliate_token'=>$token,'status'=> '1'])->first();

		if($user){
			$updated = $user->update(['taxid' => $taxid,'paypal_email_address' => $paypal_email_address,'affiliate_token'=>NULL]);
			if($updated){

				Auth::guard('affiliate')->login($user); // login user automatically
				return $this->getResponse(200,"You are loggedin successfully",$user,1);

			}else{

				return $this->getResponse(200,"update failed",$user,1);
			}

		}

		return $this->getResponse(200,"Invalid token",$user,1);
	}



	private function getUsername($fullname) {
        $username = Str::slug($fullname);
		$username = str_replace('-', '', $username);
		$i = 0;
		while(AffiliateUsers::where('username', $username )->exists())
		{
			$i++;
			$username = $username . $i;
		}

		return $username;
	}

	public function customerResetPassword(Request $request)
	{

		//Validate input
		$validator = Validator::make($request->all(),[
			'old_password' => 'required',
			'password' => 'required|confirmed|min:6|different:old_password'
		]);

		//check if input is valid before moving on
		if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$old_password 	= 	$request->get("old_password");
		$new_password 	= 	$request->get("password");
		$user 			= 	User::where('id', Auth::id())->select('password','email')->first();


		if(Hash::check($request->get("old_password"), $user->password)){
			$updated = User::where('id',Auth::id())->update(['password'=>Hash::make($new_password)]);
			if($updated){
				//Send Email Reset Success Email
				if($this->sendResetPasswordSuccessEmail($user->email,$new_password) == "success") {
					return $this->getResponse(200,"Password reset successfully.");
				} else {
					return $this->getResponse(400,'Mail issue',0);
				}
				return  $this->getResponse(200,"Password changed successfully.");
			}
		}else{
			return $this->getResponse(422,"Your current password is wrong.");
		}
	}

	public function sendResetPasswordSuccessEmail($email,$password)
    {
		$user = User::with('details')->where('email',$email)->first();

		try {

        //Here send the link with CURL with an external email API

			$data = array(
			"email" => $user->email,
			"fullname" => ($user->details != "") ? ucfirst($user->details->f_name) : $user->email,
			"new_password" => $password
			);

			$user->notify(new ResetPassword($data,'Your password reset successfully.'));
			return "success";

        } catch (\Exception $e) {
            return "error";
        }
	}

	public function testEmail(Request $request)
    {
		$password = Str::random(3);
		$email = 'creativemamta17+1@gmail.com';
		//$password = Hash::make('creativemamta17@gmail.com');
		$user = User::with('details')->where('email',$email)->first();
		$name = 'mamta';
		$data = array(
		"email" => $user->email,
		"fullname" => ($user->details != "") ? $user->details->f_name : $user->email,
		"new_password" => $password
		);

		$user->notify(new ResetPassword($data,'Your password reset successfully.'));
		
		return $this->getResponse(200,'Successfully Register');
		//return $this->signupWelcomeEmail('creativemamta17@gmail.com',$password);
	}

	private function signupWelcomeEmail($email,$password)
    {
        //Retrieve the user from the database
        $user = User::with('details')->where('email',$email)->first();

        if(isset($user)){
			$data = array(
				"email" => $user->email,
				"fullname" => ($user->details!="") ? ucfirst($user->details->f_name) : $user->email,
				"password" => $password
			);
			return  $user->notify(new UserCreated($data,'Enjoy reviewing EFP\'s starter features and please reach out to us with any questions by hitting "Reply"!'));

			//return "send";


        }
        return "error";

    }

	public function forgotPassword(Request $request){

        if($request->get("email") != '') {
			$user = User::where('email', $request->email)->first();

            //Check if the user exists
            if (!$user){
                return $this->getResponse(400,"User does not exist");
            }
            //Create Password Reset Token
            $token =  Str::random(40);

            $data = DB::table('password_resets')->insert(
                ['email' => $request->get("email"), 'token' => $token,'created_at' => Carbon::now()]
            );

            //Get the token just created above
            $tokenData = DB::table('password_resets')
            ->where('email', $request->get("email"))->first();

            if ($this->sendForgotEmailToken($request->get("email"), $tokenData->token) != "error") {
               // return urlencode($request->get("email"));
			   return $this->getResponse(200,"A reset link has been sent to your email address.");
            } else {

				return $this->getResponse(400,"Error in sending email.");
            }
        }
        return $this->getResponse(400,"Please provide user email");
    }

	private function sendForgotEmailToken($email, $token)
    {
        //Retrieve the user from the database
        $user = User::with('details')->where('email', $email)->first();


        if(isset($user)){
			$link =  config('app.website_url'). '/authentication/forgot-password/?token=' . $token . '&email=' . urlencode($user->email);

        //Here send the link with CURL with an external email API
			$data = array(
				"email" 		=> 	$user->email,
				"fullname" 		=> 	($user->details!="") ? ucfirst($user->details->f_name) : $user->email,
				"url" 			=> 	$link,
				"subject" 		=> 	'Forgot password',
			);
			//print_r($data);

			//die;
			return  $user->notify(new ForgotPassword($data,"Reset your EFP password."));

			//return "send";


        }
        return "error";

    }

	public function resetPassword(Request $request)
	{
		//Validate input
		$validator = Validator::make($request->all(), [
			'email' => 'required|exists:users,email',
			'password' => 'required|confirmed'
		]);

		//check if input is valid before moving on
		if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$password = $request->get("password");
	// Validate the token
		$tokenData = DB::table('password_resets')
		->where('token', $request->get("token"))->first();

	// Redirect the user back to the password reset request form if the token is invalid
		if (!$tokenData) return $this->getResponse(422,"Token expired.");

		$user = User::where('email', $tokenData->email)->first();
	// Redirect the user back if the email is invalid
		if (!$user) return $this->getResponse(422,"Email not found.");
	//Hash and update the new password
		$user->password = bcrypt($password);
		$user->update(); //or $user->save();


		//Send Email Reset Success Email
		if ($this->sendPasswordResetSuccessEmail($tokenData->email,$password) !='error') {
			DB::table('password_resets')->where('email', $request->get("email"))
			->delete();
			 return $this->getResponse(200,"Password changed successfully.");
		} else {
			return $this->getResponse(400,"A Network Error occurred. Please try again.");
		}

	}

	private function sendPasswordResetSuccessEmail($email,$password)
    {
        //Retrieve the user from the database
         $user = User::with('details')->where('email', $email)->first();

        //Generate, the password reset link. The token generated is embedded in the link


         if(isset($user)){
        //Here send the link with CURL with an external email API
			$data = array(
				"email" 		=> 	$user->email,
				"new_password" 		=> 	$password,
				"fullname" 		=> 	($user->details!="") ? ucfirst($user->details->f_name) : $user->email
			);
			//print_r($data);

			//die;
			return  $user->notify(new ResetPassword($data,"Your Equity password has been changed successfully."));

        }

		return 'error';
    }
}
