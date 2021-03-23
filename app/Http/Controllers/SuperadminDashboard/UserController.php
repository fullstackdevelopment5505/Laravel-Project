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
use App\Model\Subscribe;
use App\Model\Detail;
use App\Model\Image;
use App\Model\Customer;
use App\Model\Role;
use App\AffiliateUsers;
use App\AffiliateCommission;
use App\Notifications\AffiliateRegister;

class UserController extends Controller
{
	public function getUser(){
		
		$users = User::select('email','id')->where('role',0)->get();
		$affiliates = AffiliateUsers::select('email','id')->get();
		
		return view('SuperadminDashboard.userList',compact('users','affiliates'));
	}
	public function trashUser(Request $request){
		
		if($request->get('user_id') > 0){
			$id = $request->get('user_id');
			DB::table('user_detail')->where('user_id','=',$id)->delete();
			DB::table('tbl_membership')->where('user_id','=',$id)->delete();
			DB::table('user_subscriptions')->where('user_id','=',$id)->delete();
			DB::table('tbl_deposite')->where('user_id','=',$id)->delete();
			DB::table('points_transaction')->where('user_id','=',$id)->delete();
			DB::table('tbl_purchased_records')->where('user_id','=',$id)->delete();
			DB::table('tbl_saved_search')->where('user_id','=',$id)->delete();
			DB::table('results')->where('user_id','=',$id)->delete();
			DB::table('property_result_id')->where('user_id','=',$id)->delete();
			DB::table('user_property')->where('user_id','=',$id)->delete();
			DB::table('tbl_contact_logs')->where('user_id','=',$id)->delete();
			DB::table('tbl_manage_grid')->where('user_id','=',$id)->delete();
			DB::table('images')->where('user_id','=',$id)->delete();
			DB::table('user_postcard_designs')->where('user_id','=',$id)->delete();
			DB::table('user_postcard_images')->where('user_id','=',$id)->delete();
			DB::table('user_postcard_designs')->where('user_id','=',$id)->delete();
			DB::table('users')->where('id','=',$id)->delete();
		}
		if($request->get('affiliate_id')> 0){
			$affiliate_id = $request->get('affiliate_id');
			DB::table('tbl_affiliate_commissions')->where('affiliate_id','=',$affiliate_id)->delete();
			DB::table('tbl_affiliate_wallet')->where('affiliate_id','=',$affiliate_id)->delete();
			DB::table('affiliate_users')->where('id','=',$affiliate_id)->delete();
			DB::table('users')
			->where('mapped_to_affiliate', $affiliate_id)
			->update(array('mapped_to_affiliate' => ''));
		}
		
		$users = User::select('email','id')->where('role',0)->get();
		$affiliates = AffiliateUsers::select('email','id')->get();
		
		return view('SuperadminDashboard.userList',compact('users','affiliates'));
	}
	
    public function employee(){
        // $customers = User::with('customers')->where('id', 12)->get();
        // echo "<pre>"; print_r($customers); die;
        $states =   DB::table('us_states')->select('id', 'state_name')->get();
        $role = Role::whereNotIn('id' , [1,3])->get();
        $user = User::with('detail')->where('status', '1')->whereNotIn('role' , [0,3,1,6])->get();
        return view('SuperadminDashboard.employee.employee',compact('states','user','role'));
    }
   
