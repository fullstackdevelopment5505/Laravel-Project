<?php

namespace App\Http\Controllers\AffiliateDashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Team;
use App\User;
use App\Model\Detail;
use Auth;
use App\Model\Image;
use App\Model\Manager;
use Validator;
class TeamController extends Controller
{
    function teamList(){
	
        $team = Detail::leftjoin('users','users.id','user_detail.user_id')
		->select('user_detail.f_name','user_detail.phone','users.email','users.created_at')
        ->where(['user_detail.state'=>'5','users.role'=>'5'])
        ->orderBy('users.created_at','DESC');
        return DataTables::of($team)
        // ->addIndexColumn()
        ->addColumn('sales','12')
        ->addColumn('commision','12')
        ->addColumn('department','sale')
		 ->addColumn('phone',function ($team){    
        return "(".substr($team->phone, 0, 3).") ".substr($team->phone, 3, 3)."- ".substr($team->phone,6);
        
    })
        // ->addColumn('city',
        
        // '<span>'.$team->city.'</span>')
        // ->addColumn('action', 
        // '<a href="javascript:void(0)" id="edit-team"  data-id={{$id}}><i class="fa fa-pencil"></i></a>
        // <a href="{{ route(\'sale_manager.teamDelete\',$id) }}" class="trash"><i class="fa fa-trash"></i></a></li>')
        ->rawColumns(['department','commision','sales','phone'])
        ->make(true);

    }
    function deleteTeam($id){
        $team = User::where('id',$id)->delete();
        return redirect()->back()->with('success','Deleted sucessfully');
    }

    public function addTeam(Request $request){
        // $inputs = $request->only(['username','email','password','role']);
        $username=$request->input('username');
        $email=$request->input('email');
        $pass=$request->input('password');
        $password=bcrypt($pass);
        $role=$request->input('role');
        $phone=$request->input('phone');
        $upld_profile_image = '';
      if($request->hasFile('image')){

        $upld_profile_image = $request->file('image')->store('profile_image');
      }
        
        // $inputs=array('username'=>$username,'email'=>$email,'password'=>$password,'role'=>$role);
        // $validator = Validator::make($inputs,[
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'password'=>'required',
        //     // 'phoneno' => 'required|numeric',
        // ]);
        // if($validator->fails()){
        //     // $errorMessages = $validator->messages()->toArray();
        //     return redirect()->back()->withErrors($validator);        
        //     // return redirect()->back()->with('error','Invalid inputs');
        // }
        // else{
            $inputs=array('username'=>$username,'email'=>$email,'password'=>$password,'role'=>$role);
               $data=User::create($inputs);
               if($data){
                $state=$request->input('state');
                $city=$request->input('city');    
                $phone=$request->input('phone');
                   $user_id=$data->id;
                   $detail=array('phone'=>$phone,'user_id'=>$user_id,'state'=>$state,'city'=>$city);
                   $managerDetail=array('sale_manager'=>'12','sale_executive'=>$user_id);
                   $userDetail=Detail::create($detail);
                   $manager=Manager::create($managerDetail);
                   $image=array(
                    'user_id'=>$user_id,
                    'type'=>'1',
                    'filename'=>$upld_profile_image
                );
                Image::create($image);
               }
               return redirect()->route('affiliateTeam')->with('success','Team member added successfully');
        // }
    }
    public function updateTeam(Request $request)
    { 
        if($request->has(['id','first_name','email','city','department','phoneno']) 
        && $inputs=$request->only(['id','first_name','email','city','department','phoneno'])){
            $id=$request->input('id');
            $name=$request->input('first_name');
            $email=$request->input('email');
            $city=$request->input('city');
            $phoneno=$request->input('phoneno');
            $department=$request->input('department');
            $data=array('id'=>$id,'first_name'=>$name,'email'=>$email,'phoneno'=>$phoneno,'city'=>$city,'department'=>$department);
            Team::where('id',$id)->update($data);
            return redirect()->back()->with('success','Succesfully updated');    
        }else{
                return redirect()->back()->withErrors('Invalid Parameters');    
            }    
    }    



}
