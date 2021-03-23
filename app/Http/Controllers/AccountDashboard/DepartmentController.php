<?php

namespace App\Http\Controllers\AccountDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Department;
use Validator;
use DataTables;

class DepartmentController extends Controller
{
    public function AddDepartment(Request $request){
        $inputs = $request->only(['name']);
     
        $validator = Validator::make($inputs,[
            'name' => 'required'
        
        ]);
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            // $holiday_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('holiday_date'))));
            
            $holiday=Department::create([
                'name' => $request->get('name'),
               
            ]);
               return redirect()->back()->with('Holiday','Holiday added successfully');
        }
    }

    public function DepartmentView()
    {
        return view('AccountDashboard.employee.department');
    }
    
    function DepartmentList(){
        $Department = Department::select('*');
        return DataTables::of($Department)
        ->make(true);
        
    }
}
