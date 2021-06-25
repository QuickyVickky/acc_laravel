<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Admin;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Services\CustomService;


date_default_timezone_set('Asia/Kolkata');

class SalesController extends Controller
{
    public $tbl = "customers";
    public $tbl2 = "customer_address";
    
    public function index(Request $request){
    	$data = ['tbl' => $this->tbl, 'control' => 'Customer List' ];
		return view('admin.customer.list')->with($data);
	}



    






}
