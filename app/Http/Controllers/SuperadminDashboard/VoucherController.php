<?php

namespace App\Http\Controllers\AccountDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
   public function VoucherList()
   {
       return view('AccountDashboard.sale.vouchers');
   }
}
