<?php

namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\AccountChart;
use Validator;
use DataTables;

class AccountChartController extends Controller
{


    public function AccountChartList()
    {
        return view('SuperadminDashboard.accountBooks.chartAccount');
    }
    
    function AccountChart(){
        
        $AccountChart = AccountChart::select('*')->where('status','1');
      
        return DataTables::of($AccountChart)
        ->addColumn('action', 
 '<a href="javascript:void(0)" id="edit-team"  data-id="{{$id}}" data-account_type="{{$account_type}}" data-title="{{$title}}" data-type="{{$type}}"><i class="fa fa-pencil"></i></a>
        <a href="{{ route(\'chartAccount.DeletAoc\',$id) }}" class="trash"><i class="fa fa-trash"></i></a></li>')
        ->rawColumns(['action'])
        ->make(true);
        return view('SuperadminDashboard.accountBooks.chartAccount');
    }
    function AccountChartPurchase(){
        
        $AccountChart = AccountChart::select('*')->where('status','2');
      
        return DataTables::of($AccountChart)
        ->addColumn('action', 
 '<a href="javascript:void(0)" id="edit-team"  data-id="{{$id}}" data-account_type="{{$account_type}}" data-title="{{$title}}" data-type="{{$type}}"><i class="fa fa-pencil"></i></a>
        <a href="{{ route(\'chartAccount.DeletAoc\',$id) }}" class="trash"><i class="fa fa-trash"></i></a></li>')
        ->rawColumns(['action'])
        ->make(true);
        return view('SuperadminDashboard.accountBooks.chartAccount');
    }
    //Addchart

    
    public function Addchart(Request $request){
        $inputs = $request->only(['account_type','gl_code','title','type']);
 
        $validator = Validator::make($inputs,[
            'account_type' => 'required',
            'gl_code'=>'required',
            'title'=>'required',
            'type'=>'required'   
        ]);
     
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            // $holiday_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('holiday_date'))));
            
            $inputs=AccountChart::create([
                
                'account_type' => $request->get('account_type'),
                'gl_code' => $request->get('gl_code'),
                'title' => $request->get('title'),
                'type' => $request->get('type'),
                'status'=>1
            ]);
   
               return redirect()->back()->with('Chart Of Account','Data added successfully');
        }
    }
    public function AddchartPurchase(Request $request){
        $inputs = $request->only(['account_type','gl_code','title','type']);
 
        $validator = Validator::make($inputs,[
            'account_type' => 'required',
            'gl_code'=>'required',
            'title'=>'required',
            'type'=>'required'   
        ]);
     
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            // $holiday_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('holiday_date'))));
            
            $inputs=AccountChart::create([
                
                'account_type' => $request->get('account_type'),
                'gl_code' => $request->get('gl_code'),
                'title' => $request->get('title'),
                'type' => $request->get('type'),
                'status'=>2
            ]);
   
               return redirect()->back()->with('Chart Of Account','Data added successfully');
        }
    }

    public function updateAccountChart(Request $request)
    { 
        if($request->has(['id','account_type','title','type']) 
        && $inputs=$request->only(['id','account_type','title','type'])){
            $id=$request->input('id');
            $account_type=$request->input('account_type');
            $title=$request->input('title');
            $type=$request->input('type');
            $data=array('id'=>$id,'account_type'=>$account_type,'title'=>$title,'type'=>$type);
            AccountChart::where('id',$id)->update($data);
            return redirect()->back()->with('success','Succesfully updated');    
        }else{
                return redirect()->back()->withErrors('Invalid Parameters');    
            }    
    }  
    
    function deleteAoc($id){
        
        $team = AccountChart::where('id',$id)->delete();
     
        return redirect()->back()->with('success','Deleted sucessfully');
    }

}
