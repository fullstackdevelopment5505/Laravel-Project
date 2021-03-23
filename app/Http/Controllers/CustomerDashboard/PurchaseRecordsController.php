<?php

namespace App\Http\Controllers\CustomerDashboard;

use Illuminate\Http\Request;

class PurchaseRecordController extends Controller
{
    public function purchaseRecord(){
        $record=PurchaseRecord::select("*")->get();
        return view('CustomerDashboard.purchased_record')->with('record',$record);
    }
}
