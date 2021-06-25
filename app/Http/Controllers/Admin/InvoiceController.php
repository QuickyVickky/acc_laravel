<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\ProductService;
use App\Models\Transaction;

date_default_timezone_set('Asia/Kolkata');

class InvoiceController extends Controller
{
    private $tbl = "invoices";
    private $tbl2 = "invoice_items";
    private $tbl3 = "transactions";
    
    public function index(Request $request){
        $data = ['tbl' => $this->tbl, 'control' => 'Invoices'];
        return view('admin.sales.invoice.list')->with($data);
    }

    public function addedit_index(Request $request){
        $one = [];
        $Id = isset($_GET["edit"]) ? intval(trim($_GET["edit"])) : 0;
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
            ])
            ->where('is_active','!=', 2)
            ->where('id', $Id)
            ->first();

        $company_configurations = getCompanyConfiguration();

        $data = ['tbl' => $this->tbl, 'one' => $one, 'company_configurations' => $company_configurations ];
        return view('admin.sales.invoice.invoice')->with($data);
    }

    public function getedit(Request $request){
        $response = Invoice::where('id', $request->id)->first();
        return response()->json($response);
    }


    public function Add_Or_Update(Request $request) {
        $request->validate([
            'invoice_number'=>'required',
            'invoice_date'=>'required',
            'payment_due_date' => 'required',
            'select_customers_from_select2_dropdown_id' => 'required|numeric',
            'invoice_typehid'=>'required',
            'invoice_hid'=>'required',
            'is_active'=>'required',
            'selectedsalesproductnservices_id'=> 'required',
            'invoice_product_qty'=> 'required',
            'invoice_product_price'=> 'required',
            'invoice_tax_rateid'=> 'required',
            'invoice_subtotalid'=> 'required',
            'invoice_status' => 'required',
        ]);

         try {

            if($request->invoice_hid>0)
             {


            $updateData = [
            'customer_id' => $request->select_customers_from_select2_dropdown_id,
            'invoice_title' => isset($request->invoice_title) ? trim($request->invoice_title) : NULL,
            'invoice_description' => isset($request->invoice_description) ? trim($request->invoice_description) : NULL,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'payment_due_date' => isset($request->payment_due_date) ? trim($request->payment_due_date) : NULL,
            'updated_at' => date('Y-m-d H:i:s'),
            'invoice_comment' => isset($request->invoice_comment) ? trim($request->invoice_comment) : NULL,
            'footer_comment' => isset($request->footer_comment) ? trim($request->footer_comment) : NULL,
            ];

            update_data($this->tbl, $updateData ,['id' => $request->invoice_hid ]);
            update_data($this->tbl2 ,['is_active' => 2],['invoice_id' => $request->invoice_hid ]);
            
            $i = 0; $subtotalO = 0; $tax_totalO = 0; $totalO = 0; $total_qtyO = 0;

                if(!empty($request->invoice_product_qty) && is_array($request->invoice_product_qty)){
                    foreach ($request->invoice_product_qty as $key => $value) {
                                $Totalamount = $request->invoice_product_qty[$i]*$request->invoice_product_price[$i];
                                $Totaltax = $Totalamount*$request->invoice_tax_rateid[$i]*0.01;
                                $total_qtyO += $request->invoice_product_qty[$i];
                                $subtotalO += $Totalamount;
                                $tax_totalO += $Totaltax;
                                $totalO += $Totalamount + $Totaltax;

                                $invoice_itemdata = [
                                    'invoice_id' => $request->invoice_hid,
                                    'products_or_services_id' => $request->selectedsalesproductnservices_id[$i],
                                    'description' => $request->invoice_product_description[$i],
                                    'qty' => $request->invoice_product_qty[$i],
                                    'price' => $request->invoice_product_price[$i],
                                    'amount' => $Totalamount,
                                    'tax_id' => $request->invoice_product_select_a_tax_id[$i],
                                    'tax_rate' => $request->invoice_tax_rateid[$i],
                                    'totaltax' => $Totaltax,
                                    'is_active' => 1,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ];
                                        
                                $invoice_itemid = insert_data_id($this->tbl2, $invoice_itemdata);
                            $i++;
                    }
                }

                $total_paid = Transaction::where('invoice_id', $request->invoice_hid)->where('transaction_type','Cr')->sum('amount');

                $amount_due = $totalO - $total_paid;


                $invoiceDATA = [
                    'total_qty' => $total_qtyO,
                    'subtotal' => $subtotalO,
                    'tax_total' => $tax_totalO,
                    'total' => $totalO,
                    'invoice_status' => ($amount_due>0) ? 'R' : 'P',
                    'amount_due' => ($amount_due>0) ? $amount_due : 0,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                
                update_data($this->tbl,$invoiceDATA,['id' => $request->invoice_hid ]);
                InvoiceItem::where('is_active',2)->delete();
                Session::flash('msg', $request->invoice_typehid.' Updated Successfully!');
                Session::flash('cls', 'success');
            }
            else if($request->invoice_hid==0)
            {
            
            $insertData = [
            'customer_id' => $request->select_customers_from_select2_dropdown_id,
            'invoice_title' => isset($request->invoice_title) ? trim($request->invoice_title) : NULL,
            'invoice_description' => isset($request->invoice_description) ? trim($request->invoice_description) : NULL,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'payment_due_date' => isset($request->payment_due_date) ? trim($request->payment_due_date) : NULL,
            'invoice_comment' => isset($request->invoice_comment) ? trim($request->invoice_comment) : NULL,
            'footer_comment' => isset($request->footer_comment) ? trim($request->footer_comment) : NULL,
            'admin_id' => Session::get('adminid'),
            'is_active'=> $request->is_active == 1 ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            $lastinsertid = insert_data_id($this->tbl,$insertData);
                if($lastinsertid>0)
                {

                    $i = 0; $subtotalO = 0; $tax_totalO = 0; $totalO = 0; $total_qtyO = 0;

                        if(!empty($request->invoice_product_qty) && is_array($request->invoice_product_qty)){
                            foreach ($request->invoice_product_qty as $key => $value) {
                                $Totalamount = $request->invoice_product_qty[$i]*$request->invoice_product_price[$i];
                                $Totaltax = $Totalamount*$request->invoice_tax_rateid[$i]*0.01;
                                $total_qtyO += $request->invoice_product_qty[$i];
                                $subtotalO += $Totalamount;
                                $tax_totalO += $Totaltax;
                                $totalO += $Totalamount + $Totaltax;

                                $invoice_itemdata = [
                                    'invoice_id' => $lastinsertid,
                                    'products_or_services_id' => $request->selectedsalesproductnservices_id[$i],
                                    'description' => $request->invoice_product_description[$i],
                                    'qty' => $request->invoice_product_qty[$i],
                                    'price' => $request->invoice_product_price[$i],
                                    'amount' => $Totalamount,
                                    'tax_id' => $request->invoice_product_select_a_tax_id[$i],
                                    'tax_rate' => $request->invoice_tax_rateid[$i],
                                    'totaltax' => $Totaltax,
                                    'is_active' => 1,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ];
                                        
                                $invoice_itemid = insert_data_id($this->tbl2, $invoice_itemdata);
                                $i++;
                            }
                        }

                        $invoiceDATA = [
                            'total_qty' => $total_qtyO,
                            'subtotal' => $subtotalO,
                            'tax_total' => $tax_totalO,
                            'total' => $totalO,
                            'amount_due' => $totalO,
                            'invoice_status' => ($request->invoice_status=='D') ? 'D' : 'U',
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                
                    update_data($this->tbl,$invoiceDATA,['id' => $lastinsertid]);
                    Session::flash('msg', $request->invoice_typehid.' Added Successfully!');
                    Session::flash('cls', 'success');
                    return redirect()->route('invoice-list');
                }
                else
                {
                    Session::flash('msg', 'Something Went Wrong. Please Try Again!!');
                    Session::flash('cls', 'danger');
                }
            }
            else
            {
                Session::flash('msg', 'Something Went Wrong. Please Try Again!!');
                Session::flash('cls', 'danger');
            }
            return redirect()->back();
         } catch (\Exception $e) {
            Session::flash('msg', 'Something Went Wrong. Please Try Again!!');
            Session::flash('cls', 'danger');
            return redirect()->back()->withError($e->getMessage());
        }

    }



    public function salesproductnservicesInDropDown(Request $request){
        try {
            $searchTerm = '';
            if(isset($request->searchTerm)) {
                $searchTerm = $request->searchTerm;
            }

            $response = ProductService::whereHas('sub_category', function($qrySub_category) {
                $qrySub_category->whereIn('main_category_id',[constants('Income_Main_Category_Id')]);
            })
            ->where('is_active','!=', 2)
            ->where(function($querySearchTerm) use ($searchTerm) {
                    $querySearchTerm->where('name','LIKE', '%'.$searchTerm.'%')
                            ->orwhere('description','LIKE', '%'.$searchTerm.'%');
            })
            ->orderBy('id','ASC')
            ->limit(constants('limit_in_dropdown'))
            ->get(['name AS text', 'id as id']);

            return response()->json($response);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getdata(Request $request){
        $columns = array(          
            0 => 'iv.invoice_status',
            1 => 'iv.invoice_date',
            2 => 'iv.invoice_number',
            3 => 'c.fullname',
            4 => 'iv.total',
            5 => 'iv.amount_due',
            6 => 'iv.created_at',
        );


        $sql = "select iv.*,c.fullname as cfullname, c.mobile as cmobile , c.email as cemail,sh.name as shname,sh.details as shdetails,sh.classhtml as shclasshtml from ".$this->tbl." iv 
        INNER JOIN customers c ON c.id=iv.customer_id 
        LEFT JOIN short_helper sh ON sh.short=iv.invoice_status and sh.type='invoice_status' 
        WHERE iv.is_active!='2' and EXISTS(SELECT ivt.id FROM ".$this->tbl2." ivt WHERE ivt.invoice_id = iv.id) and invoice_status IN (".$request->invoice_status.")  ";

        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( iv.invoice_title LIKE " . $searchString;
            $sql .= " OR iv.invoice_description LIKE " . $searchString;
            $sql .= " OR iv.invoice_date LIKE " . $searchString;
            $sql .= " OR iv.payment_due_date LIKE " . $searchString;
            $sql .= " OR iv.invoice_comment LIKE " . $searchString;
            $sql .= " OR iv.footer_comment LIKE " . $searchString;
            $sql .= " OR iv.total LIKE " . $searchString;
            $sql .= " OR c.fullname LIKE " . $searchString;
            $sql .= " OR c.mobile LIKE " . $searchString;
            $sql .= " OR c.email LIKE " . $searchString;
            $sql .= " OR c.firstname LIKE " . $searchString;
            $sql .= " OR c.lastname LIKE " . $searchString;
            $sql .= " OR c.address LIKE " . $searchString;
            $sql .= " OR iv.invoice_number LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;

        foreach ($query as $row) {
            $recrdpaymentBtn = '';  $extrapaid = '';


            if($row->invoice_status=='R' || $row->invoice_status=='U'){
                $recrdpaymentBtn = "<a style='cursor: pointer;' data-toggle='modal' data-target='#RecordaPaymentModal' class='dropdown-item recordapaymentit' data-id='".$row->id."' >Record a Payment</a>";
            }

            $editBtn = "<a style='cursor: pointer;' class='dropdown-item editit' data-id='".$row->id."'><i class='far fa-edit mr-2'></i> Edit</a>";

            $exportPDFBtn = "<a style='cursor: pointer;' class='dropdown-item exportpdfit' data-id='".$row->id."'>Export PDF</a>";

            $duplicateBtn = "<a style='cursor: pointer;' class='dropdown-item makeduplicateit' data-id='".$row->id."'><i class='far fa-copy mr-2'></i> Duplicate</a>"; 

            $deleteBtn = "<a style='cursor: pointer;' class='dropdown-item deleteit' data-id='".$row->id."'><i class='far fa-trash-alt mr-2'></i> Delete</a>";
  

          $actionBtn = '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent" id="dropdownMenuReference'.$row->id.'">Action </button><div class="dropdown-menu" aria-labelledby="dropdownMenuReference'.$row->id.'" style="will-change: transform;">'.$recrdpaymentBtn.$editBtn.$duplicateBtn.$exportPDFBtn.$deleteBtn.'</div></div>';

          if(($row->total_paid - $row->total)>0){
            $extrapaid = "<br> [ +".($row->total_paid - $row->total)." ]";
          }


            $nestedData = array();
            $nestedData[] = '<span class="badge bg-'.$row->shclasshtml.'-light">'.$row->shname.'</span>';
            $nestedData[] = date('Y-m-d',strtotime( $row->invoice_date));
            $nestedData[] = $row->invoice_number;
            $nestedData[] = $row->cfullname;
            $nestedData[] = $row->total;
            $nestedData[] = $row->amount_due.$extrapaid;
            $nestedData[] = $actionBtn;
            $nestedData['DT_RowId'] = "r" . $row->id;
            $data[] = $nestedData;
            $cnts++;
        }

        $json_data = array(
            "draw" => intval($request['draw']), 
            "recordsTotal" => intval($totalData), 
            "recordsFiltered" => intval($totalFiltered), 
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function getdata_draft(Request $request){
        $columns = array(          
            0 => 'iv.invoice_status',
            1 => 'iv.invoice_date',
            2 => 'iv.invoice_number',
            3 => 'c.fullname',
            4 => 'iv.amount_due',
            5 => 'iv.created_at',

        );


        $sql = "select iv.*,c.fullname as cfullname, c.mobile as cmobile , c.email as cemail,sh.name as shname,sh.details as shdetails,sh.classhtml as shclasshtml from ".$this->tbl." iv 
        INNER JOIN customers c ON c.id=iv.customer_id 
        LEFT JOIN short_helper sh ON sh.short=iv.invoice_status and sh.type='invoice_status' 
         WHERE iv.is_active!='2' and EXISTS(SELECT ivt.id FROM ".$this->tbl2." ivt WHERE ivt.invoice_id = iv.id) and invoice_status IN (".$request->invoice_status.")  ";

        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( iv.invoice_title LIKE " . $searchString;
            $sql .= " OR iv.invoice_description LIKE " . $searchString;
            $sql .= " OR iv.invoice_date LIKE " . $searchString;
            $sql .= " OR iv.payment_due_date LIKE " . $searchString;
            $sql .= " OR iv.invoice_comment LIKE " . $searchString;
            $sql .= " OR iv.footer_comment LIKE " . $searchString;
            $sql .= " OR iv.total LIKE " . $searchString;
            $sql .= " OR c.fullname LIKE " . $searchString;
            $sql .= " OR c.mobile LIKE " . $searchString;
            $sql .= " OR c.email LIKE " . $searchString;
            $sql .= " OR c.firstname LIKE " . $searchString;
            $sql .= " OR c.lastname LIKE " . $searchString;
            $sql .= " OR c.address LIKE " . $searchString;
            $sql .= " OR iv.invoice_number LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;

        foreach ($query as $row) {
            $recrdpaymentBtn = '';  $approveDraftBtn = ''; $editBtn = '';

            //$editBtn = "<a style='cursor: pointer;' class='dropdown-item editit' data-id='".$row->id."'><i class='far fa-edit mr-2'></i>Edit</a>";

            $approveDraftBtn = "<a style='cursor: pointer;' class='dropdown-item approvedraftit' data-id='".$row->id."'>Approve Draft</a>";

            $exportPDFBtn = "<a style='cursor: pointer;' class='dropdown-item exportpdfit' data-id='".$row->id."'>Export PDF</a>";

            $duplicateBtn = "<a style='cursor: pointer;' class='dropdown-item makeduplicateit' data-id='".$row->id."'><i class='far fa-copy mr-2'></i> Duplicate</a>"; 

            $deleteBtn = "<a style='cursor: pointer;' class='dropdown-item deleteit' data-id='".$row->id."'><i class='far fa-trash-alt mr-2'></i> Delete</a>";
  

          $actionBtn = '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent" id="dropdownMenuReference'.$row->id.'">Action </button><div class="dropdown-menu" aria-labelledby="dropdownMenuReference'.$row->id.'" style="will-change: transform;">'.$recrdpaymentBtn.$editBtn.$duplicateBtn.$exportPDFBtn.$approveDraftBtn.$deleteBtn.'</div></div>';


            $nestedData = array();
            $nestedData[] = '<span class="badge bg-'.$row->shclasshtml.'-light">'.$row->shname.'</span>';
            $nestedData[] = date('Y-m-d',strtotime( $row->invoice_date));
            $nestedData[] = $row->invoice_number;
            $nestedData[] = $row->cfullname;
            $nestedData[] = $row->amount_due;
            $nestedData[] = $actionBtn;
            $nestedData['DT_RowId'] = "r" . $row->id;
            $data[] = $nestedData;
            $cnts++;
        }

        $json_data = array(
            "draw" => intval($request['draw']), 
            "recordsTotal" => intval($totalData), 
            "recordsFiltered" => intval($totalFiltered), 
            "data" => $data
        );

        echo json_encode($json_data);
    }


    public function getdata_unpaid(Request $request){
        $columns = array(          
            0 => 'iv.invoice_status',
            1 => 'iv.payment_due_date',
            2 => 'iv.invoice_date',
            3 => 'iv.invoice_number',
            4 => 'c.fullname',
            5 => 'iv.amount_due',
            6 => 'iv.created_at',

        );


        $sql = "select iv.*,c.fullname as cfullname, c.mobile as cmobile , c.email as cemail,sh.name as shname,sh.details as shdetails,sh.classhtml as shclasshtml from ".$this->tbl." iv 
        INNER JOIN customers c ON c.id=iv.customer_id 
        LEFT JOIN short_helper sh ON sh.short=iv.invoice_status and sh.type='invoice_status'  
         WHERE iv.is_active!='2' and EXISTS(SELECT ivt.id FROM ".$this->tbl2." ivt WHERE ivt.invoice_id = iv.id) and invoice_status IN (".$request->invoice_status.")  ";

        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( iv.invoice_title LIKE " . $searchString;
            $sql .= " OR iv.invoice_description LIKE " . $searchString;
            $sql .= " OR iv.invoice_date LIKE " . $searchString;
            $sql .= " OR iv.payment_due_date LIKE " . $searchString;
            $sql .= " OR iv.invoice_comment LIKE " . $searchString;
            $sql .= " OR iv.footer_comment LIKE " . $searchString;
            $sql .= " OR iv.total LIKE " . $searchString;
            $sql .= " OR c.fullname LIKE " . $searchString;
            $sql .= " OR c.mobile LIKE " . $searchString;
            $sql .= " OR c.email LIKE " . $searchString;
            $sql .= " OR c.firstname LIKE " . $searchString;
            $sql .= " OR c.lastname LIKE " . $searchString;
            $sql .= " OR c.address LIKE " . $searchString;
            $sql .= " OR iv.invoice_number LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;

        foreach ($query as $row) {
            $recrdpaymentBtn = ''; 

            if($row->invoice_status=='R' || $row->invoice_status=='U'){
                $recrdpaymentBtn = "<a style='cursor: pointer;' data-toggle='modal' data-target='#RecordaPaymentModal' class='dropdown-item recordapaymentit' data-id='".$row->id."' >Record a Payment</a>";
            }

            $editBtn = "<a style='cursor: pointer;' class='dropdown-item editit' data-id='".$row->id."'><i class='far fa-edit mr-2'></i>Edit</a>";

            $exportPDFBtn = "<a style='cursor: pointer;' class='dropdown-item exportpdfit' data-id='".$row->id."'>Export PDF</a>";

            $duplicateBtn = "<a style='cursor: pointer;' class='dropdown-item makeduplicateit' data-id='".$row->id."'><i class='far fa-copy mr-2'></i> Duplicate</a>"; 

            $deleteBtn = "<a style='cursor: pointer;' class='dropdown-item deleteit' data-id='".$row->id."'><i class='far fa-trash-alt mr-2'></i> Delete</a>";
  

          $actionBtn = '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent" id="dropdownMenuReference'.$row->id.'">Action </button><div class="dropdown-menu" aria-labelledby="dropdownMenuReference'.$row->id.'" style="will-change: transform;">'.$recrdpaymentBtn.$editBtn.$duplicateBtn.$exportPDFBtn.$deleteBtn.'</div></div>';


            $date1=date_create(date('Y-m-d',strtotime( $row->payment_due_date)));
            $date2=date_create(date('Y-m-d'));

            $diff = date_diff($date1,$date2);

            if($diff->format("%R")=='-'){
                $textdue = 'in '.$diff->format("%a").' days';
            }
            else
            {
                $textdue = $diff->format("%a").' days ago';
            }


            $nestedData = array();
            $nestedData[] = '<span class="badge bg-'.$row->shclasshtml.'-light">'.$row->shname.'</span>';


            $nestedData[] = $textdue;
            $nestedData[] = date('Y-m-d',strtotime( $row->invoice_date));
            $nestedData[] = $row->invoice_number;
            $nestedData[] = $row->cfullname;
            $nestedData[] = $row->amount_due;
            $nestedData[] = $actionBtn;
            $nestedData['DT_RowId'] = "r" . $row->id;
            $data[] = $nestedData;
            $cnts++;
        }

        $json_data = array(
            "draw" => intval($request['draw']), 
            "recordsTotal" => intval($totalData), 
            "recordsFiltered" => intval($totalFiltered), 
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function makeduplicate(Request $request) {
        $request->validate([
            'id'=>'required|numeric',
        ]);

         try {
            if($request->id>0)
            {

            $one = Invoice::with([
            'invoice_item' => function($qryInvoice_item) {
               $qryInvoice_item->where('is_active',constants('is_active_yes'));
                },
            ])
            ->where('is_active','!=', 2)
            ->where('id', $request->id)
            ->first();

            
            $insertData = [
            'customer_id' => $one->customer_id,
            'invoice_title' => $one->invoice_title,
            'invoice_description' => $one->invoice_description,
            'invoice_number' => $one->invoice_number,
            'invoice_date' => $one->invoice_date,
            'payment_due_date' => $one->payment_due_date,
            'invoice_comment' => $one->invoice_comment,
            'footer_comment' => $one->footer_comment,
            'admin_id' => Session::get('adminid'),
            'is_active'=> constants('is_active_yes'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            $lastinsertid = insert_data_id($this->tbl,$insertData);

                if($lastinsertid>0)
                {
                    $i = 0; $subtotalO = 0; $tax_totalO = 0; $totalO = 0; $total_qtyO = 0;

                        if(!empty($one->invoice_item)){
                            foreach($one->invoice_item as $key => $value) {

                                $Totalamount = $value->qty*$value->price;
                                $Totaltax = $Totalamount*$value->tax_rate*0.01;
                                $total_qtyO += $value->qty;
                                $subtotalO += $Totalamount;
                                $tax_totalO += $Totaltax;
                                $totalO += $Totalamount + $Totaltax;
                                

                                $invoice_itemdata = [
                                    'invoice_id' => $lastinsertid,
                                    'products_or_services_id' => $value->products_or_services_id,
                                    'description' => $value->description,
                                    'qty' => $value->qty,
                                    'price' => $value->price,
                                    'amount' => $Totalamount,
                                    'tax_id' => $value->tax_id,
                                    'tax_rate' => $value->tax_rate,
                                    'totaltax' => $Totaltax,
                                    'is_active' => 1,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ];
                                        
                                $invoice_itemid = insert_data_id($this->tbl2, $invoice_itemdata);
                                $i++;
                            }
                        }

                        $invoiceDATA = [
                            'total_qty' => $total_qtyO,
                            'subtotal' => $subtotalO,
                            'tax_total' => $tax_totalO,
                            'total' => $totalO,
                            'amount_due' => $totalO,
                            'invoice_number' => $lastinsertid,
                            'invoice_status' => 'U',
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                
                    update_data($this->tbl,$invoiceDATA,['id' => $lastinsertid]);
                    $response = ['msg' => '', 'success' => 1, 'data' => $lastinsertid ];
                    return response()->json($response);
                }
                else
                {
                    $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
                    return response()->json($response);
                }
            }
            else
            {
                $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
                return response()->json($response);
            }
         } catch (\Exception $e) {
                $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
                return response()->json($e);
        }

    }

    public function invoice_record_payment(Request $request) {
        $request->validate([
            'id'=>'required|numeric',
            'hid'=>'required|numeric',
            'accounts_or_banks_id'=>'required|numeric',
            'payment_method'=>'required',
            'transaction_date'=>'required',
            'amount'=> 'required|between:0,999999999999999.99',
            'is_editable'=>'required|numeric',
            'is_active'=>'required|numeric',
        ]);

         try {

            $invoice = Invoice::where('id',$request->hid)->where('is_active', constants('is_active_yes'))->first();

            if($request->id>0 && !empty($invoice))
             {

            $updateData = [
            'updated_at' => date('Y-m-d H:i:s'),
            'transaction_date' => $request->transaction_date,
            'payment_method' => $request->payment_method,
            'accounts_or_banks_id' => $request->accounts_or_banks_id,
            'notes' => isset($request->notes) ? trim($request->notes) : NULL,
            ];

            update_data($this->tbl3, $updateData ,['id' => $request->id ]);
            $response = ['msg' => 'Updated Successfully !', 'success' => 1 , 'data' => $request->id ];
            return response()->json($response);
            }

            else if($request->id==0 && !empty($invoice))
            {
            
            $insertData = [
            'invoice_id' => $request->hid,
            'bills_id' => 0,
            'transaction_date' => $request->transaction_date,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'accounts_or_banks_id' => $request->accounts_or_banks_id,
            'notes' => isset($request->notes) ? trim($request->notes) : NULL,
            'description' => 'Invoice Payment',
            'is_reviewed' => 0,
            'transaction_type' => $request->transaction_type == 'Dr' ? 'Dr' : 'Cr',
            'admin_id' => Session::get('adminid'),
            'is_active'=> $request->is_active,
            'is_editable'=> $request->is_editable,
            'sub_category_id'=> constants('Income_Invoice_Payment_Subcategory_Id'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            $lastinsertid = insert_data_id($this->tbl3 ,$insertData);

                if($lastinsertid>0)
                {
                    $total_paid = Transaction::where('invoice_id',$request->hid)->sum('amount');
                    $amount_due = $invoice->total - $total_paid;

                        $invoiceDATA = [
                            'total_paid' => $total_paid,
                            'amount_due' => ($amount_due>0) ? $amount_due : 0,
                            'invoice_status' => ($amount_due>0) ? 'R' : 'P',
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
            
                    update_data($this->tbl,  $invoiceDATA,['id' => $request->hid ]);

                    $response = ['msg' => 'Added Successfully !', 'success' => 1 , 'data' => $lastinsertid ];
                    return response()->json($response);
                }
                else
                {
                    $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
                    return response()->json($response);
                }
            }
            else
            {
                $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
                return response()->json($response);
            }
         } catch (\Exception $e) {
                $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
                return response()->json($response);
        }

   }


    public function draft_invoice_approve(Request $request) {
        $request->validate([
            'invoice_id'=>'required|numeric',
        ]);

         try {
            $count = Invoice::where('id',$request->invoice_id)->where('invoice_status','D')->count();

            if($request->invoice_id>0 && $count>0)
            {
                $invoiceDATA = 
                [
                    'invoice_status' => 'U',
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                
                update_data($this->tbl, $invoiceDATA ,['id' => $request->invoice_id ]);
                $response = ['msg' => 'Draft Approved', 'success' => 1, 'data' => $request->invoice_id ];
                return response()->json($response);
            }
            else
            {
                $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
                return response()->json($response);
            }
         } catch (\Exception $e) {
                $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
                return response()->json($response);
        }
    }


    public function change_invoice_deleted(Request $request) {
        $request->validate([
            'status' => 'required|numeric',
            'id' => 'required|numeric',
        ]);
         try {

                $Invoice = Invoice::with([
                'invoice_item' => function($qryInvoice_item) {
                    
                },
                'transaction' => function($qryTransaction) {
                    $qryTransaction->where('invoice_id','>',0);
                },
                ])
                ->where('id', $request->id )
                ->first();

                CreateLogsDeletedData($Invoice);
                Invoice::whereIn('id',[ $request->id ])->delete();
                InvoiceItem::whereIn('invoice_id',[ $request->id ])->delete();
                Transaction::whereIn('invoice_id',[ $request->id ])->where('invoice_id', '>', 0)->delete();
                $response = ['msg' => 'Deleted Successfully !', 'success' => 1];
                return response()->json($response);
         } catch (\Exception $e) {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }
    }





    






}
