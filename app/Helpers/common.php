<?php

use App\Services\CustomService;
date_default_timezone_set('Asia/Kolkata');
use App\Models\LogsDeleted;
use App\Models\Company;


function dde($arr){
	echo "<pre>"; print_r($arr); die;
}

function random_text($length_of_string = 8) {
    $chr = 'GHIJKLA123MNOSTUVW0XYZPQR456789BCDEF'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $length_of_string; $i++) { 
        $index = rand(0, strlen($chr) - 1); 
        $randomString .= $chr[$index]; 
    }   
    return $randomString; 
}

function random_number($length_of_string = 8) {
    $chr = '1234506789'; 
    $randomString = ''; 
    for ($i = 0; $i < $length_of_string; $i++) { 
        $index = rand(0, strlen($chr) - 1); 
        $randomString .= $chr[$index]; 
    }   
    return '9'.$randomString; 
}

function qry($str,$return_in_array=0){
    $data = DB::select($str);
    if($return_in_array!=1){
        return $data;
    }
    else
    {
        return json_decode(json_encode($data), true);
    }
    
}
function insert_data($tbl,$data){
	DB::table($tbl)->insert($data);
}

function insert_data_id($tbl,$data){
	$id = DB::table($tbl)->insertGetId($data);
	return $id;
}

function update_data($tbl,$data,$con){
	$affected_id = DB::table($tbl)->where($con)->update($data);
	return $affected_id;
}

function UploadImage($file, $dir,$filename_prefix='') {
    $fileName = $filename_prefix.uniqid().time() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('storage'. '/'. $dir), $fileName);
    return $fileName;
}

function DeleteFile($filename, $dir) {
    $existImage = public_path('storage/'.$dir.'/'.$filename);
        if (File::exists($existImage)) {
            File::delete($existImage);
        }
    return 1;
}

function sendMail($html, $useremail, $username, $subject, $data =[]){
    Mail::send('admin.mail.forgot_otp', $data, function ($message) use ($useremail,$username,$subject) {
            $message->from('xyz@gmail.com', 'account')
                ->to($useremail, $username)
                ->subject($subject);
    });
    return 1;
}

function constants($key=''){
    if(trim($key=='')){
        return 0;
    }
    else
    {
        return Config::get('constants.'.$key);
    }
}

function getIncome_Subcategory(){
    $data = (new CustomService())->Income_Subcategory();
    return $data;
}

function getExpense_Subcategory(){
    $data = (new CustomService())->Expense_Subcategory();
    return $data;
}

function getAccount_Category(){
    $data = (new CustomService())->Account_Category();
    return $data;
}


function getTax(){
    $data = (new CustomService())->Tax();
    return $data;
}

function ShortHelper($type=''){
    $data = (new CustomService())->ShortHelper($type);
    return $data;
}

function AccountnBanks(){
    $data = (new CustomService())->AccountnBanks();
    return $data;
}

function getLastNDays($days, $format = 'd/m'){
    $m = date("m"); $de= date("d"); $y= date("Y");
    $dateArray = array();
    for($i=0; $i<=$days-1; $i++){
        $dateArray[] = date($format, mktime(0,0,0,$m,($de-$i),$y)); 
    }
    return array_reverse($dateArray);
}

function sendPath($dir=''){
    return asset('storage').'/'.$dir.'/';
}

function CreateLogsDeletedData($dataDeleted=[]){
    $e = new LogsDeleted;
    $e->data = json_encode($dataDeleted);
    $e->save();
    $from = "2000-01-01";
    $to = date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
    LogsDeleted::whereBetween('created_at', [$from, $to])->delete();
}

function getCompanyConfiguration(){
    return Company::where('id', Config::get('constants.company_configurations_id'))->orderBy('id','ASC')->first();
}















