<?php

namespace App\Http\Controllers\AccountDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use App\Model\Department;
use App\Model\Designation;


class DesignationController extends Controller
{
    public function AddDesignation(Request $request){
        $inputs = $request->only(['designation','department']);
 
        $validator = Validator::make($inputs,[
            'designation' => 'required',
            'department'=>'required'
           
        ]);
     
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            // $holiday_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('holiday_date'))));
            
            $inputs=Designation::create($inputs);
   
               return redirect()->back()->with('Holiday','designation added successfully');
        }
    }

    public function DesignationView()
    {
        $department = Department::all(['id', 'name']);
        return view('AccountDashboard.employee.designation',['department' => $department]);
    }
    
    function DesignationList(){
        $designation = Designation::select('*');
        return DataTables::of($designation)
        ->make(true);
        
    }
}
