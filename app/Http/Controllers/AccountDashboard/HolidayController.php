<?php

namespace App\Http\Controllers\AccountDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Holiday;
use Validator;
use DataTables;

class HolidayController extends Controller
{
        public function AddHoliday(Request $request){
        $inputs = $request->only(['name','holiday_date']);
     
        $validator = Validator::make($inputs,[
            'name' => 'required',
            'holiday_date' => 'required'
        ]);
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            $holiday_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('holiday_date'))));
            
            $holiday=Holiday::create([
                'name' => $request->get('name'),
                'holiday_date' => $holiday_date
            ]);
               return redirect()->back()->with('Holiday','Holiday added successfully');
        }
    }

    public function HolidayView()
    {
        return view('AccountDashboard.employee.holiday');
    }
    
    function HolidayList(){
        $Holiday = Holiday::select('*');
        return DataTables::of($Holiday)
        ->addColumn('day', function($Holiday) {
           $holiday_date = date('l', strtotime($Holiday->holiday_date));
            return $holiday_date;
        })
        ->rawColumns(['day'])
        ->make(true);
        
    }
}
