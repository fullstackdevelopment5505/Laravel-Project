<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Invoice;
use Validator; 
use App\Customer;
use App\ItemDescriptions;
use DB;

class invoiceController extends Controller
{

    public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a->date);
        $t2 = strtotime($b->date);
        return $t1 - $t2;
    }
    public function addVouchers(Request $request){
        $inputs = $request->only(['voucher_no','voucher_type','amount','gst','total']);
        $validator = Validator::make($inputs,[
            'voucher_no' => 'required',
            'voucher_type' => 'required',
            'gst' => 'required',
            'amount' => 'required|numeric'
        ]);
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
               $data=vouchers::create($inputs);
               return redirect()->back()->with('success','Vouchres added successfully');
        }
    }

    public function invoiceView()
    {

        return view('AccountDashboard.sale.invoices');
    }
    
    function invoiceList(Request $request){
         if(!empty($request->get('date_from_sale')) || !empty($request->get('date_to_sale')))
        {
        $abc = 0;
            $data = DB::table('invoices')->select('invoices.created_at AS date','invoices.invoice_no','invoices.company_name','invoices.discount',
            DB::raw('(invoices.sub_totla) as amount'),
            DB::raw('(invoices.tax) as tax'),
            DB::raw('(invoices.total) as cash'))
            ->where('status','credit');

            if($request->date_from_sale != '' && $request->date_to_sale !=''){
                // echo 'HERE';
                $vou_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_sale'))));
                $vou_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_sale'))));
                $data->whereBetween('invoices.date',array($vou_start_date_from. ' 00:00:00', $vou_start_date_to . ' 23:59:59'));
            }
            if($request->date_from_sale == '' && $request->date_to_sale !=''){
                //echo 'HERE2';
                $vou_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_sale'))));
                $data->where('invoices.date','<=',$vou_start_date_to . ' 23:59:59');
            }
            if($request->date_from_sale != '' && $request->date_to_sale ==''){
                //echo 'HERE3';
                $vou_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_sale'))));
                $data->where('invoices.date', '>=',$vou_start_date_from . ' 00:00:00');
            }
            $data= $data->orderBy('invoices.date','desc')->get();
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
    
                $totalsale[] = array("invoice_no"=>$dat->invoice_no,"company_name"=>$dat->company_name,"date"=>$dat->date , "tax"=>$dat->tax,"discount"=>$dat->discount,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
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
            ->addColumn('discount', function($row){
               
                if(fmod($row["discount"], 1) !== 0.00){
                    return "$".number_format($row["discount"],2);  
                } else {
                    
                    return "$".floatval($row["discount"]);  
                }
            })
            ->addColumn('cash', function($row){
               
                if(fmod($row["cash"], 1) !== 0.00){
                    return "$".number_format($row["cash"],2);  
                } else {
                    
                    return "$".floatval($row["cash"]);  
                }
            })
            ->make(true);
        }
        $data = DB::table('invoices')->select('invoices.created_at AS date','invoices.invoice_no','invoices.company_name','invoices.discount',
        DB::raw('(invoices.sub_totla) as amount'),
        DB::raw('(invoices.tax) as tax'),
        DB::raw('(invoices.total) as cash'))
        ->where('status','credit')->get();
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
    
                $totalsale[] = array("invoice_no"=>$dat->invoice_no,"company_name"=>$dat->company_name,"date"=>$dat->date , "tax"=>$dat->tax,"discount"=>$dat->discount,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
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
        ->addColumn('discount', function($row){
           
            if(fmod($row["discount"], 1) !== 0.00){
                return "$".number_format($row["discount"],2);  
            } else {
                
                return "$".floatval($row["discount"]);  
            }
        })
        ->addColumn('cash', function($row){
           
            if(fmod($row["cash"], 1) !== 0.00){
                return "$".number_format($row["cash"],2);  
            } else {
                
                return "$".floatval($row["cash"]);  
            }
        })
        ->make(true);
}

public function addInvoice(Request $request)
{
    $inputs = $request->only(['company_name','session','bill_type','address','gstin','date','invoice_prefix','rec_name',
    'rec_address','rec_state','rec_state_code','rec_gstin','con_name','con_address','con_state','con_state_code','con_gstin','sub_total',
    'tax','discount','finalamount']);

    $validator = Validator::make($inputs,[       
        'company_name' => 'required',
        'session' => 'required',
        'bill_type' => 'required',
        'address' => 'required',
        'gstin' => 'required',
     //   'date' => 'required',
        'invoice_prefix' => 'required',
        'rec_name' => 'required',
         'rec_address' => 'required',
         'rec_state' => 'required',
         'rec_state_code' => 'required',
         'rec_gstin' => 'required',
         'con_name' => 'required',
         'con_address' => 'required',
         'con_state' => 'required',
        'con_state_code' => 'required',
         'con_gstin' => 'required',
         'tax' => 'required',
         'discount' => 'required'
    ]);
 
    if($validator->fails()){
        $errorMessages = $validator->messages()->toArray();
        return redirect()->back()->with('error','Invalid inputs');
    }
    else{
        
        $data =  Invoice::select('invoice_no')->where('status','credit')->orderBy('id','desc')->first();

        $arr = explode("-",$data->invoice_no); 
        $invoice_integer_val[] =  (int) $arr[1];
        $invoice_max_val = max($invoice_integer_val);

        $invoice_no="#INV-".($invoice_max_val+1);
        
        $date = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date'))));
      

        $data=array(
           
            'invoice_no'=>$invoice_no,
            'company_name'=>$request->get('company_name'),
            'session'=>$request->get('session'),
            'bill_type'=>$request->get('bill_type'),
            'address'=>$request->get('address'),
            'gstin'=>$request->get('gstin'),  
            'date'=>$date,
            'invoice_prefix'=>$request->get('invoice_prefix'),
            'rec_name'=>$request->get('rec_name'),
            'rec_address'=>$request->get('rec_address'),
            'rec_state'=>$request->get('rec_state'),
            'rec_state_code'=>$request->get('rec_state_code'),
            'rec_gstin'=>$request->get('rec_gstin'),
            'con_name'=>$request->get('con_name'),
            'con_address'=>$request->get('con_address'),  
            'con_state'=>$request->get('con_state'),
            'con_state_code'=>$request->get('con_state_code'),
            'con_gstin'=>$request-> get('con_gstin'),
            'sub_totla'=>$request->get('sub_totla'),  
            'tax'=>$request->get('tax'),
            'discount'=>$request->get('discount'),
            'total'=>$request->get('finalamount'),
            'sub_totla'=>$request->get('sub_total'),

            'status'=>"credit"
        );

           $data=Invoice::create($data);
          
           if($data==true)
           {
           $data = $request->all();
            $invoice_no= $invoice_no;
           $item = $data['item_name'];
           $description = $data['item_description'];
           $cost = $data['unit_cost'];
           $quantity = $data['quantity'];
           $amount = $data['amount'];
            foreach ($item as $key => $input) {
               $arr = [];
                
                $arr['invoice_no'] = $invoice_no;

                $arr['item_name'] = isset($item[$key]) ? $item[$key] : '';
                $arr['item_description'] = isset($description[$key]) ? $description[$key] : '';
                $arr['unit_cost'] = isset($cost[$key]) ? $cost[$key] : '';
                $arr['quantity'] = isset($quantity[$key]) ? $quantity[$key] : '';
                $arr['amount'] = isset($amount[$key]) ? $amount[$key] : '';
                ItemDescriptions::insert($arr);  
                }

           }
           return redirect()->back()->with('success','invoice added successfully');
        }   
    }

    public function PurchaseinvoiceView()
    {
        return view('AccountDashboard.purchase.invoices');
    }
    
    function PurchaseinvoiceList(request $request){
        if(!empty($request->get('date_from_purchase')) || !empty($request->get('date_to_purchase')))
        {
           
            $abc = 0;
            $data = DB::table('invoices')->select('invoices.created_at AS date','invoices.invoice_no','invoices.company_name','invoices.discount',
            DB::raw('(invoices.sub_totla) as amount'),
            DB::raw('(invoices.tax) as tax'),
            DB::raw('(invoices.total) as cash'))
            ->where('status','debit');

            if($request->date_from_purchase != '' && $request->date_to_purchase !=''){
                // echo 'HERE';
                $vou_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                $vou_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                $data->whereBetween('invoices.date',array($vou_start_date_from. ' 00:00:00', $vou_start_date_to . ' 23:59:59'));
            }
            if($request->date_from_purchase == '' && $request->date_to_purchase !=''){
                //echo 'HERE2';
                $vou_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                $data->where('invoices.date','<=',$vou_start_date_to . ' 23:59:59');
            }
            if($request->date_from_purchase != '' && $request->date_to_purchase ==''){
                //echo 'HERE3';
                $vou_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                $data->where('invoices.date', '>=',$vou_start_date_from . ' 00:00:00');
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
    
                $totalsale[] = array("invoice_no"=>$dat->invoice_no,"company_name"=>$dat->company_name,"date"=>$dat->date , "tax"=>$dat->tax,"discount"=>$dat->discount,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
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
            ->addColumn('discount', function($row){
               
                if(fmod($row["discount"], 1) !== 0.00){
                    return "$".number_format($row["discount"],2);  
                } else {
                    
                    return "$".floatval($row["discount"]);  
                }
            })
            ->addColumn('cash', function($row){
               
                if(fmod($row["cash"], 1) !== 0.00){
                    return "$".number_format($row["cash"],2);  
                } else {
                    
                    return "$".floatval($row["cash"]);  
                }
            })
            ->make(true);
        }
        $data = DB::table('invoices')->select('invoices.created_at AS date','invoices.invoice_no','invoices.company_name','invoices.discount',
        DB::raw('(invoices.sub_totla) as amount'),
        DB::raw('(invoices.tax) as tax'),
        DB::raw('(invoices.total) as cash'))
        ->where('status','debit')->get();
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
    
                $totalsale[] = array("invoice_no"=>$dat->invoice_no,"company_name"=>$dat->company_name,"date"=>$dat->date , "tax"=>$dat->tax,"discount"=>$dat->discount,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
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
        ->addColumn('discount', function($row){
           
            if(fmod($row["discount"], 1) !== 0.00){
                return "$".number_format($row["discount"],2);  
            } else {
                
                return "$".floatval($row["discount"]);  
            }
        })
        ->addColumn('cash', function($row){
           
            if(fmod($row["cash"], 1) !== 0.00){
                return "$".number_format($row["cash"],2);  
            } else {
                
                return "$".floatval($row["cash"]);  
            }
        })
        ->make(true);
}
    public function addPurchaseInvoice(Request $request)
        {
            $inputs = $request->all(['company_name','session','bill_type','address','gstin','date','invoice_prefix','rec_name',
            'rec_address','rec_state','rec_state_code','rec_gstin','con_name','con_address','con_state','con_state_code','con_gstin','sub_total',
            'tax','discount','finalamount']);
            
            $validator = Validator::make($inputs,[       
                'company_name' => 'required',
                'session' => 'required',
                'bill_type' => 'required',
                'address' => 'required',
                'gstin' => 'required',
            //   'date' => 'required',
                'invoice_prefix' => 'required',
                'rec_name' => 'required',
                'rec_address' => 'required',
                'rec_state' => 'required',
                'rec_state_code' => 'required',
                'rec_gstin' => 'required',
                'con_name' => 'required',
                'con_address' => 'required',
                'con_state' => 'required',
                'con_state_code' => 'required',
                'con_gstin' => 'required',
                'tax' => 'required',
                'discount' => 'required'
            ]);
        
            if($validator->fails()){
                $errorMessages = $validator->messages()->toArray();
                return redirect()->back()->with('error','Invalid inputs');
            }
            else{
            
   
                $data =  Invoice::select('invoice_no')->where('status','debit')->orderBy('id','desc')->first();

                $arr = explode("-",$data->invoice_no); 
                $invoice_integer_val[] =  (int) $arr[1];
                $invoice_max_val = max($invoice_integer_val);
        
                $invoice_no="#INV-".($invoice_max_val+1);
                //dd($inputs);
                $date = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date'))));
               //dd($date);
                
                $data=array(
                
                    'invoice_no'=>$invoice_no,
                    'company_name'=>$request->get('company_name'),
                    'session'=>$request->get('session'),
                    'bill_type'=>$request->get('bill_type'),
                    'address'=>$request->get('address'),
                    'gstin'=>$request->get('gstin'),  
                    'date'=>$date,
                    'invoice_prefix'=>$request->get('invoice_prefix'),
                    'rec_name'=>$request->get('rec_name'),
                    'rec_address'=>$request->get('rec_address'),
                    'rec_state'=>$request->get('rec_state'),
                    'rec_state_code'=>$request->get('rec_state_code'),
                    'rec_gstin'=>$request->get('rec_gstin'),
                    'con_name'=>$request->get('con_name'),
                    'con_address'=>$request->get('con_address'),  
                    'con_state'=>$request->get('con_state'),
                    'con_state_code'=>$request->get('con_state_code'),
                    'con_gstin'=>$request-> get('con_gstin'),
                    'sub_totla'=>$request->get('sub_totla'),  
                    'tax'=>$request->get('tax'),
                    'discount'=>$request->get('discount'),
                    'total'=>$request->get('finalamount'),
                    'sub_totla'=>$request->get('sub_total'),

                    'status'=>"debit"
                );

                $data=Invoice::create($data);
                
                if($data==true)
                {
                $data = $request->all();
                    $invoice_no= $invoice_no;
                $item = $data['item_name'];
                $description = $data['item_description'];
                $cost = $data['unit_cost'];
                $quantity = $data['quantity'];
                $amount = $data['amount'];
                    foreach ($item as $key => $input) {
                    $arr = [];
                        
                        $arr['invoice_no'] = $invoice_no;

                        $arr['item_name'] = isset($item[$key]) ? $item[$key] : '';
                        $arr['item_description'] = isset($description[$key]) ? $description[$key] : '';
                        $arr['unit_cost'] = isset($cost[$key]) ? $cost[$key] : '';
                        $arr['quantity'] = isset($quantity[$key]) ? $quantity[$key] : '';
                        $arr['amount'] = isset($amount[$key]) ? $amount[$key] : '';
                        ItemDescriptions::insert($arr);
                        }
                }
                return redirect()->back()->with('success','invoice added successfully');
                }   
            }

    public function create()
    {
        $items = Customer::all(['id', 'name']);
     
        return View::make('AccountDashboard.sale.invoices', compact('items'));
        
    }
   													
 

}


