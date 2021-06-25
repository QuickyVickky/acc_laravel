<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Services\CustomService;
use App\Models\Admin;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\ProductService;
use App\Models\InvoiceItem;
use App\Models\BillsItem;



date_default_timezone_set('Asia/Kolkata');

class ProductnServiceController extends Controller
{
    public $tbl = "products_or_services";
    public $tbl2 = "tax";

    public function index_sale(Request $request){
        $data = ['tbl' => $this->tbl, 'control' => 'Products & Services (Sales)'];
        return view('admin.sales.productnservices_list')->with($data);
    }

    public function index_expense(Request $request){
        $data = ['tbl' => $this->tbl, 'control' => 'Products & Services (Purchases)'];
        return view('admin.purchase.productnservices_list')->with($data);
    }

    public function getedit(Request $request){
        $response = ProductService::with('tax')->where('is_active','!=', 2)->where('id', $request->id)->first();
        return response()->json($response);
    }

    public function addedit_index_sale(Request $request){
        $one = [];
        $Id = isset($_GET["edit"]) ? intval(trim($_GET["edit"])) : 0;
        $sql = 'SELECT ps.* FROM '.$this->tbl.' ps
        INNER JOIN sub_category sb ON sb.id=ps.sub_category_id
        WHERE ps.id='.$Id.' and ps.is_active!="2" and EXISTS(SELECT mc.id FROM main_category mc WHERE mc.id IN(sb.main_category_id) and mc.id='.constants('Income_Main_Category_Id').') LIMIT 1';
        $one = qry($sql);
        $Income_Subcategory = (new CustomService())->Income_Subcategory();
        $Tax = (new CustomService())->Tax();
        $data = ['tbl' => $this->tbl, 'Income_Subcategory' => $Income_Subcategory, 'Tax' => $Tax, 'one' => $one ];
        return view('admin.sales.addproductorservice')->with($data);
    }

    public function addedit_index_expense(Request $request){
        $one = [];
        $Id = isset($_GET["edit"]) ? intval(trim($_GET["edit"])) : 0;
        $sql = 'SELECT ps.* FROM '.$this->tbl.' ps
        INNER JOIN sub_category sb ON sb.id=ps.sub_category_id
        WHERE ps.id='.$Id.' and ps.is_active!="2" and EXISTS(SELECT mc.id FROM main_category mc WHERE mc.id IN(sb.main_category_id) and mc.id='.constants('Expense_Main_Category_Id').') LIMIT 1';
        $one = qry($sql);
        $Expense_Subcategory = (new CustomService())->Expense_Subcategory();
        $Tax = (new CustomService())->Tax();
        $data = ['tbl' => $this->tbl, 'Expense_Subcategory' => $Expense_Subcategory, 'Tax' => $Tax, 'one' => $one  ];
        return view('admin.purchase.addproductorservice')->with($data);
    }

