<?php

namespace App\Http\Controllers\AccountDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Auth, Validator, Response, DB;
use App\User;
use App\Model\Subscribe;
use App\Model\Detail;
class UserController extends Controller
{
    public function index($value='')
    {
       // $user=User::where('type','0')->orderBy('id','desc')->get();

        $user = User::with('detail')->where('role' ,'<>' , 2)->get();
        
    	return view('AccountDashboard.employee.employee',compact('user'));
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
       
        
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
             'email' => 'required|unique:users,email',
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required',
            'company' => 'required',
            'password' => 'required|min:3|confirmed',
        'password_confirmation' => 'required|min:3',
            'designation' => 'required',
           
      
        ]);


        if ($validator->passes()) {


            
            $data=array(
            	'username'=>$request->get('username'),
                'email'=>$request->get('email'),
                'password'=>Hash::make($request->get('password')),
                'designation'=>$request->get('designation'),
            );
            $user=User::create($data);
            $detail=array(
            	'user_id'=>$user->id,
                'f_name'=>$request->get('f_name'),
                'phone'=>$request->get('phone'),
                'l_name'=>$request->get('l_name'),
                'company'=>$request->get('company'),
                'joinnig_date'=>$request->get('joinnig_date'),
               
            );
           $detail=Detail::create($detail);
         
			return response()->json(['success'=>'Added new records.']);
        }


    	return response()->json(['error'=>$validator->errors()->all()]);
    }


    public function update(Request $request, $id)
    {
        
             $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'required|unique:users,email,'.$id,
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required',
            'company' => 'required',
            'password' => 'confirmed',
            'designation' => 'required',
            
        ]);


        if ($validator->passes()) {
                $User=  User::find($id);
                $User->username = request('username');
                $User->email = request('email');
                $User->role = request('role');
                $User->password = Hash::make($request->get('password'));
                $updated = $User->save();
             if($updated){

                $detaildata = Detail::firstOrNew(array('user_id' => $id));
                $detaildata->f_name = request('f_name');
                $detaildata->l_name = request('l_name');
                $detaildata->company = request('company');
                $detaildata->phone = request('phone');
                $detaildata->joinnig_date = request('joinnig_date');
                $detaildata->save();
             }
            return response()->json(['success'=>'Records updated.']);   
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }


    public function destroy($id)
    {

        $user = User::find($id);

        // delete related   
        $detail = $user->detail()->delete();
        if ($detail) {
            $user->delete();
            return redirect()->route('employee.index')->with('success','User Deleted');
            
         } else {

            return view('employee.index')->with('error','User not Deleted');
        }
    }

}
