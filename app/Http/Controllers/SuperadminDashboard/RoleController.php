<?php

namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Validator, Response, DB;
use App\Model\Department;
use App\Model\Role;
use DataTables;

class RoleController extends Controller
{
    public function designation($value='')
    {
       // $user=User::where('type','0')->orderBy('id','desc')->get();
        $roles = Role::with('department')->get();
        $departments = Department::get();
        return view('SuperadminDashboard.employee.designation',compact('departments'));
    }


    public function designationList(){
        $departments = Department::get();
        $roles = Role::with('department')->get();
		//echo "<pre>"; print_r($roles); die;
        if(request()->ajax()) {
            return DataTables::of($roles)
            ->addColumn('action', function($roles) {
                $button = '<span style="display:none;" class="role">'.$roles->role.'</span>';
                $button .='<button data-url='.\URL('/superadmin/designation/'.$roles->id).' type="button" class="btn btn-success" 
                 id="edit-role" data-id="'.$roles->id.'">edit</button>';
                 $button .=' <a  class="btn btn-danger delDesignation" data-id="'. $roles->id.'" href ='.\URL('/superadmin/designation/delete/'. $roles->id ).'>delete</a>';
                return $button;
            })
            ->addColumn('department', function($roles) {
				$name = "-";
				if(isset($roles->department->name)){
					$name = $roles->department->name;
					
				}
            $result='<span data-id="{{$roles->department->id}}" class="department_id">'.$name.'</span>';
            return $result;
            })
            ->addIndexColumn()
            ->rawColumns(['action','department'])
            ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
                [
                    'role' => 'required',
                    'department_id' => 'required', 
                ],[
                    'role.required'         =>  'The designation field is required.',      
                    'department_id.required' => 'Please select department.',      
                ]
        );

        if ($validator->passes()) {
            $role=Role::create($request->all());
			return response()->json(['success'=>'Added new records.']);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [ 
                'role' => 'required',
                'department_id' => 'required',    
            ],[
                'role.required'         =>  'The designation field is required.',      
                'department_id.required' => 'Please select department.',      
            ]);
       
        if ($validator->passes()) {
            $roleData    =   $request->all();
            $role        =   Role::find($id);
            $updated     =   $role->update($roleData);
            return response()->json(['success'=>'Records updated.']);   
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function destroy($id)
    {
        $role = Role::destroy($id);
        if ($role) {
            return response()->json(['success'=>'Designation Deleted ']);  
        } else {
            return response()->json(['success'=>'Designation not  Deleted ']);  
        }
    }
}
