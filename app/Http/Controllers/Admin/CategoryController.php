<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\MainCategory;
use App\Models\SubCategory;
date_default_timezone_set('Asia/Kolkata');

class CategoryController extends Controller
{
    public $tbl = "main_category";
    public $tbl2 = "sub_category";

    public function index(Request $request){
        $data = ['tbl' => $this->tbl, 'control' => 'Category'];
        return view('admin.category.list')->with($data);
    }

    public function getedit(Request $request){
        $response = qry('SELECT * FROM '.$this->tbl.' where id='.$request->id.' LIMIT 1');
        return response()->json($response);
    }

    public function geteditsub(Request $request){

        $response = SubCategory::whereHas('main_category', function($qryMain_category) {
                $qryMain_category->where('id','!=','');
            })
            ->where('is_active', constants('is_active_yes'))
            ->where('is_editable', constants('is_editable_yes'))
            ->where('id', $request->id)
            ->first();
        return response()->json($response);
    }

    public function getAllMaincategory() {
        $includeid = 0;
        extract($_REQUEST);
        if (!isset($_POST['searchTerm'])) {
            $sql = "select id, name as text from tbl_account_category where (is_active!='2' OR id=".$includeid.") and level='0' and path_to='0' order by id asc limit 50";
        } else {
            $sql = "select id, name as text from tbl_account_category where ( is_active!='2' OR id=".$includeid." ) and level='0' and path_to='0' ";
            $search = $_POST['searchTerm'];
            $sql .= " AND ( name like '%" . $search . "%' ) order by id asc LIMIT 50  ";
        }

        $response = qry($sql);
        return response()->json($response);
    }

    public function getAllSubcategory() {
        $includeid = 0; 
        extract($_REQUEST);

        if(isset($main_category_id) && $main_category_id> 0) { $main_category_id = $main_category_id;}
        else { $main_category_id = 0; }

        if (!isset($_POST['searchTerm'])) {
            $sql = "select id, name as text from tbl_account_category where (is_active!='2') and level='1' and path_to>0 and path_to=".$main_category_id." order by id asc limit 50";
        } else {
            $sql = "select id, name as text from tbl_account_category where ( is_active!='2' ) and level='1' and path_to>0 and path_to=".$main_category_id."  ";
            $search = $_POST['searchTerm'];
            $sql .= " AND ( name like '%" . $search . "%' ) order by id asc LIMIT 50  ";
        }

        $response = qry($sql);
        return response()->json($response);
    }

