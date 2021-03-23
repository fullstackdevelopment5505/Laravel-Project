<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use DataTables;
use App\Model\DataTreeItem;
use App\dataFinder;
use Validator;
use DB;

class purchaseController extends Controller
{
    public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a->date);
        $t2 = strtotime($b->date);
        return $t1 - $t2;
    }   

    public function purdatafinlder()
    {
        return view('AccountDashboard.purchase.purchaseDatafinder');
    }

    function purchaseDataFinder(Request $request){

        if(!empty($request->get('date_from_purchase')) || !empty($request->get('date_to_purchase')))
        {
            $data = DB::table('data_tree_items')->select('data_tree_items.id','data_tree_items.amount','data_tree_items.created_at AS date','data_tree_items.report',
            DB::raw('((data_tree_items.amount)*20)/100 as tax'),DB::raw('((data_tree_items.amount)*80)/100 as cash'))
            ->where('status', 2);
                                    

                    if($request->date_from_purchase != '' && $request->date_to_purchase !=''){
                        // echo 'HERE';
                        $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                        $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                        $data->whereBetween('data_tree_items.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                    }
                    if($request->date_from_purchase == '' && $request->date_to_purchase !=''){
                        //echo 'HERE2';
                        $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                        $data->where('data_tree_items.created_at','<=',$membership_start_date_to . ' 23:59:59');
                    }
                    if($request->date_from_purchase != '' && $request->date_to_purchase ==''){
                        //echo 'HERE3';
                        $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                        $data->where('data_tree_items.created_at', '>=',$membership_start_date_from . ' 00:00:00');
                    }
                    $data= $data->orderBy('date','desc')->get();


                    $totalsale      =       array();
                    $data1 =$data->toarray();
                    $onlyAmout      =     array_column($data1, 'cash');
                    foreach($data as $key => $dat){
                        $arr = [];
                        foreach($onlyAmout as $k => $dats){
                        if($k<=$key){
                            array_push($arr,$dats);
            
                        }
                    }
                    $abc = array_sum($arr);
            
                        $totalsale[] = array("date"=>$dat->date ,"tax"=>$dat->tax ,"report"=>$dat->report ,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
                    }
                    return DataTables::of($totalsale)
                    ->addColumn('amount', function($row){
                        return "$".number_format($row["amount"], 2, '.', '');   
                     })
                     ->addColumn('tax', function($row){
                        return "$".number_format($row["tax"], 2, '.', ''); 
                     })
                     ->addColumn('cash', function($row){
                        return "$".number_format($row["cash"], 2, '.', ''); 
                     })
                     ->addColumn('abc', function($row){
                         return "$".number_format($row["abc"], 2, '.', '');
                     })
                    ->rawColumns(['sale','commision','action','created_at','amount'])
                    ->make(true);             
                }
        $data = DB::table('data_tree_items')->select('data_tree_items.id','data_tree_items.amount','data_tree_items.created_at AS date','data_tree_items.report',
        DB::raw('((data_tree_items.amount)*20)/100 as tax'),DB::raw('((data_tree_items.amount)*80)/100 as cash'))
        ->where('status', 2)->get();
        $totalsale      =       array();
        $data1 =$data->toarray();
        $onlyAmout      =     array_column($data1, 'cash');
        foreach($data as $key => $dat){
            $arr = [];
            foreach($onlyAmout as $k => $dats){
            if($k<=$key){
                array_push($arr,$dats);

            }
        }
        $abc = array_sum($arr);

            $totalsale[] = array("date"=>$dat->date ,"tax"=>$dat->tax ,"report"=>$dat->report ,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
        }
        return DataTables::of($totalsale)
        ->addColumn('amount', function($row){
            return "$".number_format($row["amount"], 2, '.', '');   
         })
         ->addColumn('tax', function($row){
            return "$".number_format($row["tax"], 2, '.', ''); 
         })
         ->addColumn('cash', function($row){
            return "$".number_format($row["cash"], 2, '.', ''); 
         })
         ->addColumn('abc', function($row){
             return "$".number_format($row["abc"], 2, '.', '');
         })
        ->rawColumns(['sale','commision','action','created_at','amount'])
        ->make(true);       
    }

    public function purdatatree()
    {
        return view('AccountDashboard.purchase.purchaseDatatree');
    }

    function purchaseDataTree(Request $request){

        if(!empty($request->get('date_from_purchase')) || !empty($request->get('date_to_purchase')))
        {
            $data = DB::table('data_tree_items')->select('data_tree_items.id','data_tree_items.amount','data_tree_items.created_at AS date','data_tree_items.report',
            DB::raw('((data_tree_items.amount)*20)/100 as tax'),DB::raw('((data_tree_items.amount)*80)/100 as cash'))
            ->where('status', 1);
                                    

                    if($request->date_from_purchase != '' && $request->date_to_purchase !=''){
                        // echo 'HERE';
                        $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                        $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                        $data->whereBetween('data_tree_items.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                    }
                    if($request->date_from_purchase == '' && $request->date_to_purchase !=''){
                        //echo 'HERE2';
                        $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                        $data->where('data_tree_items.created_at','<=',$membership_start_date_to . ' 23:59:59');
                    }
                    if($request->date_from_purchase != '' && $request->date_to_purchase ==''){
                        //echo 'HERE3';
                        $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                        $data->where('data_tree_items.created_at', '>=',$membership_start_date_from . ' 00:00:00');
                    }
                    $data= $data->orderBy('date','desc')->get();


                    $totalsale      =       array();
                    $data1 =$data->toarray();
                    $onlyAmout      =     array_column($data1, 'cash');
                    foreach($data as $key => $dat){
                        $arr = [];
                        foreach($onlyAmout as $k => $dats){
                        if($k<=$key){
                            array_push($arr,$dats);
            
                        }
                    }
                    $abc = array_sum($arr);
            
                        $totalsale[] = array("date"=>$dat->date ,"tax"=>$dat->tax ,"report"=>$dat->report ,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
                    }
                    return DataTables::of($totalsale)
                    ->addColumn('amount', function($row){
                        return "$".number_format($row["amount"], 2, '.', '');   
                     })
                     ->addColumn('tax', function($row){
                        return "$".number_format($row["tax"], 2, '.', ''); 
                     })
                     ->addColumn('cash', function($row){
                        return "$".number_format($row["cash"], 2, '.', ''); 
                     })
                     ->addColumn('abc', function($row){
                         return "$".number_format($row["abc"], 2, '.', '');
                     })
                    ->rawColumns(['sale','commision','action','created_at','amount'])
                    ->make(true);             
                }
        $data = DB::table('data_tree_items')->select('data_tree_items.id','data_tree_items.amount','data_tree_items.created_at AS date','data_tree_items.report',
        DB::raw('((data_tree_items.amount)*20)/100 as tax'),DB::raw('((data_tree_items.amount)*80)/100 as cash'))
        ->where('status', 1)->get();
        $totalsale      =       array();
        $data1 =$data->toarray();
        $onlyAmout      =     array_column($data1, 'cash');
        foreach($data as $key => $dat){
            $arr = [];
            foreach($onlyAmout as $k => $dats){
            if($k<=$key){
                array_push($arr,$dats);

            }
        }
        $abc = array_sum($arr);

            $totalsale[] = array("date"=>$dat->date ,"tax"=>$dat->tax ,"report"=>$dat->report ,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
        }
        return DataTables::of($totalsale)
        ->addColumn('amount', function($row){
            return "$".number_format($row["amount"], 2, '.', '');   
         })
         ->addColumn('tax', function($row){
            return "$".number_format($row["tax"], 2, '.', ''); 
         })
         ->addColumn('cash', function($row){
            return "$".number_format($row["cash"], 2, '.', ''); 
         })
         ->addColumn('abc', function($row){
             return "$".number_format($row["abc"], 2, '.', '');
         })
        ->rawColumns(['sale','commision','action','created_at','amount'])
        ->make(true);   
    }
   
    public function AddDatatree(Request $request){
        $gl = 'GL-101';//ok
            $inputs = $request->only(['amount','entry_user_id','batch_no','brand','report','qty']);
            $newAmout = explode('&',$inputs['report']);
        $validator = Validator::make($inputs,[
            'amount' => 'required',
            'batch_no' => 'required',
            'brand' => 'required',
            'qty'=>'required'
        ]);
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            $data=DataTreeItem::create([
                
                'amount' => $request->get('amount'),
                'entry_user_id' => $request->get('entry_user_id'),
                'batch_no' => $request->get('batch_no'),
                'brand' => $request->get('brand'),
                'qty' => $request->get('qty'),
                'gl_code' => $newAmout[1],
                'report'=>$newAmout[2],
                'status'=>1
            ]);
           return redirect()->back()->with('success','Records added successfully');
        }   
    }  

    public function AddBulkReport(Request $request){
        $gl = 'GL-101';//ok
            $inputs = $request->only(['amount','batch_no','brand','report']);
            $newAmout = explode('&',$inputs['report']);
        $validator = Validator::make($inputs,[
            'amount' => 'required',
            'batch_no' => 'required',
            'brand' => 'required'
        ]);
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            $data=DataTreeItem::create([
                'amount' => $request->get('amount'),
                
                'batch_no' => $request->get('batch_no'),
                'brand' => $request->get('brand'),
               
                'gl_code' => $newAmout[0],
                'report'=>$newAmout[1],
                'status'=>1
            ]);
           return redirect()->back()->with('success','Records added successfully');
        }   
    } 

    public function AddDataFinder(Request $request){
        $gl = 'GL-101';//ok
            $inputs = $request->only(['amount','entry_user_id','batch_no','brand','report','qty']);
            $newAmout = explode('&',$inputs['report']);
        $validator = Validator::make($inputs,[
            'amount' => 'required',
            'batch_no' => 'required',
            'brand' => 'required',
            'qty'=>'required'
        ]);
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            $data=DataTreeItem::create([
                
                'amount' => $request->get('amount'),
                'entry_user_id' => $request->get('entry_user_id'),
                'batch_no' => $request->get('batch_no'),
                'brand' => $request->get('brand'),
                'qty' => $request->get('qty'),
                'gl_code' => $newAmout[1],
                'report'=>$newAmout[2],
                'status'=>2
            ]);
           return redirect()->back()->with('success','Records added successfully');
        }   
    }  

    public function AddDataFinderBulk(Request $request){
        $gl = 'GL-101';//ok
            $inputs = $request->only(['amount','batch_no','brand','report']);
            $newAmout = explode('&',$inputs['report']);
        $validator = Validator::make($inputs,[
            'amount' => 'required',
            'batch_no' => 'required',
            'brand' => 'required'
        ]);
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            $data=DataTreeItem::create([
                'amount' => $request->get('amount'),
                
                'batch_no' => $request->get('batch_no'),
                'brand' => $request->get('brand'),
               
                'gl_code' => $newAmout[0],
                'report'=>$newAmout[1],
                'status'=>2
            ]);
           return redirect()->back()->with('success','Records added successfully');
        }   
    } 
    
    
    public function PurchaseReportList()
    {
        return view('AccountDashboard.purchase.totalPurchasedReports');
    }
    function purchasedRecord(){
        $data = DB::table('data_tree_items')->select('data_tree_items.created_at AS date','data_tree_items.amount','data_tree_items.report AS type',
        DB::raw('((data_tree_items.amount)*20)/100 as tax'),DB::raw('((data_tree_items.amount)*80)/100 as cash'),
       // DB::raw('(CASE WHEN data_tree_items.status="1" THEN "DataTree" ELSE "DataFinder" END) as type'),
        DB::raw('(CASE WHEN data_tree_items.report="PropertyDetailReport" THEN "PGL-01" WHEN data_tree_items.report="OpenLienReport" THEN "PGL-02" WHEN data_tree_items.report="ForeclosureReport" THEN "PGL-03" WHEN data_tree_items.report="TaxStatusReport" THEN "PGL-04" ELSE "PBGL-09" END) as glCode'),
        DB::raw('(CASE WHEN data_tree_items.report="PropertyDetailReport" THEN "TC-06" WHEN data_tree_items.report="OpenLienReport" THEN "TC-06" WHEN data_tree_items.report="ForeclosureReport" THEN "TC-06" WHEN data_tree_items.report="TaxStatusReport" THEN "TC-06" ELSE "TC-06" END) as taxCode'))
        ->get();
		
        $data1 = DB::table('vouchers_entries')
        ->select('vouchers_entries.id AS tb_id','vouchers_entries.created_at AS date',
        DB::raw('(vouchers_entries.amount) as amount'),DB::raw('(vouchers_entries.tax) as tax'),DB::raw('(vouchers_entries.rem_total) as cash'), 
        DB::raw('(CASE WHEN vouchers_entries.status="Debit" THEN "TC-07" END) as taxCode'),
        DB::raw('(CASE WHEN vouchers_entries.status="Debit" THEN "Vouchar Purchase " END) as type'),
        DB::raw('(CASE WHEN vouchers_entries.status="Debit" THEN "PGL-07" END) as glCode'))->where('status','Debit');

         $res = $data1->get();
		 
		 

         $data2 = DB::table('invoices')->select('invoices.created_at AS date',
         DB::raw('(invoices.sub_totla) as amount'),
         DB::raw('(invoices.tax) as tax'),
         DB::raw('(invoices.total) as cash'),
         DB::raw('(CASE WHEN invoices.status="debit" THEN "TC-08" END) as taxCode'),
         DB::raw('(CASE WHEN invoices.status="debit" THEN "Invoice Purchase " END) as type'),
         DB::raw('(CASE WHEN invoices.status="debit" THEN "PGL-08" END) as glCode'))
         ->where('status','debit')->get();

         $totdata = array_merge($res->toArray(), $data->toArray(), $data2->toArray());
       
         usort($totdata,array($this, "date_compare")); //sort userdefined array by date
 
         //echo "<pre>"; print_r($totdata); die;
         $totalsale      =       array();
         $onlyAmount      =       array_column($totdata, 'cash');
       // echo "<pre>"; print_r($onlyAmount); die;

         foreach($totdata as $key => $dat){
            $arr = [];
            foreach($onlyAmount as $k => $dats){
            if($k<=$key){
                array_push($arr,$dats);

            }
        }
        $abc = array_sum($arr);
            $totalsale[] = array("date"=>$dat->date,"type"=>$dat->type,"cash"=>$dat->cash,"tax"=>$dat->tax,"amount"=>$dat->amount,"glCode"=>$dat->glCode,"taxCode"=>$dat->taxCode,"abc"=>$abc);
        }

        //dd($abc);
         return DataTables::of($totalsale)
        // ->addColumn('abc', function($row){
        //     return "$".number_format($row["abc"], 2, '.', '');
        // })
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
                
                return "$ ".floatval($row["cash"]);  
            }
        })
        ->addColumn('abc', function($row){
            if(fmod($row["abc"], 1) !== 0.00){
                return "$".number_format($row["abc"],2);  
            } else {
                
                return "$".floatval($row["abc"]);  
            }
        })
        ->make(true);

             
        
    }
}
