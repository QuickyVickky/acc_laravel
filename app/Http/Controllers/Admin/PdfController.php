<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use PDF;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\ProductService;
use App\Models\Transaction;
date_default_timezone_set('Asia/Kolkata');

class PdfController extends Controller
{
    private $tbl = "";

    public function index(Request $request){
        $data = ['tbl' => $this->tbl, 'control' => 'Invoice', 'filename' => "Invoice-".date('Y-m-d H:i:s').".pdf" ];
        return view('admin.pdf.customer_invoice')->with($data);
    }


    public function download_customer_invoice(Request $request){
        if(!isset($request->hidden_invoiceid_download)){
            Session::flash('msg', 'Something Went Wrong. Please Try Again!!');
            Session::flash('cls', 'danger');
            return redirect()->back();
        }


        $one = Invoice::with([
            'invoice_item' => function($qryInvoice_item) {
                $qryInvoice_item->with([
                    'productnservice' => function($qryProductnservice) {
                        $qryProductnservice->orderBy('is_active','DESC');
                    },
                ]);
               $qryInvoice_item->where('is_active',constants('is_active_yes'));
            },
            'customer' => function($qryCustomer) {
                $qryCustomer->where('id','!=','');
            },
            'transaction' => function($qryTransaction) {
                $qryTransaction->with(['payment_method_name']);
                $qryTransaction->where('is_active',constants('is_active_yes'))->where('invoice_id','>',0);
            },
            ])
            ->where('is_active','!=', 2)
            ->where('id', $request->hidden_invoiceid_download)
            ->first();

        $company_configurations = Company::where('id', constants('company_configurations_id'))->orderBy('id','ASC')->first();

        $data = [
        'control' => 'Invoice', 
        'filename' => "Invoice_".$one->invoice_number.date('Y-m-d',strtotime($one->payment_due_date)).".pdf", 
        'one' => $one,
        'company_configurations' => $company_configurations,
        ];

        
        //return view('admin.pdf.customer_invoice')->with($data);


        $pdf = PDF:: setOptions([ 'defaultFont' => 'courier', 'isRemoteEnabled' => true ])->loadView('admin.pdf.customer_invoice', $data)->setPaper('A4', 'portrait');
        return $pdf->download($data['filename']);
        //return $pdf->stream($data['filename']);

        return redirect()->back();
        //Landscape  horizontal ----- portrait vertical |
    }


    




  






}
