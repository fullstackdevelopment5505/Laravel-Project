<?php

namespace App\Http\Controllers\AccountDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\LeaveRequets;
use DataTables;

class LeaveRequest extends Controller
{
    public function AddLeaveRequest(Request $request){
        $inputs = $request->only(['employee_id','employee_name','department','leave_type','holiday_from','holiday_to','no_of_days','status','reason']);
     
        $validator = Validator::make($inputs,[
            'employee_id' => 'required',
            'employee_name' => 'required',
            'department' => 'required',
            'leave_type' => 'required',
            'holiday_from' => 'required',
            'holiday_to' => 'required',
            'no_of_days' => 'required',
            'status' => 'required',
            'reason' => 'required'

        ]);
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            $holiday_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('holiday_from'))));
            $holiday_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('holiday_to'))));

            $data=LeaveRequets::create([
                'employee_id' => $request->get('employee_id'),
                'employee_name' => $request->get('employee_name'),
                'department' => $request->get('department'),
                'leave_type' => $request->get('leave_type'),
                'no_of_days' => $request->get('no_of_days'),
                'status' => $request->get('status'),
                'reason' => $request->get('reason'),
                'holiday_from' => $holiday_from,
                'holiday_to' => $holiday_to
            ]);
         
           return redirect()->back()->with('success','invoice added successfully');
        }   
    }


    public function LeaveRequestView()
    {
       
        return view('AccountDashboard.employee.leaveRequest');
    }

    function LeaveRequestList(){
        $LeaveRequets = LeaveRequets::select('*');
        return DataTables::of($LeaveRequets)

        ->make(true);            
    }
}
