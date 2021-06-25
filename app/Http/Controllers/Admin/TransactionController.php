<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\SubCategory;
use App\Models\AccountCategory;
use App\Models\AccountBanks;
use DB;
use App\Services\CustomService;
use Illuminate\Support\Facades\Log;
use App\Exports\JustExcelExport;
use Maatwebsite\Excel\Facades\Excel;




date_default_timezone_set('Asia/Kolkata');

class TransactionController extends Controller
{
    private $tbl = "transactions";
    private $tbl2 = "";
    
    public function index(Request $request){
        $subCategoryInDropDown = (new CustomService())->subCategoryInDropDown();
        $data = ['tbl' => $this->tbl, 'control' => 'Transactions', 'subCategoryInDropDown' => $subCategoryInDropDown ];
        return view('admin.accounting.transaction')->with($data);
    }

    public function getedit(Request $request){
        $response = Transaction::with([
            'sub_category' => function($qrySub_category) {
                $qrySub_category->where('is_active',constants('is_active_yes'));
            },
            'invoice' => function($qryInvoice) {
                $qryInvoice->where('is_active',constants('is_active_yes'));
            },
            'bill' => function($qryBill) {
                $qryBill->where('is_active',constants('is_active_yes'));
            },
            ])
            ->where('id', $request->id)
            ->where('is_active', constants('is_active_yes'))
            ->where('is_editable', constants('is_editable_yes'))
            ->first();

        return response()->json($response);
    }

    public function addedit_index (Request $request){
        $one = []; $oneaddress = [];
        $Id = isset($_GET["edit"]) ? intval(trim($_GET["edit"])) : 0;
        $sql = 'SELECT c.* FROM '.$this->tbl.' c WHERE c.id='.$Id.' and c.is_active!="2" LIMIT 1';
        $one = qry($sql);
        $data = ['tbl' => $this->tbl, 'one' => $one];
        return view('admin.sales.customer.add')->with($data);
    }

