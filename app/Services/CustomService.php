<?php


namespace App\Services;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Tax;
use App\Models\ShortHelper;
use App\Models\AccountBanks;


class CustomService
{

    public function Income_Subcategory()
        {
        try {
            $sql = 'SELECT sb.id,sb.main_category_id,sb.name,sb.details,sb.is_editable,mc.name as main_category_name FROM sub_category sb 
            INNER JOIN main_category mc ON mc.id=sb.main_category_id
            where sb.main_category_id IN ( '.constants('Income_Main_Category_Id').') and sb.is_active="1" ';
            $sub_category = qry($sql);
            return $sub_category;
        } catch (\Exception $e) {
            return [];
        }

    }

    public function Expense_Subcategory()
        {
        try {

            $sql = 'SELECT sb.id,sb.main_category_id,sb.name,sb.details,sb.is_editable,mc.name as main_category_name FROM sub_category sb 
            INNER JOIN main_category mc ON mc.id=sb.main_category_id
            where sb.main_category_id IN ( '.constants('Expense_Main_Category_Id').') and sb.is_active="1" ';
            $sub_category = qry($sql);
            return $sub_category;

        } catch (\Exception $e) {
            return [];
        }

    }

    public function Tax()
        {
        try {
            $response = Tax::where('is_active', constants('is_active_yes'))->orderBy('id','ASC')->get();
            return $response;
        } catch (\Exception $e) {
            return [];
        }

    }

    public function Account_Category()
        {
        try {

            $sql = 'SELECT ac.* FROM account_category ac where ac.is_active="1" limit 1000';
            $data = qry($sql);
            return $data;
        } catch (\Exception $e) {
            return [];
        }

    }

    public function ShortHelper($type)
        {
        try {
            $response = ShortHelper::where('is_active', constants('is_active_yes'))->where('type',$type)->orderBy('id','ASC')->limit(250)->get();
            return $response;
        } catch (\Exception $e) {
            return [];
        }

    }

    public function AccountnBanks()
        {
        try {
            $response = AccountBanks::where('is_active', constants('is_active_yes'))->orderBy('id','ASC')->limit(250)->get();
            return $response;
        } catch (\Exception $e) {
            return [];
        }

    }


    public function subCategoryInDropDown(){
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

            ->where(function($searchTermQry) use ($searchTerm) {
                    $searchTermQry->where('name','LIKE', '%'.$searchTerm.'%')
                            ->orwhere('name2','LIKE', '%'.$searchTerm.'%')
                            ->orwhere('details','LIKE', '%'.$searchTerm.'%');
            })
            ->orderBy('id','ASC')
            ->limit(600)
            ->get(['name AS text', 'id as id']);

            return $response;
        } catch (\Exception $e) {
            return [];
        }
    }







}
