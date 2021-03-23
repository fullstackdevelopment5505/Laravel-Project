<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect; 
use Illuminate\Support\Facades\Session;     
use Illuminate\Support\Facades\Auth;
use App\User;
use App\AffiliateUsers;
use App\Model\Subscribe;
class UserController extends Controller
{
    public function index($value='')
    {
    	$user=User::where('type','0')->orderBy('id','desc')->get();
    	return view('user.list',compact('user'));
    }
	public function loginHome()
	{
	  
		return redirect('/');
	}

    public function loginPage()
    {
        return view('login');
    }
	
    public function verified($value='')
    {
        $user=User::where([['type','0'],['status','1']])->orderBy('id','desc')->get();
        return view('user.list',compact('user'));  
    }

    public function unverified($value='')
    {
        $user=User::where([['type','0'],['status','0']])->orderBy('id','desc')->get();
        return view('user.list',compact('user'));  
    }

    public function destroyMulti(Request $request)
    {
        foreach ($request->get('selected') as $key => $value) {
            User::where('id',$value)->delete();
            // Image::where('user_id',$value)->where('type','2')->delete();
        }
        echo '1';
    }

    public function show($value='')
    {
        $user=User::where('id',$value)->first();
        return view('user.show',compact('user'));
    }

    public function subscriber(Request $request)
    {
       $user=Subscribe::orderBy('id','desc')->get();
       return view('subscriber.list',compact('user'));  
    }
    public function login(Request $request){
        $email=$request->input('email');
        $password=$request->input('password');
		
        if(Auth()->attempt(['email'=>$email,'password'=>$password])){
			if(Auth::user()->role=='0'){
				return redirect()->back()->with('error','Invalid credentials');
			}
			if(Auth::user()->role=='1'){
				return redirect()->route('customerDashboard');
			}
			if(Auth::user()->role=='2'){
				 return redirect()->route('accountDashboard');
			} 
			 if(Auth::user()->role=='3'){
				return redirect()->route('superadminDashboard');
			} 
			if(Auth::user()->role=='4'){
				return redirect()->route('salemanagerDashboard');
			} 
			if(Auth::user()->role=='5'){
				return redirect()->route('saleExecutiveDashboard');
			} 
        }else{
            return redirect()->back()->with('error','Invalid credentials');
        }
    }
	
	
    public function logout(){
        Auth::logout();
        return redirect()->route('login.show');
    }
	
	public function affiliateAddTaxPaypal(Request $request){
		//echo url('/affiliate')."/dsadsad"; die;
		
		$token = $request->get("token");
		
		$user = AffiliateUsers::where(['affiliate_token'=>$token,'status'=> '1'])->first();
	
		//echo $token; die;
		$id = 0;
		if($user){
			if($user->taxid !='' && $user->paypal_email_address !=''){
				Auth::guard('affiliate')->login($user);
				
				return redirect()->route('affiliateDashboard');
				
			}else{
				$id = $user->id;
				$error_message = 0;
				return view('addtaxPaypal',compact('error_message','id'));
			}
			
		}
		$error_message = 1;
		//echo "sadasd"; die;
		return redirect()->route('affiliatelogin');
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
				Auth::guard('affiliate')->login($user);// login user automatically
				return redirect()->route('affiliateDashboard');
			}
		}
		return view('addtaxPaypal');
		
	}

}
