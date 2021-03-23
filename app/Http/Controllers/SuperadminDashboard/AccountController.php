<?php

namespace App\Http\Controllers\AccountDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\CustomerAccount;
use DataTables;

class AccountController extends Controller
{
    public function Accountview()
    {
        return view('AccountDashboard.customer');
    }

    function AccountList(){
        $reg_status = CustomerAccount::select('*');
        return DataTables::of($reg_status)
        ->editColumn('type', function ($inquiry) {
            if ($inquiry->type == 0) return 'Enrolled';
            if ($inquiry->type == 1) return 'Joined';
            return 'Cancel';
             })
        ->addColumn('commision','12')
        ->addColumn('action','<a href="#" class="btn btn-success">View Detail</a>')
        ->rawColumns(['sale','commision','action'])
        ->make(true);
        
    }
}
