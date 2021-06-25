<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Admin;

date_default_timezone_set('Asia/Kolkata');


class LoginController extends Controller
{
	private $tbl = "admins";

	public function index(){
		if(Session::get('adminid')!=''){
			return redirect()->route('dashboard');
		}
		else
		{
			return view('admin.login');	
		}
	}

	public function forgot_password_index(){
		if(Session::get('adminid')!=''){
			return redirect()->route('dashboard');
		}
		else
		{
			return view('admin.forgot_password');	
		}
	}

	public function set_password_index(){
		if(Session::get('adminid')!=''){
			return redirect()->route('loginpage');
		}
		else
		{
			return view('admin.set_password');	
		}
	}


	public function forgot_password_check(Request $request){
		if(Session::get('adminid')!=''){
			return redirect()->route('dashboard');
		}
		else
		{
			if(!isset($request->hid) OR !is_numeric($request->hid) OR !isset($request->username) OR $request->username==''){
            Session::flash('msg', 'Invalid Value !!');
            return redirect()->back();
        	}

	        $user =  Admin::where('email', trim($request->username))->where('email','!=', '')->where('is_active', constants('is_active_yes'))->first();

			if(!empty($user)){
				$new_otp = mt_rand(11111,999999);
				Session::put('forgotemail', $user->email);
				Admin::where('email', $user->email)->update(['otp' => $new_otp ]);

				$subject = "Otp";
            	$maildata =
            	[
                "otp" => $new_otp ,
                "email_address" => $user->email,
            	];

            $html = 'Otp';

            $useremail = $user->email;
            $username = $user->fullname;

            sendMail($html, $useremail, $username, $subject,$maildata);


				return redirect()->route('set-password');
			}
			else
			{
				Session::flash('msg', 'User not found !');
	            return redirect()->back();
			}
		}

	}


	public function forgot_password_set(Request $request){

		try {

			if(!isset($request->hid) OR !is_numeric($request->hid) OR !isset($request->otp) OR $request->otp=='' OR !isset($request->email) OR $request->email=='' OR !isset($request->password) OR $request->password==''){
            Session::flash('msg', 'Please check Properly, Something Went Wrong. Please Try Again!!');
            return redirect()->back();
        	}

			$count = Admin::where('email', $request->email)->where('is_active', constants('is_active_yes'))->where('otp', $request->otp)->first();
				if(!empty($count)){
					Admin::where('id', $count->id)->update(['password' => bcrypt($request->password) ]);
					$request->session()->flush();
					Session::flash('msg', 'Password Has been Reset, Please login with new password');
					return redirect()->route('loginpage');
				}
				else
				{
					Session::flash('msg', 'OTP not Matched');
		            return redirect()->back();
				}
			} catch (\Exception $e) {

				Session::flash('msg', 'Please check Properly, Something Went Wrong. Please Try Again!!');
	            return redirect()->back();
        }

	}
	

    public function login(Request $request){
    	if(!isset($request->hid) OR !is_numeric($request->hid) OR !isset($request->username) OR $request->username=='' OR !isset($request->password) OR $request->password==''){
            Session::flash('msg', 'Invalid Value !!');
            return redirect()->route('loginpage');
        }

        $sql = 'SELECT a.id,a.password,a.email,a.fullname,a.role FROM '.$this->tbl.' a where (a.email="'.trim($request->username).'" OR ( a.mobile="'.trim($request->username).'" and a.mobile!="")) and a.is_active="1" LIMIT 1';
		$user = qry($sql);


		if(!empty($user)){
			if (!password_verify($request->password, $user[0]->password)) 
			{
    			Session::flash('msg', 'Email or Password is wrong !');
            	return redirect()->route('loginpage');
			}
			else
			{
				Session::put('adminid', $user[0]->id);
				Session::put('fullname', $user[0]->fullname);
				Session::put('email', $user[0]->email);
				Session::put('adminrole', $user[0]->role);
				return redirect()->route('dashboard');
			}
		}
		else
		{
			Session::flash('msg', 'User not found !');
            return redirect()->route('loginpage');
		}
	}





}
