<?php

namespace App\Http\Controllers\CustomerDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PurchaseRecord;

class PurchaseRecordController extends Controller
{
    public function purchaseRecord(Request $request){
        $from=$request->input('from');
        $to=$request->input('to');
        if(isset($_POST['submit'])){
            $filterRecord=purchaseRecord::select("*")->whereBetween('date',[$from,$to])->get();
            return view('CustomerDashboard.purchased_record')->with('filterRecord',$filterRecord);
        }
        else{
            $record=PurchaseRecord::select("*")->get();
            return view('CustomerDashboard.purchased_record')->with('record',$record);
        }
    }    
}
