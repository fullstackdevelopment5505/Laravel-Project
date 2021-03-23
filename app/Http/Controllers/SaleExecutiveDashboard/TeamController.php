<?php

namespace App\Http\Controllers\SaleExecutiveDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Http\Request;
use App\Team;
use Redirect,Response;

class TeamController extends Controller
{
    private const BASE_UPLOAD_URL = 'public/img/';

    public function addTeam(Request $request){
        $inputs = $request->only(['first_name','last_name','email','phoneno',
        'dob','age','gender','city','department']);
        $validator = Validator::make($inputs,[
            // 'name' => 'required',
            'email' => 'required|email',
            'phoneno' => 'required|numeric',
        ]);
        if($validator->fails()){
            // $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->withErrors($validator);        

            // return redirect()->back()->with('error','Invalid inputs');
        }
        else{
               $data=Team::create($inputs);
               return redirect()->back()->with('success','Team member added successfully');
        }
    }
    function deleteTeam($id){
        $team = Team::where('id',$id)->delete();
        return redirect()->back()->with('success','Deleted sucessfully');
    }
    public function editTeam($id)
    {   
        $where = array('id' => $id);
        $product  = Team::where($where)->first();
      
        return Response::json($product);
    }

    function teamList(){
        $teamMember = Team::select('*');
        return DataTables::of($teamMember)
        ->addColumn('sales','12')
        ->addColumn('commision','12')
         ->addColumn('action','
         <a href="#"><i class="fa fa-eye"></i></a>
         <a href="javascript:void(0)" id="edit-team"  data-id={{$id}}><i class="fa fa-pencil"></i></a>
         <a  href={{ route(\'saleExecutive.teamDelete\',$id) }} class="trash"><i class="fa fa-trash"></i></a>
        ')
        ->rawColumns(['sale','commision','action'])
        ->make(true);
    } 
    public function update(Request $request)
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
    
        
    // function addTeam(Request $req){
            // $files = $req->file('file');
            // $name = $files->getClientOriginalName();
            // $destinationPath = public_path(self::BASE_UPLOAD_URL);
            // $files->move($destinationPath,$name);
            // $saveFilename =  self::BASE_UPLOAD_URL.$name;
        //     $firstName=$req->input('first_name');
        //     $lastName=$req->input('last_name');
        //     $email=$req->input('email');
        //     $phoneno=$req->input('phoneno');
        //     $dob=$req->input('dob');
        //     $age=$req->input('age');
        //     $gender=$req->input('gender');
        //     $city=$req->input('city');
        //     $department=$req->input('department');

        //     $data=array('first_name'=>$firstName,'last_name'=>$lastName,'email'=>$email,'phoneno'=>$phoneno,
        //     'dob'=>$dob,'age'=>$age,'gender'=>$gender,'city'=>$city,'department'=>$department);
        //     $validator = Validator::make($data, [
        //         'name'=>'required',
        //         'image'=>'required',
        //     ]);

        //     if($validator->fails()) {
        //         return redirect()->back()->withErrors($validator);        
        //     }
        //     else{
        //         $value=Team::insert($data);
        //         return redirect()->back()->with('success','Team added successfully');
        //     }
        // }
    
}
