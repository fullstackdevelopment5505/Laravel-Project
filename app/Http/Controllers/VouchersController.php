<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\VouchersEntry;
use Validator;
use DataTables;
use DB;

class VouchersController extends Controller
{
	
	  public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a->date);
        $t2 = strtotime($b->date);
        return $t1 - $t2;
    } 
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
          $data =  VouchersEntry::select('voucher_no')->where('status','Credit')->orderBy('id','desc')->first();

            $arr = explode("-",$data->voucher_no); 
            $voucher_integer_val[] =  (int) $arr[1];
            $voucher_max_val = max($voucher_integer_val);

            $voucher_no="#VOU-".($voucher_max_val+1);
    
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
        return view('AccountDashboard.sale.vouchers');
    }
    
        function SalevoucherList(request $request){
        if(!empty($request->get('date_from_purchase')) || !empty($request->get('date_to_purchase')))
        {
           
            $abc = 0;
            $data = DB::table('vouchers_entries')->select('vouchers_entries.created_at AS date','vouchers_entries.voucher_no',
            'vouchers_entries.purpose','vouchers_entries.id',
            DB::raw('(vouchers_entries.amount) as amount'),
            DB::raw('(vouchers_entries.tax) as tax'),
            DB::raw('(vouchers_entries.rem_total) as cash'))
            ->where('status','Credit');

            if($request->date_from_purchase != '' && $request->date_to_purchase !=''){
                // echo 'HERE';
                $vou_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                $vou_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                $data->whereBetween('vouchers_entries.created_at',array($vou_start_date_from. ' 00:00:00', $vou_start_date_to . ' 23:59:59'));
            }
            if($request->date_from_purchase == '' && $request->date_to_purchase !=''){
                //echo 'HERE2';
                $vou_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                $data->where('vouchers_entries.created_at','<=',$vou_start_date_to . ' 23:59:59');
            }
            if($request->date_from_purchase != '' && $request->date_to_purchase ==''){
                //echo 'HERE3';
                $vou_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                $data->where('vouchers_entries.created_at', '>=',$vou_start_date_from . ' 00:00:00');
            }
            $data= $data->get();
            $totalsale      =       array();
                $data1 =$data->toarray();
                $onlyAmout      =     array_column($data1, 'cash');
                    usort($data1,array($this, "date_compare")); //sort userdefined array by date
                foreach($data1 as $key => $dat){
                    $arr = [];
                    foreach($onlyAmout as $k => $dats){
                    if($k<=$key){
                        array_push($arr,$dats);
        
                    }
                }
                $abc = array_sum($arr);

                $totalsale[] = array("id"=>$dat->id,"purpose"=>$dat->purpose,"voucher_no"=>$dat->voucher_no,"date"=>$dat->date , "tax"=>$dat->tax,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
            }
                return DataTables::of($totalsale)
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
                ->addColumn('cash', function($row){
            
                if(fmod($row["cash"], 1) !== 0.00){
                    return "$".number_format($row["cash"],2);  
                } else {
                    
                    return "$".floatval($row["cash"]);  
                }
            })
            ->addColumn('action', 
            '<a href="javascript:void(0)" id="edit-team"  data-id="{{$id}}" data-voucher_no="{{$voucher_no}}" data-purpose="{{$purpose}}" data-amount="{{$amount}}" data-tax="{{$tax}}" data-cash="{{$cash}}" ><i class="fa fa-pencil"></i></a>
        <a href="{{ route(\'vouchar.DeletAoc\',$id) }}" class="trash"><i class="fa fa-trash"></i></a></li>')
            ->rawColumns(['action'])
            ->make(true); 
        }
    $data = DB::table('vouchers_entries')->select('vouchers_entries.created_at AS date','vouchers_entries.voucher_no','vouchers_entries.purpose','vouchers_entries.id',
    DB::raw('(vouchers_entries.amount) as amount'),
    DB::raw('(vouchers_entries.tax) as tax'),
    DB::raw('(vouchers_entries.rem_total) as cash'))
    ->where('status','Credit')->get();
 
    $abc = 0;
        $totalsale      =       array();
        $data1 =$data->toarray();
        $onlyAmout      =     array_column($data1, 'cash');
            usort($data1,array($this, "date_compare")); //sort userdefined array by date
        foreach($data1 as $key => $dat){
            $arr = [];
            foreach($onlyAmout as $k => $dats){
            if($k<=$key){
                array_push($arr,$dats);

            }
        }
        $abc = array_sum($arr);

            $totalsale[] = array("id"=>$dat->id,"purpose"=>$dat->purpose,"voucher_no"=>$dat->voucher_no,"date"=>$dat->date , "tax"=>$dat->tax,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
        }
        //dd($totalsale);
        return DataTables::of($totalsale)
       
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
        ->addColumn('cash', function($row){
           
            if(fmod($row["cash"], 1) !== 0.00){
                return "$".number_format($row["cash"],2);  
            } else {
                
                return "$".floatval($row["cash"]);  
            }
        })
        ->addColumn('action', 
        '<a href="javascript:void(0)" id="edit-team"  data-id="{{$id}}" data-voucher_no="{{$voucher_no}}" data-purpose="{{$purpose}}" data-amount="{{$amount}}" data-tax="{{$tax}}" data-cash="{{$cash}}" ><i class="fa fa-pencil"></i></a>
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
            $data =  VouchersEntry::select('voucher_no')->where('status','Debit')->orderBy('id','desc')->first();

            $arr = explode("-",$data->voucher_no); 
            $voucher_integer_val[] =  (int) $arr[1];
            $voucher_max_val = max($voucher_integer_val);

            $voucher_no="#VOU-".($voucher_max_val+1);
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
        return view('AccountDashboard.purchase.vouchers');
    }
    
     function PurchasevoucherList(Request $request)
    {
        if(!empty($request->get('date_from_purchase')) || !empty($request->get('date_to_purchase')))
        {
           
            $abc = 0;
            $data = DB::table('vouchers_entries')->select('vouchers_entries.created_at AS date','vouchers_entries.voucher_no',
            'vouchers_entries.purpose','vouchers_entries.id',
            DB::raw('(vouchers_entries.amount) as amount'),
            DB::raw('(vouchers_entries.tax) as tax'),
            DB::raw('(vouchers_entries.rem_total) as cash'))
            ->where('status','Debit');

            if($request->date_from_purchase != '' && $request->date_to_purchase !=''){
                // echo 'HERE';
                $vou_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                $vou_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                $data->whereBetween('vouchers_entries.created_at',array($vou_start_date_from. ' 00:00:00', $vou_start_date_to . ' 23:59:59'));
            }
            if($request->date_from_purchase == '' && $request->date_to_purchase !=''){
                //echo 'HERE2';
                $vou_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                $data->where('vouchers_entries.created_at','<=',$vou_start_date_to . ' 23:59:59');
            }
            if($request->date_from_purchase != '' && $request->date_to_purchase ==''){
                //echo 'HERE3';
                $vou_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                $data->where('vouchers_entries.created_at', '>=',$vou_start_date_from . ' 00:00:00');
            }
            $data= $data->get();
            $totalsale      =       array();
                $data1 =$data->toarray();
                $onlyAmout      =     array_column($data1, 'cash');
                    usort($data1,array($this, "date_compare")); //sort userdefined array by date
                foreach($data1 as $key => $dat){
                    $arr = [];
                    foreach($onlyAmout as $k => $dats){
                    if($k<=$key){
                        array_push($arr,$dats);
        
                    }
                }
                $abc = array_sum($arr);

                $totalsale[] = array("id"=>$dat->id,"purpose"=>$dat->purpose,"voucher_no"=>$dat->voucher_no,"date"=>$dat->date , "tax"=>$dat->tax,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
            }
                return DataTables::of($totalsale)
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
                ->addColumn('cash', function($row){
            
                if(fmod($row["cash"], 1) !== 0.00){
                    return "$".number_format($row["cash"],2);  
                } else {
                    
                    return "$".floatval($row["cash"]);  
                }
            })
            ->addColumn('action', 
            '<a href="javascript:void(0)" id="edit-team"  data-id="{{$id}}" data-voucher_no="{{$voucher_no}}" data-purpose="{{$purpose}}" data-amount="{{$amount}}" data-tax="{{$tax}}" data-cash="{{$cash}}" ><i class="fa fa-pencil"></i></a>
        <a href="{{ route(\'vouchar.DeletAoc\',$id) }}" class="trash"><i class="fa fa-trash"></i></a></li>')
            ->rawColumns(['action'])
            ->make(true); 
        }
    $data = DB::table('vouchers_entries')->select('vouchers_entries.created_at AS date','vouchers_entries.voucher_no','vouchers_entries.purpose','vouchers_entries.id',
    DB::raw('(vouchers_entries.amount) as amount'),
    DB::raw('(vouchers_entries.tax) as tax'),
    DB::raw('(vouchers_entries.rem_total) as cash'))
    ->where('status','Debit')->get();
    $abc = 0;
        $totalsale      =       array();
        $data1 =$data->toarray();
        $onlyAmout      =     array_column($data1, 'cash');
            usort($data1,array($this, "date_compare")); //sort userdefined array by date
        foreach($data1 as $key => $dat){
            $arr = [];
            foreach($onlyAmout as $k => $dats){
            if($k<=$key){
                array_push($arr,$dats);

            }
        }
        $abc = array_sum($arr);

            $totalsale[] = array("id"=>$dat->id,"purpose"=>$dat->purpose,"voucher_no"=>$dat->voucher_no,"date"=>$dat->date , "tax"=>$dat->tax,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
        }
        //dd($totalsale);
        return DataTables::of($totalsale)
       
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
        ->addColumn('cash', function($row){
           
            if(fmod($row["cash"], 1) !== 0.00){
                return "$".number_format($row["cash"],2);  
            } else {
                
                return "$".floatval($row["cash"]);  
            }
        })
        ->addColumn('action', 
        '<a href="javascript:void(0)" id="edit-team"  data-id="{{$id}}" data-voucher_no="{{$voucher_no}}" data-purpose="{{$purpose}}" data-amount="{{$amount}}" data-tax="{{$tax}}" data-cash="{{$cash}}" ><i class="fa fa-pencil"></i></a>
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
            //dd($data);
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
