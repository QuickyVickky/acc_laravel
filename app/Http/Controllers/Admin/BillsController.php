<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Company;
use App\Models\Bills;
use App\Models\BillsItem;
use App\Models\ProductService;
use App\Models\Transaction;

date_default_timezone_set('Asia/Kolkata');

class BillsController extends Controller
{
    private $tbl = "bills";
    private $tbl2 = "bill_items";
    private $tbl3 = "transactions";
    
    public function index(Request $request){
        $data = ['tbl' => $this->tbl, 'control' => 'Bills'];
        return view('admin.purchase.bills.list')->with($data);
    }

    public function addedit_index (Request $request){
        $one = [];
        $Id = isset($_GET["edit"]) ? intval(trim($_GET["edit"])) : 0;
        $one = Bills::with([
            'bills_item' => function($qrybills_item) {
                $qrybills_item->with([
                    'productnservice' => function($qryProductnservice) {
                        $qryProductnservice->orderBy('is_active','DESC');
                    },
                ]);
               $qrybills_item->where('is_active',constants('is_active_yes'));
            },
            'vendor' => function($qryVendor) {
                $qryVendor->where('id','!=','');
            },
            ])
            ->where('is_active','!=', 2)
            ->where('id', $Id)
            ->first();

        $company_configurations = Company::where('id', constants('company_configurations_id'))->orderBy('id','ASC')->first();

        $data = ['tbl' => $this->tbl, 'one' => $one, 'company_configurations' => $company_configurations ];
        return view('admin.purchase.bills.bills')->with($data);
    }

    public function getedit(Request $request){
        $response = Bills::where('id', $request->id)->first();
        return response()->json($response);
    }