    public function EmployeeList(Request $request)
    {
        $states =  DB::table('us_states')->select('id', 'state_name')->get();
        
        $user = User::with('detail','role_type')
        ->where('status', '1')->whereNotIn('role' , [0,3,1])->orderBy('id','desc');

        if(!empty($request->all()))
        {
            if( $request->search_id){
                
                $user->where('id', '=', $request->search_id);
            }
            if( $request->search_name){
                $user->whereHas('detail', function ($query) use($request) {
                    $query->where('f_name', 'like', "%" . $request->search_name . "%");
                    $query->orWhere('l_name', 'like', "%" . $request->search_name . "%");
                });
            }
            if( $request->search_role){
                $user->where('role', '=', $request->search_role);
            }
        }
        $user->get();
        //echo "<pre>"; print_r($user); die;
        if(request()->ajax()) {
            return DataTables::of($user)
            ->addColumn('name', function($row){
                //echo "<pre>"; print_r($row->detail);
                if(isset($row->detail)){
                    return \ucfirst( $row->detail->f_name)." ".\ucfirst($row->detail->l_name);
                }
                return '-';
            })
            ->addColumn('phone', function($row){
                //echo "<pre>"; print_r($row->detail);
                if(isset($row->detail)){
                    return $row->detail->phone;
                }
                return '-';
            })
            ->addColumn('empid', function($row){
                //echo "<pre>"; print_r($row->detail);
               
                return $row->id;
            })
            ->addColumn('join_date', function($row){
                
                return date('d-M-yy', strtotime(str_replace('-', '/', $row->created_at)));
            })
            ->addColumn('role', function($user){
               
                $role= 'Not Registered';
               
                return $user->role_type->role;
            })
            ->addColumn('action', function($user) {
               
                 $button = '<button data-url='.\URL::route('superadminEmployeeEdit', $user->id).'  data-title="Edit Contractor" type="button" class="btn btn-success" id="edit-employee"
                 data-User_id="'.$user->id.'">Edit</button>';
                $button .= ' <a href='.\URL::route('superadminEmployee.detail', $user->id).' class="btn btn-primary">View</a>';
                $button .=' <a  class="btn btn-danger delEmp" data-id="'. $user->id.'" href='.\URL::route('superadminEmployeeDelete', $user->id).' >delete</a>';
                //return 'gfhgfhgfh';
                return $button;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);

        }
        $role = Role::whereNotIn('id' , [1,3])->get();
        return view('SuperadminDashboard.employee.employee',compact('states','user','role'));

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
    
	public function ajaxHandling(Request $request)
    {
		
		if( $request->id && $request->type == "get_affiliate_commission" ){
            $commission_data = AffiliateCommission::where("affiliate_id",$request->get("id"))->get();

            if($commission_data)
            {
                return response()->json(['data'=>$commission_data]);
            } else {
                return response()->json(['error'=>'']);
            }
        }
		
        if( $request->id && $request->type == "getEmpdata" ){
            $user = User::with("detail","image")->where("id",$request->get("id"))
            ->get();

            // ->whereHas('image', function ($query) use($request) {
            //     $query->where('type', '4');
            //     $query->where('user_id', $request->get("id"));
            // })

            if($user)
            {
                return response()->json(['data'=>$user]);
            } else {
                return response()->json(['error'=>'']);
            }
        }
		if($request->get('id') && $request->get('type') == "affiliate_status"){
			
			$id 	= $request->get('id');
			$type 	= $request->get('type');
			
			$a_status 	=	 '0';
			$status 	= 	0;
			$send_mail 	= 	false;
			if($request->is_affiliate == 0){
				$a_status 	= 	'1';
				$status 	= 	1;
				$send_mail 	= 	true;
			}
			
	
			$updated = AffiliateUsers::where('id','=',$id)->update(['status' => $a_status]);
			//$d = AffiliateUsers::find($request->id);
			//print_r($d); die;
			if($updated)
            {
				//return $this->affiliateWelcomeEmail($id);
				if($send_mail){
					return $this->affiliateWelcomeEmail($id);
				}
                return response()->json(['data'=>'success']);
            } else {
                return response()->json(['data'=>'error']);
            }
		}
    }


	public static function affiliateWelcomeEmail($user_id)
    {
        //Retrieve the user from the database
        $user = AffiliateUsers::find($user_id);
		
        //Auto Generate Password,Send password with welcome email. The password generated is embedded in the email
        if(isset($user)){
			$token = Str::random(7);
			AffiliateUsers::where('id',$user_id)->update([
				'affiliate_token' =>  $token,
			]);
			//echo $user->email; die;
        //Here send the link with CURL with an external email API
			$data = array(
				'email' 		=> 	$user->email,
				'fullname' 		=> 	ucfirst($user->full_name),
				'url' 			=> 	config('app.affiliate_url')."login/affiliate?token=".$token,
			);
			return  $user->notify(new AffiliateRegister($data,"Your affiliate account is approved."));
			
			//return "send";
			
            
        }
        return "error";
        
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
    
   
    public function store(Request $request)
    {
        $validator                  =   Validator::make($request->all(), [
            'email'                 =>  'required|unique:users,email',
            'f_name'                =>  'required',
            'l_name'                =>  'required',
            'phone'                 =>  'required',
            'state'                 =>  'required',
            'city'                  =>  'required',
            'password'              =>  'required|min:3|confirmed',
            'password_confirmation' =>  'required|min:3',
            'role'                  =>  'required',
        ]);

        if ($validator->passes()) {

            $data=array(
                'email'     =>  $request->get('email'),
                'password'  =>  Hash::make($request->get('password')),
                'role'      =>  $request->get('role'),
            );
            $user           =   User::create($data);
			$phone = $request->get('phone');
			$phone = preg_replace('/[^0-9]/', '',  $phone);
            $detail=array(
            	'user_id'   =>  $user->id,
                'f_name'    =>  $request->get('f_name'),
                'phone'     =>  $phone,
                'state'     =>  $request->get('state'),
                'city'      =>  $request->get('city'),
                'l_name'    =>  $request->get('l_name')
            );
            $detail         =   Detail::create($detail);

            if ($request->hasFile('employee_image')) {
               
                $upld_profile_image = $request->file('employee_image')->store('kickstarter_image');

               

                $emp_image = new Image();
                if($user){
                    $arr=array(
                        'user_id'   => $user->id,
                        'type'      => '1',
                        'filename'=>$upld_profile_image
                    );
    
                    Image::create($arr);
                  

                }
               
            }
			return response()->json(['success'=>'Added new records.']);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
    }


    public function update(Request $request, $id)
    {
        
            $validator =   Validator::make($request->all(), [
            'email'     =>  'required|unique:users,email,'.$id,
            'f_name'    =>  'required',
            'l_name'    =>  'required',
            'phone'     =>  'required',
            'state'     =>  'required',
            'city'      =>  'required',
            'password'  =>  'confirmed',
            'role'      =>  'required',
        ]);


        if ($validator->passes()) {
                $User               =   User::find($id);
                $User->email        =   request('email');
                $User->role         =   request('role');
                $User->password     =   Hash::make($request->get('password'));
                $updated            =   $User->save();
             if($updated){

                $detaildata             =   Detail::firstOrNew(array('user_id' => $id));
				$phone = $request->get('phone');
				$phone = preg_replace('/[^0-9]/', '',  $phone);
                $detaildata->f_name     =   request('f_name');
                $detaildata->l_name     =   request('l_name');
                $detaildata->phone      =   $phone;
                $detaildata->state      =   request('state');
                $detaildata->city       =   request('city');
                $detaildata->save();

                if ($request->hasFile('employee_image')) {
               
                    $upld_profile_image = $request->file('employee_image')->store('kickstarter_image');
    
                    $image = array(
                        'filename'=>$upld_profile_image
                    );
    
                    $arr=array(
                        'user_id'   => $id,
                        'type'      => '1',
                    );
    
                    Image::updateOrCreate($arr, $image);
                    
                   
                }
             }
            return response()->json(['success'=>'Records updated.']);   
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }


    public function destroy($id)
    {

        $user = User::find($id);
        $user->status = '0';
        $userDel = $user->save();
        if ($userDel) {
            return response()->json(['success'=>'Employee Deleted.']); 
            
         } else {

            return response()->json(['error'=>'Employee not Deleted.']); 
        }
    }
	
	public function EmployeeDetail(Request $request,$id){
        $user = User::with("detail","image")->where("id",$id)->orderBy('id','desc')->first();
      
        //echo "<pre>"; print_r($user); die;
       
         
        return view('SuperadminDashboard/employee/employeeDetail',compact('user'));
    }
	
	public function affiliateUsers(){
        $user = AffiliateUsers::get();
        return view('SuperadminDashboard.affiliate.affiliate',compact('user'));
	}
	
	public function affiliateList(Request $request)
    {
        $user = AffiliateUsers::orderBy('id','desc');

        if(!empty($request->all()))
        {
            if( $request->search_name){
               $user->where('full_name', 'like', "%" . $request->search_name . "%");
            }
			if( $request->search_status){
               $user->where('status', '=',  $request->search_status);
            }
        }
        
        if(request()->ajax()) {
            return DataTables::of($user)
            ->addColumn('name', function($row){
				
              return \ucfirst( $row->full_name);
                
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
				$button .= '  <button data-title="View Detail" type="button" class="btn btn-primary">View</button>';
                return $button;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
		$user->get();
        return view('SuperadminDashboard.affiliate.affiliate',compact('user'));

    }

    

}
