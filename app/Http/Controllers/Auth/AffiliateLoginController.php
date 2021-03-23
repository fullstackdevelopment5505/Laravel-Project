<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect; 
use Illuminate\Support\Facades\Session;     
use Illuminate\Support\Facades\Auth;

class AffiliateLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/affiliate/dashboard';

    /**
     **_ Create a new controller instance.
     _**
     **_ @return void
     _**/
    public function __construct()
    {
      $this->middleware('guest:affiliate')->except('logout');
    }
    
    public function guard()
    {
     return Auth::guard('affiliate');
    }

    // login from for affiliate
    public function showLoginForm()
    {
        return view('affiliate.auth.login');
    }
	
	public function login(Request $request){
		$email		=	$request->input('email');
        $password	=	$request->input('password'); 
		
		 if (Auth::guard('affiliate')->attempt(['email' => $request->email, 'password' => $request->password])) {

           return redirect()->route('affiliateDashboard');
        }
		return redirect()->back()->with('error','Invalid credentials');
		
	} 
	
	public function logout(Request $request)
    {

        Auth::guard('affiliate')->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->route('affiliate.auth.login');
    }
	
	public function affiliateAddTaxPaypal(Request $request){
		//echo url('/affiliate')."/dsadsad"; die;
		
		$token = $request->get("token");
		
		$user = AffiliateUsers::where(['affiliate_token'=>$token,'status'=> '1'])->first();
	
		//echo $token; die;
		$id = 0;
		if($user){
			if($user->taxid !='' && $user->paypal_email_address !=''){
				
				Auth::guard('affiliate')->login($user); // login user automatically
				return redirect()->route('affiliateDashboard');
				
			}else{
				$id = $user->id;
				$error_message = 0;
				return view('addtaxPaypal',compact('error_message','id'));
			}
			
		}
		$error_message = 1;
		//echo "sadasd"; die;
		return redirect()->route('affiliate.auth.login');
	}
	
	public function affiliateSaveTaxPaypal(Request $request){
        //print_r($request->all());
		$user_id 				= 	$request->get('user_id');
		$taxid 					= 	$request->get('taxid');
		$paypal_email_address 	= 	$request->get('paypal_email');
		$user_detail = AffiliateUsers::find($user_id);
		if($user_detail){
			
			$updated = $user_detail->update(['taxid' => $taxid,'paypal_email_address' => $paypal_email_address]);
			if($updated){
				//Session::flush();
				//Auth::logout();
				$user = AffiliateUsers::find($user_id);
				Auth::guard('affiliate')->login($user); // login user automatically
				return redirect()->route('affiliateDashboard');
			}
		}
		return view('addtaxPaypal');
		
	}

}
