<?php

namespace App\Http\Controllers\SuperadminDashboard\account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Model\VouchersEntry;
use Validator;
use DataTables;
use DB;

class VouchersController extends Controller
{
    public function addVouchers(Request $request){
        $inputs = $request->only(['purpose','amount','tax','rem_total']);
        $validator = Validator::make($inputs,[
           
            'purpose' => 'required',
            'tax' => 'required',
            'amount'=>'required',
            'rem_total' => 'required|numeric'
        ]);
      
        if($validator->fails()){
         
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            
          $data = DB::table('vouchers_entries')->where('status','Credit')->max('voucher_no');
          $voucher_no=$data+1;

               $data=VouchersEntry::create([
                
                'voucher_no' => $voucher_no,
                'purpose' => $request->get('purpose'),
                'amount' => $request->get('amount'),
                'tax' => $request->get('tax'),
                'rem_total' => $request->get('rem_total'),
                'status'=>"Credit"
                ]);
           
               return redirect()->back()->with('success','Vouchres added successfully');
        }
    }

    public function SalevoucherView()
    {
        return view('SuperadminDashboard.sale.vouchers');
    }
    
    function SalevoucherList(){
        $voucher = VouchersEntry::select('*', 'created_at as date')->where('status','Credit')->get();
        return DataTables::of($voucher)
        ->addColumn('amount', function($row){
           
            if(fmod($row["amount"], 1) !== 0.00){
                return "$".number_format($row["amount"],2);  
            } else {
                
                return "$".floatval($row["amount"]);  
            }
        })
        ->addColumn('tax', function($row){
           
            if(fmod($row["tax"], 1) !== 0.00){
                return "$".number_format($row["tax"],2);  
            } else {
                
                return "$".floatval($row["tax"]);  
            }
        })
        ->addColumn('rem_total', function($row){
           
            if(fmod($row["rem_total"], 1) !== 0.00){
                return "$".number_format($row["rem_total"],2);  
            } else {
                
                return "$".floatval($row["rem_total"]);  
            }
        })
        ->addColumn('action', 
        '<a href="javascript:void(0)" id="edit-team"  data-id="{{$id}}" data-voucher_no="{{$voucher_no}}" data-purpose="{{$purpose}}" data-amount="{{$amount}}" data-tax="{{$tax}}" data-rem_total="{{$rem_total}}"><i class="fa fa-pencil"></i></a>
        <a href="{{ route(\'vouchar.DeletAoc\',$id) }}" class="trash"><i class="fa fa-trash"></i></a></li>')
        ->rawColumns(['action'])
        ->make(true);
        
    }

    public function addPurchaseVouchers(Request $request){
        $inputs = $request->only(['purpose','amount','tax','rem_total']);
        $validator = Validator::make($inputs,[
            //'voucher_no' => 'required',
            'purpose' => 'required',
            'tax' => 'required',
            'amount'=>'required',
            'rem_total' => 'required|numeric'
        ]);
      
        if($validator->fails()){
         
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            $data = DB::table('vouchers_entries')->where('status','Debit')->max('voucher_no');
            $voucher_no=$data+1;
               $data=VouchersEntry::create([
                
                'voucher_no' => $voucher_no,
                'purpose' => $request->get('purpose'),
                'amount' => $request->get('amount'),
                'tax' => $request->get('tax'),
                'rem_total' => $request->get('rem_total'),
                'status'=>"Debit"
                ]);
               return redirect()->back()->with('success','Vouchres added successfully');
        }
    }
    public function PurchasevoucherView()
    {
        return view('SuperadminDashboard.purchase.vouchers');
    }
    
    function PurchasevoucherList(){
        $voucher = VouchersEntry::select('*', 'created_at as date')->where('status','Debit')->get();
        return DataTables::of($voucher)
        ->addColumn('amount', function($row){
           
            if(fmod($row["amount"], 1) !== 0.00){
                return "$".number_format($row["amount"],2);  
            } else {
                
                return "$".floatval($row["amount"]);  
            }
        })
        ->addColumn('tax', function($row){
           
            if(fmod($row["tax"], 1) !== 0.00){
                return "$".number_format($row["tax"],2);  
            } else {
                
                return "$".floatval($row["tax"]);  
            }
        })
        ->addColumn('rem_total', function($row){
           
            if(fmod($row["rem_total"], 1) !== 0.00){
                return "$".number_format($row["rem_total"],2);  
            } else {
                
                return "$".floatval($row["rem_total"]);  
            }
        })
        ->addColumn('action', 
        '<a href="javascript:void(0)" id="edit-team"  data-id="{{$id}}" data-voucher_no="{{$voucher_no}}" data-purpose="{{$purpose}}" data-amount="{{$amount}}" data-tax="{{$tax}}" data-rem_total="{{$rem_total}}"><i class="fa fa-pencil"></i></a>
        <a href="{{ route(\'vouchar.DeletAoc\',$id) }}" class="trash"><i class="fa fa-trash"></i></a></li>')
        ->rawColumns(['action'])
        ->make(true);
        
    }

    public function updateVoucher(Request $request)
    { 
       
        if($request->has(['id']) 
        && $inputs=$request->only(['id','voucher_no','amount','tax','purpose','rem_total'])){
            $id=$request->input('id');
            $voucher_no=$request->input('voucher_no');
            $amount=$request->input('amount');
            $tax=$request->input('tax');
            $purpose=$request->input('purpose');
            $rem_total=$request->input('rem_total');
            $data=array('id'=>$id,'voucher_no'=>$voucher_no,'amount'=>$amount,'tax'=>$tax, 'purpose'=>$purpose, 'rem_total'=>$rem_total);
      
            VouchersEntry::where('id',$id)->update($data);
            return redirect()->back()->with('success','Succesfully updated');    
        }else{
           
                return redirect()->back()->withErrors('Invalid Parameters');    
            }    
    } 

    function deleteAoc($id){
        
        $team = VouchersEntry::where('id',$id)->delete();
     
        return redirect()->back()->with('success','Deleted sucessfully');
    }
}