    public function Add_Or_Update(Request $request) {
        $request->validate([
            'bill_number'=>'required',
            'bill_date'=>'required',
            'payment_due_date' => 'required',
            'select_vendors_from_select2_dropdown_id' => 'required|numeric',
            'bills_typehid'=>'required',
            'bills_hid'=>'required',
            'is_active'=>'required|numeric',
            'selectedexpensesproductnservices_id'=> 'required',
            'bills_product_qty'=> 'required',
            'bills_product_price'=> 'required',
            'bills_tax_rateid'=> 'required',
            'bills_subtotalid'=> 'required',
        ]);

         try {

            if($request->bills_hid>0)
             {


            $updateData = [
            'vendor_id' => $request->select_vendors_from_select2_dropdown_id,
            'bill_notes' => isset($request->bill_notes) ? trim($request->bill_notes) : NULL,
            'bill_number' => $request->bill_number,
            'bill_date' => $request->bill_date,
            'payment_due_date' => isset($request->payment_due_date) ? trim($request->payment_due_date) : NULL,
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            update_data($this->tbl, $updateData ,['id' => $request->bills_hid ]);
            update_data($this->tbl2 ,['is_active' => 2],['bill_id' => $request->bills_hid ]);
            
            $i = 0; $subtotalO = 0; $tax_totalO = 0; $totalO = 0; $total_qtyO = 0;

                if(!empty($request->bills_product_qty) && is_array($request->bills_product_qty)){
                    foreach ($request->bills_product_qty as $key => $value) {
                                $Totalamount = $request->bills_product_qty[$i]*$request->bills_product_price[$i];
                                $Totaltax = $Totalamount*$request->bills_tax_rateid[$i]*0.01;
                                $total_qtyO += $request->bills_product_qty[$i];
                                $subtotalO += $Totalamount;
                                $tax_totalO += $Totaltax;
                                $totalO += $Totalamount + $Totaltax;

                                $bills_itemdata = [
                                    'bill_id' => $request->bills_hid,
                                    'products_or_services_id' => $request->selectedexpensesproductnservices_id[$i],
                                    'description' => $request->bills_product_description[$i],
                                    'qty' => $request->bills_product_qty[$i],
                                    'price' => $request->bills_product_price[$i],
                                    'amount' => $Totalamount,
                                    'tax_id' => $request->bills_product_select_a_tax_id[$i],
                                    'tax_rate' => $request->bills_tax_rateid[$i],
                                    'totaltax' => $Totaltax,
                                    'is_active' => 1,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ];
                                        
                                $bills_itemid = insert_data_id($this->tbl2, $bills_itemdata);
                            $i++;
                    }
                }


                $total_paid = Transaction::where('bills_id', $request->bills_hid)->where('transaction_type','Dr')->sum('amount');

                $amount_due = $totalO - $total_paid;

                $billsDATA = [
                    'total_qty' => $total_qtyO,
                    'subtotal' => $subtotalO,
                    'tax_total' => $tax_totalO,
                    'total' => $totalO,
                    'bill_status' => ($amount_due>0) ? 'U' : 'P',
                    'amount_due' => ($amount_due>0) ? $amount_due : 0,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                
                update_data($this->tbl,$billsDATA,['id' => $request->bills_hid ]);
                BillsItem::where('is_active',2)->delete();
                Session::flash('msg', $request->bills_typehid.' Updated Successfully!');
                Session::flash('cls', 'success');
            }
            else if($request->bills_hid==0)
            {
            
            $insertData = [
            'vendor_id' => $request->select_vendors_from_select2_dropdown_id,
            'bill_notes' => isset($request->bill_notes) ? trim($request->bill_notes) : NULL,
            'bill_number' => $request->bill_number,
            'bill_date' => $request->bill_date,
            'payment_due_date' => isset($request->payment_due_date) ? trim($request->payment_due_date) : NULL,
            'admin_id' => Session::get('adminid'),
            'is_active'=> $request->is_active == 1 ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            $lastinsertid = insert_data_id($this->tbl,$insertData);
                if($lastinsertid>0)
                {

                    $i = 0; $subtotalO = 0; $tax_totalO = 0; $totalO = 0; $total_qtyO = 0;

                        if(!empty($request->bills_product_qty) && is_array($request->bills_product_qty)){
                            foreach ($request->bills_product_qty as $key => $value) {
                                $Totalamount = $request->bills_product_qty[$i]*$request->bills_product_price[$i];
                                $Totaltax = $Totalamount*$request->bills_tax_rateid[$i]*0.01;
                                $total_qtyO += $request->bills_product_qty[$i];
                                $subtotalO += $Totalamount;
                                $tax_totalO += $Totaltax;
                                $totalO += $Totalamount + $Totaltax;

                                $bills_itemdata = [
                                    'bill_id' => $lastinsertid,
                                    'products_or_services_id' => $request->selectedexpensesproductnservices_id[$i],
                                    'description' => $request->bills_product_description[$i],
                                    'qty' => $request->bills_product_qty[$i],
                                    'price' => $request->bills_product_price[$i],
                                    'amount' => $Totalamount,
                                    'tax_id' => $request->bills_product_select_a_tax_id[$i],
                                    'tax_rate' => $request->bills_tax_rateid[$i],
                                    'totaltax' => $Totaltax,
                                    'is_active' => 1,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ];
                                        
                                $bills_itemid = insert_data_id($this->tbl2, $bills_itemdata);
                                $i++;
                            }
                        }

                        $billsDATA = [
                            'total_qty' => $total_qtyO,
                            'subtotal' => $subtotalO,
                            'tax_total' => $tax_totalO,
                            'total' => $totalO,
                            'amount_due' => $totalO,
                            'bill_status' => 'U',
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                
                    update_data($this->tbl,$billsDATA,['id' => $lastinsertid]);
                    Session::flash('msg', $request->bills_typehid.' Added Successfully!');
                    Session::flash('cls', 'success');
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
            0 => 'bl.bill_status',
            1 => 'bl.bill_date',
            2 => 'bl.bill_number',
            3 => 'v.fullname',
            4 => 'bl.total',
            5 => 'bl.amount_due',
            6 => 'bl.created_at',
        );


        $sql = "select bl.*,v.fullname as vfullname, v.mobile as vmobile , v.email as vemail,sh.name as shname,sh.details as shdetails,sh.classhtml as shclasshtml from ".$this->tbl." bl 
        INNER JOIN vendors v ON v.id=bl.vendor_id 
        LEFT JOIN short_helper sh ON sh.short=bl.bill_status and sh.type='bill_status' 
         WHERE bl.is_active!='2' and EXISTS(SELECT bi.id FROM ".$this->tbl2." bi WHERE bi.bill_id = bl.id)  ";

        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( bl.bill_status LIKE " . $searchString;
            $sql .= " OR bl.bill_date LIKE " . $searchString;
            $sql .= " OR bl.bill_number LIKE " . $searchString;
            $sql .= " OR bl.payment_due_date LIKE " . $searchString;
            $sql .= " OR bl.total LIKE " . $searchString;
            $sql .= " OR v.fullname LIKE " . $searchString;
            $sql .= " OR v.mobile LIKE " . $searchString;
            $sql .= " OR v.email LIKE " . $searchString;
            $sql .= " OR v.firstname LIKE " . $searchString;
            $sql .= " OR v.lastname LIKE " . $searchString;
            $sql .= " OR v.address LIKE " . $searchString;
            $sql .= " OR bl.total_paid LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;

        foreach ($query as $row) {
            $recrdpaymentBtn = '';  $extrapaid = '';

            $delete = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-danger deleteit" data-id="'.$row->id.'" title="delete this"><i class="far fa-trash-alt"></i></a>';

            if($row->bill_status=='U'){
                $recrdpaymentBtn = "<a style='cursor: pointer;' data-toggle='modal' data-target='#RecordaPaymentModal' class='dropdown-item recordapaymentit' data-id='".$row->id."' >Record a Payment</a>";
            }

            $editBtn = "<a style='cursor: pointer;' class='dropdown-item editit' data-id='".$row->id."'><i class='far fa-edit mr-2'></i> View/Edit</a>";


            $duplicateBtn = "<a style='cursor: pointer;' class='dropdown-item makeduplicateit' data-id='".$row->id."'><i class='far fa-copy mr-2'></i> Duplicate</a>"; 

            $deleteBtn = "<a style='cursor: pointer;' class='dropdown-item deleteit' data-id='".$row->id."'><i class='far fa-trash-alt mr-2'></i> Delete</a>"; 
  

          $actionBtn = '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent" id="dropdownMenuReference'.$row->id.'">Action </button><div class="dropdown-menu" aria-labelledby="dropdownMenuReference'.$row->id.'" style="will-change: transform;">'.$recrdpaymentBtn.$editBtn.$duplicateBtn.$deleteBtn.'</div></div>';

          if(($row->total_paid - $row->total)>0){
            $extrapaid = "<br> [ +".($row->total_paid - $row->total)." ]";
          }


            $nestedData = array();
            $nestedData[] = '<span class="badge bg-'.$row->shclasshtml.'-light">'.$row->shname.'</span>';
            $nestedData[] = date('Y-m-d',strtotime( $row->bill_date));
            $nestedData[] = $row->bill_number;
            $nestedData[] = $row->vfullname;
            $nestedData[] = $row->amount_due.$extrapaid."<br><b class='btotalbill'>Total : ".$row->total."</b>";
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

            $one = Bills::with(['bills_item' => function($qrybills_item) {
               $qrybills_item->where('is_active',constants('is_active_yes'));
                },
            ])
            ->where('is_active','!=', 2)
            ->where('id', $request->id)
            ->first();

            
            $insertData = [
            'vendor_id' => $one->vendor_id,
            'bill_notes' => $one->bill_notes,
            'bill_number' => $one->bill_number,
            'bill_date' => $one->bill_date,
            'payment_due_date' => $one->payment_due_date,
            'admin_id' => Session::get('adminid'),
            'is_active'=> constants('is_active_yes'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            $lastinsertid = insert_data_id($this->tbl,$insertData);

                if($lastinsertid>0)
                {
                    $i = 0; $subtotalO = 0; $tax_totalO = 0; $totalO = 0; $total_qtyO = 0;

                        if(!empty($one->bills_item)){
                            foreach($one->bills_item as $key => $value) {

                                $Totalamount = $value->qty*$value->price;
                                $Totaltax = $Totalamount*$value->tax_rate*0.01;
                                $total_qtyO += $value->qty;
                                $subtotalO += $Totalamount;
                                $tax_totalO += $Totaltax;
                                $totalO += $Totalamount + $Totaltax;
                                

                                $bills_itemdata = [
                                    'bill_id' => $lastinsertid,
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
                                        
                                $bills_itemid = insert_data_id($this->tbl2, $bills_itemdata);
                                $i++;
                            }
                        }

                        $BillsDATA = [
                            'total_qty' => $total_qtyO,
                            'subtotal' => $subtotalO,
                            'tax_total' => $tax_totalO,
                            'total' => $totalO,
                            'amount_due' => $totalO,
                            'bill_number' => $lastinsertid,
                            'bill_status' => 'U',
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                
                    update_data($this->tbl,$BillsDATA,['id' => $lastinsertid]);
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

    public function bill_record_payment(Request $request) {
        $request->validate([
            'transactions_id'=>'required|numeric',
            'hid'=>'required|numeric',
            'accounts_or_banks_id'=>'required|numeric',
            'payment_method'=>'required',
            'transaction_date'=>'required',
            'amount'=> 'required|between:0,999999999999999.99',
            'is_editable'=>'required|numeric',
            'is_active'=>'required|numeric',
        ]);


         try {

            $Bills = Bills::where('id',$request->hid)->where('is_active', constants('is_active_yes'))->first();

            if($request->transactions_id>0 && !empty($Bills))
             {

            $updateData = [
            'updated_at' => date('Y-m-d H:i:s'),
            'transaction_date' => $request->transaction_date,
            'payment_method' => $request->payment_method,
            'accounts_or_banks_id' => $request->accounts_or_banks_id,
            'notes' => isset($request->notes) ? trim($request->notes) : NULL,
            ];

            update_data($this->tbl3, $updateData ,['id' => $request->transactions_id ]);
            $response = ['msg' => 'Updated Successfully !', 'success' => 1 , 'data' => 1];
            return response()->json($response);
            }

            else if($request->transactions_id==0 && !empty($Bills))
            {
            
            $insertData = [
            'invoice_id' => 0,
            'bills_id' => $request->hid,
            'transaction_date' => $request->transaction_date,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'accounts_or_banks_id' => $request->accounts_or_banks_id,
            'notes' => isset($request->notes) ? trim($request->notes) : NULL,
            'description' => 'Bill Payment',
            'is_reviewed' => 0,
            'transaction_type' => $request->transaction_type == 'Cr' ? 'Cr' : 'Dr',
            'admin_id' => Session::get('adminid'),
            'is_active'=> $request->is_active,
            'is_editable'=> $request->is_editable,
            'sub_category_id'=> constants('Expense_Bill_Payment_Subcategory_Id'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            $lastinsertid = insert_data_id($this->tbl3 ,$insertData);

                if($lastinsertid>0)
                {
                    $total_paid = Transaction::where('bills_id',$request->hid)->sum('amount');
                    $amount_due = $Bills->total - $total_paid;

                        $BillsDATA = [
                            'total_paid' => $total_paid,
                            'amount_due' => ($amount_due>0) ? $amount_due : 0,
                            'bill_status' => ($amount_due>0) ? 'U' : 'P',
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
            
                    update_data($this->tbl,  $BillsDATA,['id' => $request->hid ]);

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

    public function expensesproductnservicesInDropDown(Request $request){
        try {
            $searchTerm = '';
            if(isset($request->searchTerm)) {
                $searchTerm = $request->searchTerm;
            }

            $response = ProductService::whereHas('sub_category', function($qrySub_category) {
                $qrySub_category->whereIn('main_category_id',[constants('Expense_Main_Category_Id')]);
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


     public function change_bills_deleted(Request $request) {
        $request->validate([
            'status' => 'required|numeric',
            'id' => 'required|numeric',
        ]);
         try {

            $count1 = Transaction::where('bills_id', $request->id)->where('bills_id','>',0)->count();
            $count2 = 0;

            if(($count2+$count1)<1){
                $Bills = Bills::with(['bills_item'])->where('id', $request->id)->first();
                CreateLogsDeletedData($Bills);
                Bills::whereIn('id',[ $request->id ])->delete();
                BillsItem::whereIn('bill_id',[ $request->id ])->delete();
                $response = ['msg' => 'Deleted Successfully !', 'success' => 1];
            }
            else
            {
                $response = ['msg' => 'Can Not Be Deleted!', 'success' => 0];
            }            return response()->json($response);
         } catch (\Exception $e) {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }

    }






    






}