    public function getdata(Request $request){
        $columns = array(          
            0 => 'ps.name',
            1 => 'ps.description',
            2 => 'ps.price',
        );


        $sql = "select ps.id,ps.name,ps.is_active,ps.description,ps.price,ps.tax_id,ps.admin_id,sb.name as sub_category_name
         from ".$this->tbl." ps LEFT JOIN sub_category sb ON sb.id=ps.sub_category_id 
         WHERE ps.is_active!='2' and sb.main_category_id IN (".$request->main_category_id.")
         ";

        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( ps.name LIKE " . $searchString;
            $sql .= " OR ps.description LIKE " . $searchString;
            $sql .= " OR ps.price LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;

        foreach ($query as $row) {
            if($request->main_category_id==1){
                $url = "product-services-sales";
            }
            else
            {
                $url = "product-services-expense";
            }
            $edit = '<a href="'.route($url).'?edit='.$row->id.'" class="btn btn-rounded btn-outline-primary editit" data-id="'.$row->id.'" title="edit this"><i class="fas fa-pen-square"></i></a>';
            $delete = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-danger deleteit" data-id="'.$row->id.'" title="delete this"><i class="far fa-trash-alt"></i></a>';

            $nestedData = array();
            $nestedData[] = $row->name;
            $nestedData[] = $row->description;
            $nestedData[] = $row->price;
            $nestedData[] = $edit." ".$delete;
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


    public function Add_Or_Update(Request $request) {
        $request->validate([
            'name'=>'required',
            'price'=>'required',
            'typehid'=>'required',
            'main_category_hid'=>'required',
            'sub_category'=>'required',
            'hid'=>'required',
            'tax_id'=>'required|numeric',
            'is_active'=>'required|numeric',
        ]);

         try {

            if($request->hid>0)
             {
            $updateData = [
            'sub_category_id' => $request->sub_category,
            'name' => trim($request->name),
            'description' => isset($request->description) ? trim($request->description) : NULL,
            'price' => $request->price,
            'tax_id' => $request->tax_id,
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            update_data($this->tbl, $updateData ,['id' => $request->hid ]);
            Session::flash('msg', @$request->typehid.' Updated Successfully!');
            Session::flash('cls', 'success');
            }
            else if($request->hid==0)
            {

            $insertData = [
            'sub_category_id' => $request->sub_category,
            'name' => trim($request->name),
            'description' => isset($request->description) ? trim($request->description) : NULL,
            'price' => $request->price,
            'tax_id' => $request->tax_id,
            'admin_id' => Session::get('adminid'),
            'is_active'=> $request->is_active == 1 ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            $lastinsertid = insert_data_id($this->tbl,$insertData);
                if($lastinsertid>0)
                {
                    Session::flash('msg', @$request->typehid.' Added Successfully!');
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
            return redirect()->back()->withError($e->getMessage());
        }
    }


    public function Add_Or_Update_Ajax(Request $request) {
        $request->validate([
            'name'=>'required',
            'price'=>'required',
            'typehid'=>'required',
            'main_category_hid'=>'required',
            'sub_category'=>'required',
            'hid'=>'required',
            'tax_id'=>'required|numeric',
            'is_active'=>'required|numeric',
        ]);

         try {

            if($request->hid>0)
             {
            $updateData = [
            'sub_category_id' => $request->sub_category,
            'name' => trim($request->name),
            'description' => isset($request->description) ? trim($request->description) : NULL,
            'price' => $request->price,
            'tax_id' => $request->tax_id,
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            update_data($this->tbl, $updateData ,['id' => $request->hid ]);
            $response = ['msg' => $request->typehid.' Updated Successfully!', 'success' => 1 ];
            return response()->json($response);
            }
            else if($request->hid==0)
            {

            $insertData = [
            'sub_category_id' => $request->sub_category,
            'name' => trim($request->name),
            'description' => isset($request->description) ? trim($request->description) : NULL,
            'price' => $request->price,
            'tax_id' => $request->tax_id,
            'admin_id' => Session::get('adminid'),
            'is_active'=> $request->is_active == 1 ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            $lastinsertid = insert_data_id($this->tbl,$insertData);
                if($lastinsertid>0)
                {
                    $response = ['msg' => $request->typehid.' Added Successfully!', 'success' => 1 ];
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
            return redirect()->back();
         } catch (\Exception $e) {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }
    }


    public function change_pns_deleted(Request $request) {
        $request->validate([
            'status' => 'required|numeric',
            'pnsid' => 'required|numeric',
        ]);
         try {

            $count1 = InvoiceItem::where('products_or_services_id', $request->pnsid)->count();
            $count2 = BillsItem::where('products_or_services_id', $request->pnsid)->count();

            if(($count2+$count1)<1){
                $ProductService = ProductService::where('id', $request->pnsid)->first();
                CreateLogsDeletedData($ProductService);
                ProductService::whereIn('id',[ $request->pnsid ])->delete();
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
