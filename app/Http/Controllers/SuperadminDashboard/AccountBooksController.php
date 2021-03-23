<?php
namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\JournalLeadger;
use App\User;
use App\Model\AccountChart;
use App\Model\DataTreeItem;
use App\dataFinder;
use App\Model\Deposite;
use App\Model\Points;
use App\Model\Report;
use DB, DataTables, Validator;

class AccountBooksController extends Controller
{
    public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a["created_at"]);
        $t2 = strtotime($b["created_at"]);
        return $t1 - $t2;
    } 
	
	
	
	function accountChart(Request $request){
        if($request->ajax())
        {
			$AccountChart = AccountChart::select('*')->orderBy("created_at","desc");
		  
			return DataTables::of($AccountChart)
			->addColumn('action', 
			'<a href="javascript:void(0)" id="edit-team"  data-id={{$id}} data-account_type={{$account_type}} data-title={{$title}} data-type={{$type}}><i class="fa fa-pencil"></i></a>
			<a href="{{ route(\'superadminAccountBooksDeleteAccChart\',$id) }}" class="trash"><i class="fa fa-trash"></i></a></li>')
			->rawColumns(['action'])
			->make(true);
		}
		return view('SuperadminDashboard.accountBooks.accountChart');
    }
	
	function generalLedger(Request $request){
		if($request->ajax())
        {
			$original = DataTreeItem::get();
			$latest = Deposite::get();
			$trans =Report::with('point')->get();
		
			$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();
			 $data = array_merge($original->toArray(), $latest->toArray(), $trans->toArray());
			usort($data,array($this, "date_compare"));
			$ledger = array();
			foreach( $data as $key => $value){
				
				if(array_key_exists("id", $data[$key]))
				{
					if(array_key_exists("point", $data[$key])){
						$dollar_rate    =   $pointRate->point_per_dollar;
						$point          =   $data[$key]["point"]["point"];
						$amount         =   $point/$dollar_rate;
						$ledger[]       =   array('amount' => $amount, 'paymnent_method' => "-", 
											'date' => $data[$key]["created_at"], 'type' => 'Revenue');
					}else{
						$ledger[]= array('amount' => $data[$key]["amount"], 'paymnent_method' => $data[$key]["brand"], 
						'date' => $data[$key]["created_at"], 'type' => 'Expense');
					}
				}
			
				else
				{
					$ledger[] = array('amount' => $data[$key]["amount"], 'paymnent_method' => $data[$key]["brand"], 
					'date' => $data[$key]["created_at"], 'type' => 'Revenue');      
				}       
			}
		  
			return DataTables::of($ledger)
			->addColumn('amount', function($row){
			   return "$".number_format($row["amount"], 2, '.', '');   
			})
			->addColumn('created_at', function($row){
				return date('Y-m-d', strtotime(str_replace('-', '/', $row["date"])));
			})
			->addColumn('action','
			 <a href="#" class="btn btn-success">View Detail</a>')
			->rawColumns(['sale','commision','action','created_at','amount'])
			->make(true);
		}
		return view('SuperadminDashboard.accountBooks.generalLedger');
	}
	
	public function balanceSheet(Request $request)
	{  

		$ExpAmount=DataTreeItem::sum('amount');
		$tax= (($ExpAmount)*20)/100;
		$Expence=$ExpAmount-$tax;

		$data = DB::table('tbl_purchased_records')
		->select('tbl_purchased_records.created_at AS date','tbl_purchased_records.report_name as type'
		,DB::raw('(points_transaction.point/10) as amount'),DB::raw('((points_transaction.point/10)*20)/100 as tax'),DB::raw('((points_transaction.point/10)*80)/100 as cash'), DB::raw('(CASE WHEN tbl_purchased_records.report_type="1" THEN "Tax1" WHEN tbl_purchased_records.report_type="2" THEN "Tax2" WHEN tbl_purchased_records.report_type="3" THEN "Tax3"  ELSE "Tax4" END) as taxCode'), DB::raw('(CASE WHEN tbl_purchased_records.report_type="1" THEN "GL-101" WHEN tbl_purchased_records.report_type="2" THEN "GL-102" WHEN tbl_purchased_records.report_type="3" THEN "GL-103"  ELSE "GL-104" END) as glCode'))
		->Join('user_property', 'tbl_purchased_records.user_prop_id', '=', 'user_property.id')
		->Join('users', 'user_property.user_id', '=', 'users.id')
		->Join('datatree', 'tbl_purchased_records.property_id', '=', 'datatree.PropertyId')
		->Join('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id');


		$res = $data->where('user_property.trash','0')->orderBy('tbl_purchased_records.created_at','desc')->get();

		$data1 = DB::table('tbl_membership')
		->select('tbl_membership.created_at AS date','tbl_membership.id AS tb_id','tbl_membership.membership_type as type'
		,DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "Membership" ELSE "Membership" END) as type'),DB::raw('tbl_deposite.amount as amount'),DB::raw('((tbl_deposite.amount)*20)/100 as tax'),DB::raw('((tbl_deposite.amount)*80)/100 as cash'), DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "M125" ELSE "M125" END) as taxCode'), DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "M125" ELSE "M125" END) as glCode'))
		->Join('tbl_deposite', 'tbl_membership.trans_id', '=', 'tbl_deposite.id');



		$res1           =       $data1->orderBy('tbl_membership.created_at','desc')->get();

		$data3 = DB::table('user_property')
		->select('user_property.created_at AS date','id AS tb_id','result_id'
		,DB::raw('(CASE WHEN count(result_id) >= 1 THEN "Record Purchased" END) as type')
		,DB::raw('count(result_id) as amount')
		,DB::raw('(count(result_id)*20)/100 as tax'),
		DB::raw('(count(result_id)*80)/100 as cash'), 
		DB::raw('(CASE WHEN result_id !="" THEN "PRTX01"  END) as taxCode'),
		DB::raw('(CASE WHEN result_id !="" THEN "PRGL01"  END) as glCode'))->whereNotNull('result_id');



		$res2           =       $data3->groupBy('result_id')->get();

		$totdata = array_merge($res->toArray(), $res1->toArray(), $res2->toArray());

		// usort($totdata,array($this, "date_compare")); //sort userdefined array by date

		//echo "<pre>"; print_r($totdata); die;
		$totalsale      =       array();
		$onlyAmout      =       array_column($totdata, 'cash');
		foreach($totdata as $key => $dataNew){
			$newValue   =       [];
			foreach($onlyAmout as $k => $am){
			if($k<=$key){
			array_push($newValue,$am);
			}
			}

			$ledger = array_sum($newValue);

			$totalsale[] = array("date"=>$dataNew->date,"type"=>$dataNew->type ,"amount"=>$dataNew->amount
			,"tax"=>$dataNew->tax,"cash"=>$dataNew->cash,"taxCode"=>$dataNew->taxCode,"glCode"=>$dataNew->glCode,"ledger"=>$ledger);

		}
		//dd($ledger);
		$profit=$ledger-$Expence;
		$Todaydate = date('d-M-yy');
		return view('SuperadminDashboard.accountBooks.balanceSheet')->with(['ledger'=>$ledger,'Expence'=>$Expence,'profit'=>$profit,'Todaydate'=>$Todaydate]);

	}
	
	public function store(Request $request){
		
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
            
            $inputs=AccountChart::create($inputs);
   
               return redirect()->back()->with('Chart Of Account','Data added successfully');
        }
    }
	
	public function update(Request $request)
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
	
	function destroy($id){
        
        $team = AccountChart::where('id',$id)->delete();
     
        return redirect()->back()->with('success','Deleted sucessfully');
    }
	
   
}