    public function getdata(Request $request){
        $columns = array(          
            0 => 't.transaction_date',
            1 => 't.description',
            2 => 't.amount',
            3 => 't.created_at',
            4 => 't.updated_at',

        );


        $transaction_type_Sql = '';
        $accountbanks_ids_Sql = '';
        $subcategory_ids_Sql = '';
        $filter_global_transaction_date_Sql = '';
        $filter_global_reviewed_Sql = '';

        if(isset($request->reviewed) && is_array($request->reviewed) && !empty($request->reviewed)){
            $filter_global_reviewed_Status = "'" . implode ( "', '", $request->reviewed ) . "'";
            $filter_global_reviewed_Sql =  " and t.is_reviewed IN(".$filter_global_reviewed_Status.") ";
        }
        if(isset($request->filter_global_transaction_date) && $request->filter_global_transaction_date!=''){
            $date_start = explode(' - ', $request->filter_global_transaction_date);
            $stop_date = date('Y-m-d', strtotime($date_start[1] . ' +0 day'));
            $filter_global_transaction_date_Sql = " and t.transaction_date BETWEEN '".$date_start[0]."' and '".$stop_date."' ";
        }
        if(isset($request->transaction_type) && is_array($request->transaction_type) && !empty($request->transaction_type)){
            $transaction_type_Status = "'" . implode ( "', '", $request->transaction_type ) . "'";
            $transaction_type_Sql =  " and t.transaction_type IN(".$transaction_type_Status.") ";
        }
        if(isset($request->accountbanks_id) && $request->accountbanks_id!=''){
            $accountbanks_ids_Sql = ' and t.accounts_or_banks_id IN('.$request->accountbanks_id.')'; 
        }
        if(isset($request->subcategory_id) && is_array($request->subcategory_id) && !empty($request->subcategory_id)){
            $subcategory_ids_Status = "'" . implode ( "', '", $request->subcategory_id ) . "'";
            $subcategory_ids_Sql =  " and t.sub_category_id IN(".$subcategory_ids_Status.") ";
        }

        $sql = "select t.*,ab.name as abname,sh.name as shname,sh.details as shdetails,sh.classhtml as shclasshtml, sb.name as sbname
        FROM ".$this->tbl." t INNER JOIN accounts_or_banks ab ON ab.id=t.accounts_or_banks_id
        LEFT JOIN short_helper sh ON sh.short=t.payment_method and sh.type='payment_method'
        LEFT JOIN sub_category sb ON sb.id=t.sub_category_id
        WHERE t.is_active!='2' ".$filter_global_transaction_date_Sql.$transaction_type_Sql.$accountbanks_ids_Sql.$subcategory_ids_Sql.$filter_global_reviewed_Sql." ";


        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( t.transaction_date LIKE " . $searchString;
            $sql .= " OR t.description LIKE " . $searchString;
            $sql .= " OR t.notes LIKE " . $searchString;
            $sql .= " OR t.amount LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;

        foreach ($query as $row) {
            $delete = '';

            $edit = '<a style="cursor: pointer;" class="btn btn-rounded btn-outline-primary editit" data-id="'.$row->id.'" title="edit this"><i class="fas fa-pen-square"></i></a>';

            if($row->invoice_id==0 && $row->bills_id==0){
                $delete = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-danger deleteit" data-id="'.$row->id.'" title="delete this"><i class="far fa-trash-alt"></i></a>';
            }

            if($row->is_reviewed==0){
                $review = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-danger reviewit" data-id="'.$row->id.'" data-review="1" data-toggle="tooltip" data-placement="left" title="Mark As Reviewed"><i class="far fa-check-circle"></i></a>';
            }
            else
            {
                $review = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-success active reviewit" data-id="'.$row->id.'" data-review="0" data-toggle="tooltip" data-placement="left" title="Reviewed"><i class="fas fa-check-circle"></i></a>';
            }

            if($row->transaction_type==constants('transactionType.Credit')){
                $fontcolor = "green";
            }
            else
            {
                $fontcolor = "black";
            }
            
            $nestedData = array();
            $nestedData[] = date('Y-m-d',strtotime( $row->transaction_date));
            $nestedData[] = $row->description."<br><b class='opacitydowncls'>".$row->abname."</b>";
            $nestedData[] = "<b style='color:".$fontcolor."'>".$row->amount."</b>";
            $nestedData[] = $row->shname ."<br>". $row->sbname ;
            $nestedData[] = $edit." ".$review." ".$delete;
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


    public function Income_SubcategoryInDropDown(Request $request){
        try {
            if (!isset($request->searchTerm)) {
                $sql = 'SELECT sb.id,sb.main_category_id,sb.name as text,mc.name as main_category_name FROM sub_category sb INNER JOIN main_category mc ON mc.id=sb.main_category_id where sb.main_category_id IN ( '.constants('Income_Main_Category_Id').') and sb.is_active="1" order by id asc limit 10 ';
            }
            else
            {
                $sql = 'SELECT sb.id,sb.main_category_id,sb.name as text,mc.name as main_category_name FROM sub_category sb INNER JOIN main_category mc ON mc.id=sb.main_category_id where sb.main_category_id IN ( '.constants('Income_Main_Category_Id').') and sb.is_active="1" ';
                $sql .= " AND ( sb.name like '%" . $request->searchTerm . "%' ) order by id asc LIMIT 10 ";
            }
            $response = qry($sql);
            return response()->json($response);
        } catch (\Exception $e) {
            return [];
        }

    }


    public function record_payment(Request $request) {
        $request->validate([
            'transactions_id' => 'required|numeric',
            'hid' => 'required|numeric',
            'accounts_or_banks_id' => 'required|numeric',
            'payment_method' => 'required',
            'transaction_date' => 'required',
            'transaction_type' => 'required',
            'description' => 'required',
            'amount' => 'required|between:0,999999999999999.99',
            'is_editable' => 'required|numeric',
            'is_active' => 'required|numeric',
            'sub_category_id' => 'required|numeric',
            'invoice_id' => 'required|numeric',
            'bills_id' => 'required|numeric',
        ]);


         try {

            $count = Transaction::where('id',$request->transactions_id)->where('is_active', constants('is_active_yes'))->count();
            $count1 = SubCategory::where('id',$request->sub_category_id)->where('is_active', constants('is_active_yes'))->count();

            if($request->transactions_id>0 && ($count)>0 && ($count1)>0)
             {

            if($request->sub_category_id == constants('Transfer_From_Bank_Subcategory_Id') || $request->sub_category_id == constants('Transfer_To_Bank_Subcategory_Id')){
                $response = ['msg' => 'Can Not Be Updated !', 'success' => 0 , 'data' => NULL];
                return response()->json($response);
            }

            $updateData = [
            'updated_at' => date('Y-m-d H:i:s'),
            'transaction_date' => $request->transaction_date,
            'payment_method' => $request->payment_method,
            'accounts_or_banks_id' => $request->accounts_or_banks_id,
            'description' => $request->description,
            'notes' => isset($request->notes) ? trim($request->notes) : NULL,
            ];

            if($request->invoice_id>0){
                $updateData['invoice_id'] = $request->invoice_id;
            }
            else if($request->bills_id>0){
                $updateData['bills_id'] = $request->bills_id;
            }
            else if($request->sub_category_id>0){
                $updateData['sub_category_id'] = $request->sub_category_id;
                $updateData['amount'] = $request->amount;
                $updateData['transaction_type'] = $request->transaction_type;
            }

            update_data($this->tbl, $updateData ,['id' => $request->transactions_id ]);
            $response = ['msg' => 'Updated Successfully !', 'success' => 1 , 'data' => 1];
            return response()->json($response);
            }

            else if($request->transactions_id==0 && ($count)==0 && ($count1)>0)
            {

            if(isset($request->accounts_or_banks_id_transfer_fromto) && $request->accounts_or_banks_id_transfer_fromto>0){
                $insertDataV1 = [
                    'invoice_id' => 0,
                    'bills_id' => 0,
                    'transaction_date' => $request->transaction_date,
                    'amount' => $request->amount,
                    'sub_category_id' => $request->sub_category_id,
                    'payment_method' => $request->payment_method,
                    'accounts_or_banks_id' => $request->accounts_or_banks_id,
                    'notes' => isset($request->notes) ? trim($request->notes) : NULL,
                    'description' => $request->description,
                    'is_reviewed' => 0,
                    'transaction_type' => $request->transaction_type == 'Cr' ? 'Cr' : 'Dr',
                    'admin_id' => Session::get('adminid'),
                    'is_active'=> $request->is_active,
                    'is_editable'=> $request->is_editable,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'accounts_or_banks_id_transfer_fromto' => $request->accounts_or_banks_id_transfer_fromto,
                ];

                CreateLogsDeletedData($insertDataV1);


                $lastinsertid = insert_data_id($this->tbl, $insertDataV1);

                $insertDataV2 = [
                    'invoice_id' => 0,
                    'bills_id' => 0,
                    'transaction_date' => $request->transaction_date,
                    'amount' => $request->amount,
                    'sub_category_id' => $request->sub_category_id == constants('Transfer_From_Bank_Subcategory_Id') ? constants('Transfer_To_Bank_Subcategory_Id') : constants('Transfer_From_Bank_Subcategory_Id'),
                    'payment_method' => $request->payment_method,
                    'accounts_or_banks_id' => $request->accounts_or_banks_id_transfer_fromto,
                    'notes' => isset($request->notes) ? trim($request->notes) : NULL,
                    'description' => $request->description,
                    'is_reviewed' => 0,
                    'transaction_type' => $request->transaction_type == 'Cr' ? 'Dr' : 'Cr',
                    'admin_id' => Session::get('adminid'),
                    'is_active'=> $request->is_active,
                    'is_editable'=> $request->is_editable,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'accounts_or_banks_id_transfer_fromto' => $request->accounts_or_banks_id ,
                ];

                CreateLogsDeletedData($insertDataV2);

                $lastinsertid = insert_data_id($this->tbl, $insertDataV2);

            }
            else
            {
                $insertData = [
                    'invoice_id' => 0,
                    'bills_id' => 0,
                    'transaction_date' => $request->transaction_date,
                    'amount' => $request->amount,
                    'sub_category_id' => $request->sub_category_id,
                    'payment_method' => $request->payment_method,
                    'accounts_or_banks_id' => $request->accounts_or_banks_id,
                    'notes' => isset($request->notes) ? trim($request->notes) : NULL,
                    'description' => $request->description,
                    'is_reviewed' => 0,
                    'transaction_type' => $request->transaction_type == 'Cr' ? 'Cr' : 'Dr',
                    'admin_id' => Session::get('adminid'),
                    'is_active'=> $request->is_active,
                    'is_editable'=> $request->is_editable,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'accounts_or_banks_id_transfer_fromto' => NULL,
                ];
                $lastinsertid = insert_data_id($this->tbl ,$insertData);

            }
            
                if($lastinsertid>0)
                {
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

    public function change_transactions_deleted(Request $request) {
        $request->validate([
            'status' => 'required|numeric',
            'id' => 'required',
        ]);
         try {
            $Transactions = Transaction::whereIn('id',[ $request->id ])->where('invoice_id', 0)->where('bills_id', 0)->get();
            CreateLogsDeletedData($Transactions);
            Transaction::whereIn('id',[ $request->id ])->where('invoice_id', 0)->where('bills_id', 0)->delete();
            $response = ['msg' => 'Transaction Deleted Successfully !', 'success' => 1, 'data' => 1];
            return response()->json($response);
         } catch (\Exception $e) {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }

    }

    public function getAllAcountBalanace(Request $request){
        $DrArray =  
            AccountCategory::with([
                'all_account_banks' => function($qryAll_account_banks) {
                    $qryAll_account_banks->withCount(['transaction_accounts as sumDr' => function($query) {
                        $query->select(DB::raw('IF(SUM(amount)>0, SUM(amount), 0)') )->where('transaction_type','Dr');
                    },
                ]);
                $qryAll_account_banks->where('is_active',constants('is_active_yes'));
            },
            
            ])
            ->where('level',1)
            ->get();


        $CrArray =  
            AccountCategory::with([
                'all_account_banks' => function($qryAll_account_banks) {
                    $qryAll_account_banks->withCount(['transaction_accounts as sumCr' => function($query) {
                        $query->select(DB::raw('IF(SUM(amount)>0, SUM(amount), 0)') )->where('transaction_type','Cr');
                    },
                ]);
                $qryAll_account_banks->where('is_active',constants('is_active_yes'));
            },
            
            ])
            ->where('level',1)
            ->get();  

        $json = array('CrData' => $CrArray, 'DrData' => $DrArray, );     

        return response()->json($json);
    }


    public function change_transactions_reviewed(Request $request) {
        $request->validate([
            'status' => 'required|numeric',
            'id' => 'required',
        ]);
         try {
            Transaction::whereIn('id',[ $request->id ])->update(['is_reviewed' => $request->status ]);
            $response = ['msg' => 'Task Completed Successfully !', 'success' => 1];
            return response()->json($response);
         } catch (\Exception $e) {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }

    }


    public function export_excel(Request $request)
    {
        $transaction_type_Sql = '';
        $accountbanks_ids_Sql = '';
        $subcategory_ids_Sql = '';
        $filter_global_transaction_date_Sql = '';
        $filter_global_reviewed_Sql = '';


        if(isset($request->filter_global_reviewed) && is_array($request->filter_global_reviewed) && !empty($request->filter_global_reviewed)){
            $filter_global_reviewed_Status = "'" . implode ( "', '", $request->filter_global_reviewed ) . "'";
            $filter_global_reviewed_Sql =  " and t.is_reviewed IN(".$filter_global_reviewed_Status.") ";
        }


        if(isset($request->filter_global_transaction_date) && $request->filter_global_transaction_date!=''){
            $date_start = explode(' - ', $request->filter_global_transaction_date);
            $stop_date = date('Y-m-d', strtotime($date_start[1] . ' +0 day'));
            $filter_global_transaction_date_Sql = " and t.transaction_date BETWEEN '".$date_start[0]."' and '".$stop_date."' ";
        }


        if(isset($request->transaction_type) && is_array($request->transaction_type) && !empty($request->transaction_type)){
            $transaction_type_Status = "'" . implode ( "', '", $request->transaction_type ) . "'";
            $transaction_type_Sql =  " and t.transaction_type IN(".$transaction_type_Status.") ";
        }

        if(isset($request->filter_global_accountbanks_id) && $request->filter_global_accountbanks_id!=''){
            $accountbanks_ids_Sql = ' and t.accounts_or_banks_id IN('.$request->filter_global_accountbanks_id.')'; 
        }
       

        if(isset($request->subcategory_id) && is_array($request->subcategory_id) && !empty($request->subcategory_id)){
            $subcategory_ids_Status = "'" . implode ( "', '", $request->subcategory_id ) . "'";
            $subcategory_ids_Sql =  " and t.sub_category_id IN(".$subcategory_ids_Status.") ";
        }

        $sql = "select DATE_FORMAT(t.transaction_date, '%d-%b-%Y') as transaction_date,t.amount,t.description,t.notes,t.transaction_type,sb.name as Category,ab.name as accounts_or_banks,sh.details as payment_method_type
        FROM ".$this->tbl." t INNER JOIN accounts_or_banks ab ON ab.id=t.accounts_or_banks_id
        LEFT JOIN short_helper sh ON sh.short=t.payment_method and sh.type='payment_method'
        LEFT JOIN sub_category sb ON sb.id=t.sub_category_id
        WHERE t.is_active!='2' ".$filter_global_transaction_date_Sql.$transaction_type_Sql.$accountbanks_ids_Sql.$subcategory_ids_Sql.$filter_global_reviewed_Sql." ";

        $transactions = qry($sql,1);

        if(count($transactions)>0){
            $column_name =  array_keys($transactions[0]);
            $export = new JustExcelExport($transactions, $column_name );
            return Excel::download($export, "Transactions_".date('d-m-Y-H-i-s').'.xlsx'); 
        }
        else
        {
            Session::flash('cls', 'danger');
            Session::flash('msg', 'No Data Found!!');
            return redirect()->back();
        }
    }
















    






}
