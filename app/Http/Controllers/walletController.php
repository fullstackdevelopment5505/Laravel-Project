<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wallet;
use DataTables;
use App\Model\Points;
use DB;
use App\User;

class walletController extends Controller
{
    
    public function walletview() 
    {
        return view('AccountDashboard.wallet');
    }

    function walletList(){
        $data = DB::table('tbl_purchased_records')
        
        ->select('tbl_purchased_records.created_at AS date','user_detail.f_name','user_detail.l_name',
        DB::raw('(points_transaction.point/10) as amount'), 
        DB::raw('((points_transaction.point/10)*20)/100 as tax'),
        DB::raw('((points_transaction.point/10)*80)/100 as cash'))
        ->Join('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
        ->leftJoin('user_detail', 'tbl_purchased_records.user_id', '=', 'user_detail.user_id')
        ->orderBy('tbl_purchased_records.created_at','desc')->get();
       
        return DataTables::of($data)
       
        
        //->editColumn('amount', '$ {{$amount}}')
        ->addColumn('name', function($row){
				    
            return \ucfirst( $row->f_name)." ".\ucfirst($row->l_name);
        })
        ->addColumn('action','')
        ->rawColumns(['sale','commision','action'])
        ->make(true);   
    }
}