    public function getdata(Request $request){

        $columns = array(          
            0 => 'mc.id',
            1 => 'mc.name',
            1 => 'mc.name2',
            2 => 'mc.created_at',
        );
        $sql = "select mc.* from ".$this->tbl." mc WHERE mc.is_active!='2' ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( mc.name LIKE " . $searchString;
            $sql .= " OR mc.name2 LIKE " . $searchString;
            $sql .= " OR mc.created_at LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;
        foreach ($query as $row) {
            $edit = '';
          
            $nestedData = array();
            $nestedData[] = $cnts;
            $nestedData[] = $row->name;
            $nestedData[] = $row->name2;

            $edit = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary editit" data-id="'.$row->id.'" title="edit this"><i class="fas fa-pen-square"></i></a>';

            $nestedData[] = $edit;
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

    public function getdatasubcategory(Request $request){

        $columns = array(          
            0 => 'sc.name',
            1 => 'mc.name',
            2 => 'mc.created_at',
        );
        $sql = "select sc.*,mc.name as mcname from ".$this->tbl2." sc INNER JOIN ".$this->tbl." mc ON mc.id=sc.main_category_id WHERE sc.is_active!='2'  ";
        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( sc.name LIKE " . $searchString;
            $sql .= " and ( sc.name2 LIKE " . $searchString;
            $sql .= " and ( sc.details LIKE " . $searchString;
            $sql .= " OR mc.name LIKE " . $searchString;
            $sql .= " OR sc.created_at LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;
        foreach ($query as $row) {
            $edit = ''; $status = '';
            $nestedData = array();
            $nestedData[] = $row->name;
            $nestedData[] = $row->mcname;
            if($row->is_editable == constants('is_editable_yes')){
                $edit = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary editit" data-typehid="'.$row->mcname.'" data-id="'.$row->id.'" title="edit this"><i class="fas fa-pen-square"></i></a>';

                if ($row->is_active == 1) {
                $status = "<a style='cursor: pointer;' class='btn btn-success btn-sm change_statusit' data-id='".$row->id."' data-val='0'>ACTIVE</a>";
                } else {
                $status = "<a style='cursor: pointer;' class='btn btn-danger btn-sm change_statusit' data-id='".$row->id."' data-val='1'>DEACTIVE</a>";
                }
            }
            
            $nestedData[] = $edit." ".$status;
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

    public function addorupdatemaincategory(Request $request) {
        if(!isset($request->hid) OR !is_numeric($request->hid) OR !isset($request->name) OR $request->name=='' OR !isset($request->status) OR !is_numeric($request->status)){
            $response = ['msg' => 'Please check Properly, Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }

        if($request->hid==0){
            $data = [
                'name' => $request->name,
                'name2' => isset($request->name2) ? trim($request->name2) : NULL,
                'details' => isset($request->details) ? trim($request->details) : NULL,
                'is_active' => ($request->status==0) ? 0 : 1,
                'is_editable' => ($request->is_editable==0) ? 0 : 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            
            $id = insert_data_id($this->tbl,$data);

            if($id > 0){
            $response = ['msg' => 'Added Successfully', 'success' => 1 ];
            }
            else
            {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 1 ];
            }
            return response()->json($response);
        }
        else if($request->hid > 0)
        {
            $data = [
                'name' => $request->name,
                'name2' => isset($request->name2) ? trim($request->name2) : NULL,
                'details' => isset($request->details) ? trim($request->details) : NULL,
                'is_active' => ($request->status==0) ? 0 : 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $affectedRow = update_data($this->tbl,$data,['id' => $request->hid, 'is_editable' => 1]);
            $response = ['msg' => 'Updated Successfully!', 'success' => 1 ];
            return response()->json($response);
        }
        else
        {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }
    }

    public function addorupdatesubcategory(Request $request) {
        $request->validate([
            'hid' => 'required|numeric',
            'name' => 'required',
            'main_category_id' => 'required|numeric',
            'is_active' => 'required|numeric',
            'is_editable' => 'required|numeric',
            'typehid' => 'required',
            
        ]);

         try {

            if($request->hid>0)
             {
            
            $updateData = [
            'name' => $request->name,
            'main_category_id' => $request->main_category_id,
            'name2' => isset($request->name2) ? trim($request->name2) : NULL,
            'details' => isset($request->details) ? trim($request->details) : NULL,
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            update_data($this->tbl2, $updateData ,['id' => $request->hid ]);
            $response = ['msg' => $request->typehid.' Updated Successfully!', 'success' => 1 ];
            return response()->json($response);
            }
            else if($request->hid==0)
            {

            $insertData = [
            'name' => $request->name,
            'main_category_id' => $request->main_category_id,
            'name2' => isset($request->name2) ? trim($request->name2) : NULL,
            'details' => isset($request->details) ? trim($request->details) : NULL,
            'is_active'=> $request->is_active == 0 ? 0 : 1,
            'is_editable'=> $request->is_editable,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            $lastinsertid = insert_data_id($this->tbl2,$insertData);
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
         } catch (\Exception $e) {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }
    }


    public function subCategoryInDropDown(Request $request){
        try {
            $searchTerm = ''; $main_category_id = 0;
            if(isset($request->searchTerm)) {
                $searchTerm = $request->searchTerm;
            }

            if(isset($request->main_category_id)) {
                $main_category_id = $request->main_category_id;
            }


            $response = SubCategory::whereHas('main_category', function($qryMain_category) {
                $qryMain_category->where('id','!=','');
            })
            ->where('is_active', constants('is_active_yes'))
            ->where(function($main_category_idTermQry) use ($main_category_id) {
                if($main_category_id>0){
                    $main_category_idTermQry->where('main_category_id', $main_category_id);
                }
            })

            //->where('main_category_id', $main_category_id)

            ->where(function($searchTermQry) use ($searchTerm) {
                    $searchTermQry->where('name','LIKE', '%'.$searchTerm.'%')
                            ->orwhere('name2','LIKE', '%'.$searchTerm.'%')
                            ->orwhere('details','LIKE', '%'.$searchTerm.'%');
            })
            ->orderBy('id','ASC')
            ->limit(constants('limit_in_dropdown_large'))
            ->get(['name AS text', 'id as id']);

            return response()->json($response);
            // return $response;
        } catch (\Exception $e) {
            return [];
        }
    }


    public function changeSubcategoryStatus(Request $request) {
        $request->validate([
            'status' => 'required|numeric',
            'id' => 'required|numeric',
        ]);
         try {

            $count1 = SubCategory::where('id', $request->id)->count();

            if(($count1)>0){
                $Customer = SubCategory::where('id', $request->id)->update(['is_active' => $request->status ]);
                $response = ['msg' => 'Changed Successfully !', 'success' => 1];
            }
            else
            {
                $response = ['msg' => 'Can Not Be Changed!', 'success' => 0];
            }   return response()->json($response);
         } catch (\Exception $e) {
            $response = ['msg' => 'Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }

    }


    


  






}
