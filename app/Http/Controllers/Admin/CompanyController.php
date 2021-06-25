<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Company;
date_default_timezone_set('Asia/Kolkata');

class CompanyController extends Controller
{
    private $tbl = "company_configurations";
    
    public function index (Request $request) {
        $one = Company::where('id', constants('company_configurations_id'))->orderBy('id','ASC')->first();
        $data = ['tbl' => $this->tbl, 'one' => $one, 'control' => ' Company Information'];
        return view('admin.company.company')->with($data);
    }

    public function Add_Or_Update(Request $request) {
        $request->validate([
            'company_name'=>'required',
            'email'=>'nullable|email',
            'pincode'=>'nullable|digits:6|numeric',
            'typehid'=>'required',
            'hid'=>'required|numeric',
        ]);

         try {

            if($request->hid>0)
             {
            $updateData = [
            'company_name' => $request->company_name,
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

            $uploadfile = '';
            if($request->file('invoice_logo')!=''){
            $uploadfile = UploadImage($request->file('invoice_logo'), constants("company_files") );
            $request->existing_img = isset($request->existing_img) ? $request->existing_img : '0';
            DeleteFile($request->existing_img, constants("company_files"));
            $updateData['invoice_logo'] = $uploadfile;
            }

            update_data($this->tbl, $updateData ,['id' =>  constants('company_configurations_id')]);
            Session::flash('msg', @$request->typehid.' Updated Successfully!');
            Session::flash('cls', 'success');
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











    






}
