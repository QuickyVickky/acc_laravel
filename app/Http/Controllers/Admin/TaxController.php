<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Tax;
date_default_timezone_set('Asia/Kolkata');

class TaxController extends Controller
{
    private $tbl = "company_configurations";
    
    public function index (Request $request) {
        $one = Company::where('id', constants('company_configurations_id'))->orderBy('id','ASC')->first();
        $data = ['tbl' => $this->tbl, 'one' => $one, 'control' => ' Company Information'];
        return view('admin.company.company')->with($data);
    }











    






}
