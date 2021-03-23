<?php
namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DataTables;
use App\Model\DataTreeItem;
use App\dataFinder;
use Validator;
use DB;

class PurchaseController extends Controller
{
    
    function purchaseDataFinder(Request $request){
		if($request->ajax())
        {
			$data = DB::table('data_tree_items')->select('data_tree_items.id','data_tree_items.amount','data_tree_items.created_at As date','data_tree_items.report',
			DB::raw('((data_tree_items.amount)*20)/100 as tax'),DB::raw('((data_tree_items.amount)*80)/100 as cash'))
			->where('status', 2);
			
			if($request->date_from != '' && $request->date_to !=''){
                        // echo 'HERE';
				$date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
				$date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
				$data->whereBetween('data_tree_items.created_at',array($date_from. ' 00:00:00', $date_to . ' 23:59:59'));
			}
			if($request->date_from == '' && $request->date_to !=''){
				//echo 'HERE2';
				$date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
				$data->where('data_tree_items.created_at','<=',$date_to . ' 23:59:59');
			}
			if($request->date_from != '' && $request->date_to ==''){
				//echo 'HERE3';
				$date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
				$data->where('data_tree_items.created_at', '>=',$date_from . ' 00:00:00');
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
			$total = array_sum($arr);

				$totalsale[] = array("created_at"=>$dat->date,"tax"=>$dat->tax ,"report"=>$dat->report ,"cash"=>$dat->cash,"amount"=>$dat->amount ,"total"=>$total);
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
			 ->addColumn('total', function($row){
				 return "$".number_format($row["total"], 2, '.', '');
			 })
			->rawColumns(['sale','commision','action','date','amount'])
			->make(true);     
		}
		return view('SuperadminDashboard.purchase.purchaseDataFinder');
		
    }

  
    function purchaseDataTree(Request $request){
		if($request->ajax())
        {
			$data = DB::table('data_tree_items')->select('data_tree_items.id','data_tree_items.amount','data_tree_items.created_at AS date','data_tree_items.report',
            DB::raw('((data_tree_items.amount)*20)/100 as tax'),DB::raw('((data_tree_items.amount)*80)/100 as cash'))
            ->where('status', 1);
			if($request->date_from != '' && $request->date_to !=''){
                        // echo 'HERE';
				$date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
				$date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
				$data->whereBetween('data_tree_items.created_at',array($date_from. ' 00:00:00', $date_to . ' 23:59:59'));
			}
			if($request->date_from == '' && $request->date_to !=''){
				//echo 'HERE2';
				$date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
				$data->where('data_tree_items.created_at','<=',$date_to . ' 23:59:59');
			}
			if($request->date_from != '' && $request->date_to ==''){
				//echo 'HERE3';
				$date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
				$data->where('data_tree_items.created_at', '>=',$date_from . ' 00:00:00');
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
                    $total = array_sum($arr);
            
                        $totalsale[] = array("date"=>$dat->date ,"tax"=>$dat->tax ,"report"=>$dat->report ,"cash"=>$dat->cash,"amount"=>$dat->amount ,"total"=>$total);
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
                     ->addColumn('total', function($row){
                         return "$".number_format($row["total"], 2, '.', '');
                     })
                    ->rawColumns(['sale','commision','action','date','amount'])
                    ->make(true);  
		}
		return view('SuperadminDashboard.purchase.purchaseDataTree');	
		
    }
   
    public function store(Request $request){
		if($request->type == "datatree_single_entry"){
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
		if($request->type == "datatree_bulk_entry"){
			
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
		if($request->type == "datafinder_single_entry"){
			
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
		
		if($request->type == "datafinder_bulk_entry"){
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
		return redirect()->back()->with('error','Invalid request!!');		
    }  

    function totalPurchasedReport(Request $request){
		if($request->ajax())
        {
			$data = DB::table('data_tree_items')->select('data_tree_items.created_at AS date','data_tree_items.amount','data_tree_items.report AS type',
			DB::raw('((data_tree_items.amount)*20)/100 as tax'),DB::raw('((data_tree_items.amount)*80)/100 as cash'),
		   // DB::raw('(CASE WHEN data_tree_items.status="1" THEN "DataTree" ELSE "DataFinder" END) as type'),
			DB::raw('(CASE WHEN data_tree_items.report="PropertyDetailReport" THEN "PGL-01" WHEN data_tree_items.report="OpenLienReport" THEN "PGL-02" WHEN data_tree_items.report="ForeclosureReport" THEN "PGL-03" WHEN data_tree_items.report="TaxStatusReport" THEN "PGL-04" ELSE "PBGL-05" END) as glCode'),
			DB::raw('(CASE WHEN data_tree_items.report="PropertyDetailReport" THEN "TC-06" WHEN data_tree_items.report="OpenLienReport" THEN "TC-06" WHEN data_tree_items.report="ForeclosureReport" THEN "TC-06" WHEN data_tree_items.report="TaxStatusReport" THEN "TC-06" ELSE "TC-06" END) as taxCode'))
			->get();
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
			$total = array_sum($arr);
				$totalsale[] = array("date"=>$dat->date,"type"=>$dat->type,"cash"=>$dat->cash,"tax"=>$dat->tax,"amount"=>$dat->amount,"glCode"=>$dat->glCode,"taxCode"=>$dat->taxCode,"total"=>$total);
			}

			//dd($total);
			 return DataTables::of($totalsale)
			// ->addColumn('total', function($row){
			//     return "$".number_format($row["total"], 2, '.', '');
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
			->addColumn('total', function($row){
				if(fmod($row["total"], 1) !== 0.00){
					return "$".number_format($row["total"],2);  
				} else {
					
					return "$".floatval($row["total"]);  
				}
			})
			->make(true);
		}
        return view('SuperadminDashboard.purchase.totalPurchasedReport');    
        
    }
}
