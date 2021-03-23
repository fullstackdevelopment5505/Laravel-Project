<?php
namespace App\Http\Controllers\AccountDashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;

class PurchaseRecordsController extends Controller
{
    

    public function purchasedRecordsList()
    {
        return view('AccountDashboard.sale.purchasedRecordsReport');
    }  

    public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a->date);
        $t2 = strtotime($b->date);
        return $t1 - $t2;
    }    


    function purchasedRecords(Request $request)
    {
        if(!empty($request->get('date_from_purchase')) || !empty($request->get('date_to_purchase')))
        {
            $data = DB::table('user_property')->select('user_property.created_at AS date','user_property.id AS tb_id','result_id'
            ,DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name')
            ,DB::raw('count(result_id) as amount')
            ,DB::raw('(count(result_id)*20)/100 as tax'),
            DB::raw('(count(result_id)*80)/100 as cash'), 
            DB::raw('(CASE WHEN result_id !="" THEN "PRTX01"  END) as taxCode'),
             DB::raw('(CASE WHEN result_id !="" THEN "PRGL01"  END) as glCode'))
             ->leftJoin('users', 'user_property.user_id', '=', 'users.id')
             ->leftJoin('user_detail', 'user_property.user_id', '=', 'user_detail.user_id')
             ->whereNotNull('result_id');
                                    

                    if($request->date_from_purchase != '' && $request->date_to_purchase !=''){
                        // echo 'HERE';
                        $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                        $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                        $data->whereBetween('user_property.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                    }
                    if($request->date_from_purchase == '' && $request->date_to_purchase !=''){
                        //echo 'HERE2';
                        $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                        $data->where('user_property.created_at','<=',$membership_start_date_to . ' 23:59:59');
                    }
                    if($request->date_from_purchase != '' && $request->date_to_purchase ==''){
                        //echo 'HERE3';
                        $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                        $data->where('user_property.created_at', '>=',$membership_start_date_from . ' 00:00:00');
                    }
                    $data= $data->where('user_property.trash','0')->groupBy('result_id')->get();


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
            
                        $totalsale[] = array("date"=>$dat->date ,"name"=>$dat->name ,"tax"=>$dat->tax,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
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
                ->addColumn('abc', function($row){
                    if(fmod($row["abc"], 1) !== 0.00){
                        return "$".number_format($row["abc"],2);  
                    } else {
                        
                        return "$".floatval($row["abc"]);  
                    }
                })
                    ->make(true);              
                }
                $data = DB::table('user_property')->select('user_property.created_at AS date','user_property.id AS tb_id','result_id'
                ,DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name')
                ,DB::raw('count(result_id) as amount')
                ,DB::raw('(count(result_id)*20)/100 as tax'),
                DB::raw('(count(result_id)*80)/100 as cash'), 
                DB::raw('(CASE WHEN result_id !="" THEN "PRTX01"  END) as taxCode'),
                 DB::raw('(CASE WHEN result_id !="" THEN "PRGL01"  END) as glCode'))
                 ->leftJoin('users', 'user_property.user_id', '=', 'users.id')
                 ->leftJoin('user_detail', 'user_property.user_id', '=', 'user_detail.user_id')
                 ->whereNotNull('result_id')
				 ->where('user_property.trash','0')
                 ->groupBy('result_id')->get();
               // echo "<pre>"; print_r($data); die;
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

                    $totalsale[] = array("date"=>$dat->date ,"name"=>$dat->name ,"tax"=>$dat->tax,"cash"=>$dat->cash,"amount"=>$dat->amount ,"abc"=>$abc);
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
            ->addColumn('abc', function($row){
                if(fmod($row["abc"], 1) !== 0.00){
                    return "$".number_format($row["abc"],2);  
                } else {
                    
                    return "$".floatval($row["abc"]);  
                }
            }) 
             ->rawColumns(['sale','commision','action','created_at','amount'])
                ->make(true);  
                
                // $data = DB::table('user_property')
                // ->select('user_property.created_at AS date','id AS tb_id','result_id'
                // ,DB::raw('(CASE WHEN count(result_id) >= 1 THEN "Record Purchased" END) as name')
                // ,DB::raw('count(result_id) as amount')
                // ,DB::raw('(count(result_id)*20)/100 as tax'),
                // DB::raw('(count(result_id)*80)/100 as cash'), 
                // DB::raw('(CASE WHEN result_id !="" THEN "PRTX01"  END) as taxCode'),
                //  DB::raw('(CASE WHEN result_id !="" THEN "PRGL01"  END) as glCode'))->whereNotNull('result_id');
                // ->get();
    }
}
