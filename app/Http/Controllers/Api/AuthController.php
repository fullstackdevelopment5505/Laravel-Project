<?php

namespace App\Http\Controllers\Api;

use Laravel\Passport\Passport;
use App\Http\Controllers\Api\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator, Response, DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Mail\MailNotify;
use App\User;
use App\AffiliateUsers;
use App\Model\Detail;
use App\Model\Subscribe;
use App\Notifications\UserCreated;
use App\Notifications\CancelMembershipConfirmation;
use App\Notifications\AffiliateWelcome;
use App\Notifications\ResetPassword;
use App\Notifications\ForgotPassword;
use Twilio\Rest\Client;
class AuthController extends MainController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name'       	=> 'required',
            'address'		=> 'required',
            'postal'		=> 'required',
            'phone'			=> 'required'
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

        $exists=Detail::where('user_id',Auth::id())->count();
        if($exists==0){

	        $data=array(
	        	'user_id'		=>Auth::id(),
	            'f_name'  		=>$request->get('f_name'),
	            'address'  		=>$request->get('address'),
	            'postal'  	    =>$request->get('postal'),
				'phone'  		=>$request->get('phone'),
				'phone_verify'	=> $request->get('phone_verify')//punch
	        );
	        $user=Detail::create($data);
        }
        else{
        	$data=array(
	            'f_name'  		=>$request->get('f_name'),
	            'address'  		=>$request->get('address'),
	            'postal'  	    =>$request->get('postal'),
	            'phone'  		=>$request->get('phone'),
				'phone_verify'	=> $request->get('phone_verify')//punch
	        );
	        $user=Detail::where('user_id',Auth::id())->update($data);
        }
        User::where('id',Auth::id())->update(['reg_status'=>'2']);
        return $this->getResponse(200,'Register Successfully');
    }


    public function register_one(Request $request)
    {
		//print_r($request->all()); die;
		$validator = Validator::make($request->all(),[
			'f_name'       	=> 'required',
            'email'      	=> 'required|unique:users,email',
			'postal'		=> 'required',
			'industry'      => 'required',
			'phone'			=> 'required', //punch
        ]);

        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$password = Str::random(10);
		$affiliate_id = 0;
		$mapped_user_id = 0;
		$service_code_input = $request->get('serviceCode');

		if($service_code_input !=""){

			$affiliate = AffiliateUsers::select('id')->where('service_code',$service_code_input)->first();
			$mapped_user = User::select('id')->where('username',$service_code_input)->first();
			if($affiliate){
				$affiliate_id = $affiliate->id;

			}else if($mapped_user){
				$mapped_user_id = $mapped_user->id;

			}else{
				return $this->getResponse(422,'Invalid service code.',0);
			}

		}
		/* if ($service_code_input !="" && $mapped_user)){
			$cust_prefix = substr($service_code_input,0,3);
			$service_code = substr($service_code_input,3,strlen($service_code_input));
			$mapped_user = User::select('id')->where([['service_code',$service_code],['service_code_prefix',$cust_prefix]])
							->first();
			if($mapped_user){
				$mapped_user_id = $mapped_user->id;

			}else{
				return $this->getResponse(422,'Invalid service code.',0);
			}
		} */

		if($request->get('shareaffiliateRef')!=""){

			$share_username = $request->get('shareaffiliateRef');
			$affiliate_data = AffiliateUsers::select('id')->where('username',$share_username)->first();
			if($affiliate_data){
				$affiliate_id = $affiliate_data->id;
			}
			$mapped_user = User::select('id')->where('username',$share_username)->first();

			if($mapped_user){
				$mapped_user_id = $mapped_user->id;
			}
		}
		$user_service_code = 121;
		$lastinserted = User::orderBy('id','desc')->pluck('service_code')->first();
		if($lastinserted){

			$user_service_code = $lastinserted+1;
		}
		$name = $request->get('f_name');
		$service_prefix = strtoupper(substr($name,0,3));
        $data=array(
            'email'     		  => $request->get('email'),
            'password' 		 	  => Hash::make($password),
			'mapped_to_affiliate' => $affiliate_id,
			'mapped_to_users' => $mapped_user_id,
			'service_code' 	      => $user_service_code,
			'service_code_prefix' => $service_prefix,
			'username' => $service_prefix.$user_service_code,
			'phone'			=> $request->get('phone'),//punch
			'phone_verify'	=> $request->get('phone_verify')//punch
        );
        $user=User::create($data);
		$detail=array(
			'user_id'       => $user->id,
			'f_name'  		=> $request->get('f_name'),
	        'postal'  	    => $request->get('postal'),
			'industry'      => $request->get('industry'),

			);

        Detail::create($detail);

        $token['token']=$user->createToken('equity')->accessToken;
        User::where('id',$user->id)->update(['api_token'=>$token['token']]);

        unset($user->id);
        $user->token=$token['token'];
		if($user){
			$this->signupWelcomeEmail($user->email,$password);
		}

		return $this->getResponse(200,'Register Successfully',$user,1);
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
					return $this->getResponse(200,"password reset successfully.");
				} else {
					return $this->getResponse(400,'Mail issue',0);
				}
				return  $this->getResponse(200,"Password changed.");
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
		$email = 'creativemamta17@gmail.com';
		//$password = Hash::make('creativemamta17@gmail.com');
		$user = User::with('details')->where('email',$email)->first();
		$name = 'mamta';
		$data = array(
		"email" => $user->email,
		"greetings"      => 'Hello Mamta',
		"fullname" => ($user->details != "") ? $user->details->f_name : $user->email,
		"subject" 		 => 'Membership cancel request confirmation',
				"line1" 		 => 'asa',
				"line2" 		 => 'asas',
				"cancel_subject" => 'subhject',
				"comment"		 =>'comment',
		);

		return "cccv ".$user->notify(new CancelMembershipConfirmation($data,'Your password fdsfdsfreset aadasdsuccessfully.'));

		return $this->getResponse(200,'Register Successfully');
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
	// punch
	public function sendPhone(Request $request){
		$sid = 'ACd8659eddca2c5a3aae205d29ec9962bf';//punch
		$token ='c67b837b8c9dba974d5abae140cc8655'; //punch
		$client = new Client($sid, $token);
		$pin = rand(0,9) . rand(0,9). rand(0,9). rand(0,9);
		$client->messages->create(request('to'), array("from" => '+17865029575','body' => 'Verification Code : '.$pin));
		return $this->getResponse(200,$pin);
	}
	// punch
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'         => 'required|exists:users,email',
            'password'      => 'required|between:6,20'
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$user = User::where("email", "=", request('email'))->where("role","0")->first();

		if(!isset($user)){
			return $this->getResponse(422,"Please enter valid credential",(Object)[],0);

		}
		if($user->status == 0){

			return $this->getResponse(422,"Your account is not activated,please contact with our admin.",(Object)[],0);
		}
        if(Auth::attempt(['email' => request('email'), 'password' => request('password'),'status'=>'1','type'=>'0']))
        {
			$user=Auth::user();
			Passport::personalAccessTokensExpireIn(Carbon::now()->addHours(10));
			$objToken = $user->createToken('bet');
			$strToken = $objToken->accessToken;
			$user->token = $strToken;
			$expiration = $objToken->token->expires_at->diffInSeconds(Carbon::now());
			User::where("id", "=", $user->id)->update(["api_token" => $strToken, "last_login" => Carbon::now()->format('Y-m-d H:i:s')]);

			unset($user->id);
			unset($user->email_verified_at);
			unset($user->status);
			unset($user->type);

			return $this->getResponse(200,"You are loggedin successfully",$user,1);
        }
        else{
            return $this->getResponse(422,"Please enter valid credential",(Object)[],0);
        }
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'         => 'required|unique:subscriber,email',
        ],['email.unique'=>'You are already subscribed']);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
        $data=array(
            'email'=>$request->get('email')
        );

        Subscribe::create($data);
        return $this->getResponse(200,"You are subscribed successfully");
    }

	public function forgotPassword(Request $request){

        if($request->get("email") != '') {
			$user = User::where('email', $request->email)->first();

            //Check if the user exists
            if (!$user){
                return $this->getResponse(200,"If your account exists on our system then you will get an email from us to change your password.",0);
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
			   return $this->getResponse(200,"A reset link has been sent to your email address.");
            } else {

				return $this->getResponse(200,"Error in sending email.",0);
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
			return  $user->notify(new ForgotPassword($data,"Reset your EFP password."));
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
			 return $this->getResponse(200,"password changed.");
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
			return  $user->notify(new ResetPassword($data,"Your Equity password has been changed successfully."));
        }
		return 'error';
    }
}
