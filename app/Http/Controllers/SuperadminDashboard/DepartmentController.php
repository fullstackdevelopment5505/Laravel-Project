<?php

namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Validator, Response, DB;
use DataTables;
use App\Model\Department;

class DepartmentController extends Controller
{
    public function department($value='')
    {
        
        return view('SuperadminDashboard.employee.department');
    }
    public function departmentList(){
        $department = Department::get();
        if(request()->ajax()) {
            return DataTables::of($department)
            ->addColumn('action', function($department) {
                $button = '<span style="display:none;" class="name">'.$department->name.'</span>
                <span style="display:none;" class="department_date">'.date('d-M-yy', strtotime(str_replace('-', '/', $department->created_at))).'</span>';              
                $button .='<button data-url='.\URL('/superadmin/department/'.$department->id).' type="button" class="btn btn-success" 
                id="edit-department" data-department_id="{{$department->id}}">edit</button>';
                $button .=' <a  class="btn btn-danger delDepartment" data-id="'. $department->id.'" href ='.\URL('/superadmin/department/delete/'. $department->id ).'>delete</a>';
                  return $button;
            })

            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('SuperadminDashboard.employee.department');

    }

    public function store(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'name' => 'required'
            
        ]);
           
        if ($validator->passes()) {
            
            $department=Department::create($request->all());
            
			return response()->json(['success'=>'Added new records.']);
        }


    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        
        if ($validator->passes()) {
            $Department=  Department::find($id);
            $updated =  $Department->update($request->all());
            return response()->json(['success'=>'Records updated.']);   
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function destroy(Request $request,$id)
    {
        $Department = Department::destroy($id);
        if ($Department) {
          
            return response()->json(['success'=>'Department Deleted ']);  
            
         } else {

            return response()->json(['error'=>'Department not Deleted.']);  
        }
    }


}
