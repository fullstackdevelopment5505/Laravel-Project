<?php

namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Validator, Response, DB;
use DataTables;
use App\Model\Holiday;
class HolidayController extends Controller
{
    public function holiday($value='')
    {
               return view('SuperadminDashboard.employee.holiday');
    }

    public function holidayList(){
        $holiday = Holiday::get();
        if(request()->ajax()) {
            return DataTables::of($holiday)
            ->addColumn('action', function($holiday) {
                $button = '<span style="display:none;" class="name">'.$holiday->name.'</span>
                <span style="display:none;" class="holiday_date">'.date('d-M-yy', strtotime(str_replace('-', '/', $holiday->holiday_date))).'</span>
                <span style="display:none;" class="day">'.date('d-M-yy', strtotime(str_replace('-', '/', $holiday->holiday_date))).'</span>';
                $button .= '<button class="btn btn-success"  data-url='.\URL::route('superadminEmployeeHolidayEdit', $holiday->id).' data-title="Edit Kickstarter" type="button" id="edit-holiday" data-kickstart_id="'.$holiday->id.'">Edit</button>';
                $button .='  <button  class="btn btn-danger delHoliday" type="button" data-id="'. $holiday->id.'"  >delete</button>';
             
                  return $button;
            })

            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('SuperadminDashboard/kickstarter');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'holiday_date' => 'required|date_format:d/m/Y',  
        ]);   
        if ($validator->passes()) {   
            $holiday_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('holiday_date'))));
            $holiday=Holiday::create([
                'name' => $request->get('name'),
                'holiday_date' => $holiday_date
            ]);
			return response()->json(['success'=>'Added new records.']);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'holiday_date' => 'required|date_format:d/m/Y',
        ]);
        $holiday_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('holiday_date'))));
        if ($validator->passes()) {
            $holidayData    =   $request->all();
            $holiday        =   Holiday::find($id);
            $updated        =   $holiday->update([
                'name' => $request->get('name'),
                'holiday_date' => $holiday_date
            ]);
            return response()->json(['success'=>'Records updated.']);   
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function destroy(Request $request,$id)
    {
        $Holiday = Holiday::destroy($id);
        if ($Holiday) {   
            return response()->json(['success'=>'Holiday Deleted.']);  
        } else {
            return response()->json(['error'=>'Holiday not Deleted.']); 
        }
    }
    

}
