<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Vendor;
use App\Models\Bills;
date_default_timezone_set('Asia/Kolkata');

class VendorController extends Controller
{
    public $tbl = "vendors";
    
    public function index(Request $request){
        $data = ['tbl' => $this->tbl, 'control' => 'Vendors'];
        return view('admin.purchase.vendor.list')->with($data);
    }

    public function getedit(Request $request){
        $response = Vendor::where('id', $request->id)->first();
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
            $delete = '<a href="javascript:void(0)" class="btn btn-rounded btn-outline-danger deleteit" data-id="'.$row->id.'" title="delete this"><i class="far fa-trash-alt"></i></a>';

            $nestedData = array();
            $nestedData[] = $row->fullname;
            $nestedData[] = $row->email;
            $nestedData[] = $row->mobile;
            $nestedData[] = $row->city."-".$row->pincode;
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
        $sqlEmail = ""; $sqlMobile = "";

        $request->validate([
            'fullname'=>'required',
            'email'=>'nullable|email',
            'typehid'=>'required',
            'hid'=>'required',
            'is_active'=>'required|numeric',
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
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => isset($request->email) ? trim($request->email) : NULL,
            'mobile' => isset($request->mobile) ? trim($request->mobile) : NULL,
            'updated_at' => date('Y-m-d H:i:s'),
            'address' => isset($request->address) ? trim($request->address) : NULL,
            'landmark' => isset($request->landmark) ? trim($request->landmark) : NULL,
            'country' => isset($request->country) ? trim($request->country) : '',
            'state' => isset($request->state) ? trim($request->state) : NULL,
            'city' => isset($request->city) ? trim($request->city) : NULL,
            'pincode' => isset($request->pincode) ? trim($request->pincode) : NULL,
            ];

            update_data($this->tbl, $updateData ,['id' => $request->hid ]);
            $response = ['msg' => $request->typehid.' Updated Successfully!', 'success' => 1 ];
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
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => isset($request->email) ? trim($request->email) : NULL,
            'mobile' => isset($request->mobile) ? trim($request->mobile) : NULL,
            'admin_id' => Session::get('adminid'),
            'is_active'=> $request->is_active == 1 ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'address' => isset($request->address) ? trim($request->address) : NULL,
            'landmark' => isset($request->landmark) ? trim($request->landmark) : NULL,
            'country' => isset($request->country) ? trim($request->country) : 'India',
            'state' => isset($request->state) ? trim($request->state) : NULL,
            'city' => isset($request->city) ? trim($request->city) : NULL,
            'pincode' => isset($request->pincode) ? trim($request->pincode) : NULL,

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
         } catch (\Exception $e) {
            $response = ['msg' => 'Please check Properly, Something Went Wrong. Please Try Again!!', 'success' => 0 ];
            return response()->json($e);
        }

    }


    public function VendorInDropDown(Request $request){
        try {
            $searchTerm = '';
            if(isset($request->searchTerm)) {
                $searchTerm = $request->searchTerm;
            }

            $response = Vendor::where('is_active', constants('is_active_yes'))
                ->where(function($query) use ($searchTerm) {
                    $query->where('fullname','LIKE', '%'.$searchTerm.'%')
                            ->orwhere('email','LIKE', '%'.$searchTerm.'%')
                            ->orwhere('mobile','LIKE', '%'.$searchTerm.'%');
            })
          ->orderBy('id','ASC')->limit(constants('limit_in_dropdown'))->get(['fullname AS text', 'id as id']);
            return response()->json($response);
        } catch (\Exception $e) {
            return [];
        }
    }


    public function change_vendor_deleted(Request $request) {
        $request->validate([
            'status' => 'required|numeric',
            'id' => 'required|numeric',
        ]);
         try {

            $count1 = Bills::where('vendor_id', $request->id)->count();
            $count2 = 0;

            if(($count2+$count1)<1){
                $Vendor = Vendor::where('id', $request->id)->first();
                CreateLogsDeletedData($Vendor);
                Vendor::whereIn('id',[ $request->id ])->delete();
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