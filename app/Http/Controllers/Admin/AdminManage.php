<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Admin;

date_default_timezone_set('Asia/Kolkata');

class AdminManage extends Controller
{
    public $tbl = "admins";

    public function index(Request $request){
        $data = ['tbl' => $this->tbl, 'control' => 'Admin'];
        return view('admin.admins.list')->with($data);
    }

    public function getedit(Request $request){
        $response = Admin::where('id', $request->id)->first();
        return response()->json($response);
    }

    public function getdata(Request $request){
        $columns = array(          
            0 => 'c.fullname',
            1 => 'c.email',
            2 => 'c.mobile',
        );

        $sql = "select c.* from ".$this->tbl." c WHERE c.is_active!='2' ";

        $query = qry($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($request['search']['value'])) {   
            $searchString = "'%" . str_replace(",", "','", $request['search']['value']) . "%'"; 
            $sql .= " and ( c.fullname LIKE " . $searchString;
            $sql .= " OR c.email LIKE " . $searchString;
            $sql .= " OR c.mobile LIKE " . $searchString . ")";
        }

        $query = qry($sql);
        $totalFiltered = count($query);

        $sql .= " ORDER BY " . $columns[$request->order[0]['column']] . "   " . $request->order[0]['dir'] . " LIMIT " . $request->start . " ," . $request->length . "   ";  
        $query = qry($sql);

        $data = array();

        $cnts = $request->start + 1;

        foreach ($query as $row) {
            $edit = '<a style="cursor: pointer;" class="btn btn-rounded btn-outline-primary editit" data-id="'.$row->id.'" title="edit this"><i class="fas fa-pen-square"></i></a>';
        

            $nestedData = array();
            $nestedData[] = $row->fullname;
            $nestedData[] = $row->email;
            $nestedData[] = $row->mobile;
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


    public function Add_Or_Update(Request $request) {
         $sqlEmail = ""; $sqlMobile = "";

            $request->validate([
                'fullname'=>'required',
                'email'=>'required|email',
                'hid'=>'required',
            ]);

         try {

            if(isset($request->email) && $request->email!='' && filter_var($request->email, FILTER_VALIDATE_EMAIL)){
                $sqlEmail = "OR (email='".$request->email."' and email!='') ";
            }

            if(isset($request->mobile) && $request->mobile!=''){
                $sqlMobile = "OR (mobile='".$request->mobile."' and mobile!='') ";
            }


            if($request->hid>0)
             {
            
            $sql = "select id from ".$this->tbl." WHERE ( 1=2 $sqlEmail $sqlMobile ) and id!='".$request->hid."' ";
            $count = qry($sql);

            if(!empty($count)){
            $response = ['msg' => 'This Email Or Mobile Number is Already Registered !', 'success' => 0 ];
            return response()->json($response);
            }


            $updateData = [
            'fullname' => $request->fullname,
            'email' => isset($request->email) ? trim($request->email) : NULL,
            'mobile' => isset($request->mobile) ? trim($request->mobile) : NULL,
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            if(isset($request->password) && $request->password!=''){
                $updateData['password'] = bcrypt(trim($request->password));
            }

            update_data($this->tbl, $updateData ,['id' => $request->hid ]);
            $response = ['msg' => ' Updated Successfully!', 'success' => 1 ];
            return response()->json($response);
            }
            else if($request->hid==0)
            {

            $sql = "select id from ".$this->tbl." WHERE 1=2 $sqlEmail $sqlMobile ";
            $count = qry($sql);

            if(!empty($count)){
            $response = ['msg' => 'This Email Or Mobile Number is Already Registered !', 'success' => 0 ];
            return response()->json($response);
            }

            $insertData = [
            'fullname' => $request->fullname,
            'email' => isset($request->email) ? trim($request->email) : NULL,
            'mobile' => isset($request->mobile) ? trim($request->mobile) : NULL,
            'is_active'=> 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ];

            if(isset($request->password) && $request->password!=''){
                $insertData['password'] = bcrypt(trim($request->password));
            }
            else
            {
                $insertData['password'] = bcrypt(1234567890);
            }

            $lastinsertid = insert_data_id($this->tbl,$insertData);
                if($lastinsertid>0)
                {
                    $response = ['msg' => ' Added Successfully!', 'success' => 1 ];
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
            $response = ['msg' => 'Please check Properly, Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($response);
        }

    }

  






}
