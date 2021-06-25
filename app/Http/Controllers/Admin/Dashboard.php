<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
date_default_timezone_set('Asia/Kolkata');
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Bills;
use DB;


class Dashboard extends Controller
{
    private $tbl = "admins";

	public function index(Request $request){
        $today = []; $chartdata = []; $all_time = [];
        $todaydate = date('Y-m-d').'%';
        $thisyear = date('Y-').'%';
        $onedayafter = date('Y-m-d', strtotime('+1 days'));
        $last7daybefore = date('Y-m-d', strtotime('-7 days'));
        $last12monthsago_firstday = date('Y-m', strtotime(date('Y-m'). " -11 month"))."-01";
        $thismonth_lastday = date('Y-m', strtotime(date('Y-m'). " +1 month"))."-01";

        $all_time['invoice_amount_due'] = Invoice::where('is_active', constants('is_active_yes'))->where('invoice_status','!=','D')->sum('amount_due');
        $all_time['invoice_count'] = Invoice::where('is_active', constants('is_active_yes'))->count();
        $all_time['bill_count'] = Bills::where('is_active', constants('is_active_yes'))->count();
        $all_time['customer_count'] = Customer::where('is_active', constants('is_active_yes'))->count();

        $all_time['recent_invoice'] = $this->getdata_recent_invoice();
        $all_time['recent_bill'] = $this->getdata_recent_bill();


        $sql = "SELECT SUM(t.amount) as total_amount,t.transaction_type, MONTH(t.transaction_date) as month_number,YEAR(t.transaction_date) as year_number,count(*) as total_count, ab.name as abname FROM transactions t 
        INNER JOIN accounts_or_banks ab ON ab.id=t.accounts_or_banks_id

        where t.is_active='".constants('is_active_yes')."' and t.transaction_date BETWEEN '".date('Y-m-01')."' and '".$thismonth_lastday."' group by t.transaction_type,t.accounts_or_banks_id   ";
        $chartdata['thismonth_expensebreakdown_data'] = qry($sql);


        $sql = "SELECT SUM(t.amount) as total_amount,t.transaction_type, MONTH(t.transaction_date) as month_number,YEAR(t.transaction_date) as year_number,count(*) as total_count FROM transactions t where t.is_active='".constants('is_active_yes')."' and t.transaction_date BETWEEN '".$last12monthsago_firstday."' and '".$thismonth_lastday."' group by month(t.transaction_date),t.transaction_type   ";
        $chartdata['last12monthsdata'] = qry($sql);


        $data = ['tbl' => '', 'today' => $today, 'chartdata' => $chartdata, 'all_time' => $all_time, 'control' => 'Dashboard'];
		return view('admin.dashboard')->with($data);
	}


    public function change_status(Request $request){
        $id = update_data($request->tbl,['is_active' => $request->value],['id' => $request->id ]);
        echo json_encode($id);
    }

    public function log_out(Request $request){
        $request->session()->flush();
        return redirect()->route('loginpage');
    }


    private function getdata_recent_invoice(){
        $sql = "select iv.*,c.fullname as cfullname, c.mobile as cmobile , c.email as cemail,sh.name as shname,sh.details as shdetails,sh.classhtml as shclasshtml from invoices iv 
        INNER JOIN customers c ON c.id=iv.customer_id 
        LEFT JOIN short_helper sh ON sh.short=iv.invoice_status and sh.type='invoice_status'  
         WHERE iv.is_active!='2' and EXISTS(SELECT ivt.id FROM invoice_items ivt WHERE ivt.invoice_id = iv.id) 
         and iv.invoice_status IN ('U','R') and iv.payment_due_date < now() limit 5 ";
        $result = qry($sql);
        return $result;
    }


    private function getdata_recent_bill(){
        $sql = "select bl.*,v.fullname as vfullname, v.mobile as vmobile , v.email as vemail,sh.name as shname,sh.details as shdetails,sh.classhtml as shclasshtml from bills bl 
        INNER JOIN vendors v ON v.id=bl.vendor_id 
        LEFT JOIN short_helper sh ON sh.short=bl.bill_status and sh.type='bill_status' 
         WHERE bl.is_active!='2' and EXISTS(SELECT bi.id FROM bill_items bi WHERE bi.bill_id = bl.id) 
         and bl.bill_status IN ('U') and bl.payment_due_date < now() limit 5
          ";
        $result = qry($sql);
        return $result;
    }



}
