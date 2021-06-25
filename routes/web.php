<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminManage;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\ProductnServiceController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\BillsController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(array('middleware' => ['checkLogin']), function () {
	Route::prefix(env('ADMINBASE_NAME'))->group(function () {


		/*---------------------------*/

		Route::get('admin-list', [AdminManage::class, 'index'])->name('admin-list');
		Route::get('admin-getedit', [AdminManage::class, 'getedit'])->name('admin-getedit');
		Route::get('get-admin-list', [AdminManage::class, 'getdata'])->name('get-admin-list');
		Route::post('add-update-admin', [AdminManage::class, 'Add_Or_Update'])->name('add-update-admin');



		/*----------sales--income----starts----------*/
		Route::get('product-services-sales-list', [ProductnServiceController::class, 'index_sale'])->name('product-services-sales-list');
		Route::get('product-services-sales', [ProductnServiceController::class, 'addedit_index_sale'])->name('product-services-sales');
		Route::post('add-update-product-services', [ProductnServiceController::class, 'Add_Or_Update'])->name('add-update-product-services');
		Route::post('add-update-product-services-direct', [ProductnServiceController::class, 'Add_Or_Update_Ajax'])->name('add-update-product-services-direct');

		Route::get('get-productnservices', [ProductnServiceController::class, 'getdata'])->name('get-productnservices');
		Route::post('change-productnservices-status-deleted', [ProductnServiceController::class, 'change_status_confirm'])->name('change-productnservices-status-deleted');
		Route::get('productservice-getedit', [ProductnServiceController::class, 'getedit'])->name('productservice-getedit');

		/*-----------sales--income------ends-----------*/
		/*----------purchase--expense-----starts-----------*/
		Route::get('product-services-expense-list', [ProductnServiceController::class, 'index_expense'])->name('product-services-expense-list');
		Route::get('product-services-expense', [ProductnServiceController::class, 'addedit_index_expense'])->name('product-services-expense');

		Route::post('change-pns-deleted', [ProductnServiceController::class, 'change_pns_deleted'])->name('change-pns-deleted');
		/*----------purchase--expense-----ends-----------*/


		/*---------customer----starts-----------*/
		Route::get('customer-list', [CustomerController::class, 'index'])->name('customer-list');
		Route::get('customers-getedit', [CustomerController::class, 'getedit'])->name('customers-getedit');
		Route::get('get-customer-list', [CustomerController::class, 'getdata'])->name('get-customer-list');
		Route::post('add-update-customer', [CustomerController::class, 'Add_Or_Update'])->name('add-update-customer');
		Route::post('CustomerInDropDown', [CustomerController::class, 'CustomerInDropDown'])->name('CustomerInDropDown');
		Route::post('get-income-subcategory-in-select', [CustomerController::class, 'Income_SubcategoryInDropDown'])->name('get-income-subcategory-in-select');
		Route::post('change-customer-deleted', [CustomerController::class, 'change_customer_deleted'])->name('change-customer-deleted');

		/*------invoice-----------*/

		Route::get('invoice-list', [InvoiceController::class, 'index'])->name('invoice-list');
		Route::get('invoices-getedit', [InvoiceController::class, 'getedit'])->name('invoices-getedit');
		Route::post('add-update-invoice-record-payment', [InvoiceController::class, 'invoice_record_payment'])->name('add-update-invoice-record-payment');
		Route::post('download-customer-invoice', [PdfController::class, 'download_customer_invoice'])->name('download-customer-invoice');
		Route::post('draft-invoice-approve', [InvoiceController::class, 'draft_invoice_approve'])->name('draft-invoice-approve');
		Route::get('invoices', [InvoiceController::class, 'addedit_index'])->name('invoices');
		Route::get('get-invoice-list', [InvoiceController::class, 'getdata'])->name('get-invoice-list');
		Route::get('get-invoice-list-draft', [InvoiceController::class, 'getdata_draft'])->name('get-invoice-list-draft');
		Route::get('get-invoice-list-unpaid', [InvoiceController::class, 'getdata_unpaid'])->name('get-invoice-list-unpaid');
		Route::post('add-update-invoice', [InvoiceController::class, 'Add_Or_Update'])->name('add-update-invoice');
		Route::get('makeduplicate-invoice', [InvoiceController::class, 'makeduplicate'])->name('makeduplicate-invoice');
		Route::post('salesproductnservicesInDropDown', [InvoiceController::class, 'salesproductnservicesInDropDown'])->name('salesproductnservicesInDropDown');
		Route::post('change-invoice-deleted', [InvoiceController::class, 'change_invoice_deleted'])->name('change-invoice-deleted');

		/*------invoice-----------*/
		


		/*---------customer----ends-----------*/

		/*---------vendor----starts-----------*/
		Route::get('vendor-list', [VendorController::class, 'index'])->name('vendor-list');
		Route::get('get-vendor-list', [VendorController::class, 'getdata'])->name('get-vendor-list');
		Route::post('add-update-vendor', [VendorController::class, 'Add_Or_Update'])->name('add-update-vendor');
		Route::post('change-vendor-deleted', [VendorController::class, 'change_vendor_deleted'])->name('change-vendor-deleted');

		/*------bills-----------*/
		Route::get('bills-list', [BillsController::class, 'index'])->name('bills-list');
		Route::get('bills-getedit', [BillsController::class, 'getedit'])->name('bills-getedit');
		Route::get('bills', [BillsController::class, 'addedit_index'])->name('bills');
		Route::post('add-update-bills', [BillsController::class, 'Add_Or_Update'])->name('add-update-bills');
		Route::get('get-bills-list', [BillsController::class, 'getdata'])->name('get-bills-list');
		Route::post('VendorInDropDown', [VendorController::class, 'VendorInDropDown'])->name('VendorInDropDown');
		Route::get('vendors-getedit', [VendorController::class, 'getedit'])->name('vendors-getedit');
		Route::post('expensesproductnservicesInDropDown', [BillsController::class, 'expensesproductnservicesInDropDown'])->name('expensesproductnservicesInDropDown');
		Route::get('makeduplicate-bill', [BillsController::class, 'makeduplicate'])->name('makeduplicate-bill');
		Route::post('add-update-bill-record-payment', [BillsController::class, 'bill_record_payment'])->name('add-update-bill-record-payment');

		Route::post('change-bills-deleted', [BillsController::class, 'change_bills_deleted'])->name('change-bills-deleted');


		

		
		/*------bills-----------*/
		/*---------vendor----ends-----------*/



		/*---------category----starts-----------*/

		Route::get('category-list', [CategoryController::class, 'index'])->name('category-list');
		Route::post('add-update-maincategory', [CategoryController::class, 'addorupdatemaincategory'])->name('add-update-maincategory');
		Route::post('add-update-subcategory', [CategoryController::class, 'addorupdatesubcategory'])->name('add-update-subcategory');
		Route::post('change-subcategory-status', [CategoryController::class, 'changeSubcategoryStatus'])->name('change-subcategory-status');
		Route::get('get-maincategory-list', [CategoryController::class, 'getdata'])->name('get-maincategory-list');
		Route::get('get-subcategory-list', [CategoryController::class, 'getdatasubcategory'])->name('get-subcategory-list');
		Route::get('edit-maincategory-data', [CategoryController::class, 'getedit'])->name('edit-maincategory-data');
		Route::get('edit-subcategory-data', [CategoryController::class, 'geteditsub'])->name('edit-subcategory-data');
		Route::post('get-allmaincategory-data', [CategoryController::class, 'getAllMaincategory'])->name('get-allmaincategory-data');
		Route::post('get-allsubcategory-data', [CategoryController::class, 'getAllSubcategory'])->name('get-allsubcategory-data');
		Route::post('subcategoryInSelectDropdown', [CategoryController::class, 'subCategoryInDropDown'])->name('subcategoryInSelectDropdown');
		/*---------category----ends-----------*/



		/*---------Accounts----starts-----------*/
		Route::get('all-accounts-list', [AccountController::class, 'index'])->name('all-accounts-list');
		Route::get('edit-all-accounts', [AccountController::class, 'getedit'])->name('edit-all-accounts');
		Route::get('get-all-accounts-data', [AccountController::class, 'getdata'])->name('get-all-accounts-data');
		Route::post('add-update-all-accounts', [AccountController::class, 'Add_Or_Update'])->name('add-update-all-accounts');
		Route::post('accountsOrBanksInSelectDropdown', [AccountController::class, 'accountsOrBanksInSelectDropdown'])->name('accountsOrBanksInSelectDropdown');


		Route::get('transactions-list', [TransactionController::class, 'index'])->name('transactions-list');
		Route::get('get-transactions-data', [TransactionController::class, 'getdata'])->name('get-transactions-data');
		Route::post('add-update-transactions', [TransactionController::class, 'Add_Or_Update'])->name('add-update-transactions');
		Route::post('add-update-record-payment', [TransactionController::class, 'record_payment'])->name('add-update-record-payment');
		Route::get('getedit-transactions', [TransactionController::class, 'getedit'])->name('getedit-transactions');

		Route::post('change-transactions-deleted', [TransactionController::class, 'change_transactions_deleted'])->name('change-transactions-deleted');
		Route::post('change-transactions-reviewed', [TransactionController::class, 'change_transactions_reviewed'])->name('change-transactions-reviewed');


		Route::get('get-all-accounts-balanace', [TransactionController::class, 'getAllAcountBalanace'])->name('get-all-accounts-balanace');
		Route::post('transactions_export_excel', [TransactionController::class, 'export_excel'])->name('transactions_export_excel');

		
		



		/*---------Accounts----ends-----------*/


		/*---------company-configuration----starts-----------*/
		Route::get('company-configuration', [CompanyController::class, 'index'])->name('company-configuration');
		Route::post('update-company-details', [CompanyController::class, 'Add_Or_Update'])->name('update-company-details');
		/*---------company-configuration----ends-----------*/

		/*-----------Normal used Globally functions -----------------*/
		Route::get('log-out', [Dashboard::class, 'log_out'])->name('log-out');
		Route::get('dashboard', [Dashboard::class, 'index'])->name('dashboard');
		/*-----------Normal used Globally functions -----------------*/

		
	});
});

Route::post('/'.env('ADMINBASE_NAME').'/log-in', [LoginController::class, 'login'])->name('log-in');
Route::get('/'.env('ADMINBASE_NAME').'/loginpage', [LoginController::class, 'index'])->name('loginpage');
Route::get('/'.env('ADMINBASE_NAME').'/forgot-password', [LoginController::class, 'forgot_password_index'])->name('forgot-password');
Route::post('/'.env('ADMINBASE_NAME').'/reset-password', [LoginController::class, 'forgot_password_check'])->name('reset-password');
Route::post('/'.env('ADMINBASE_NAME').'/forgot-password-set', [LoginController::class, 'forgot_password_set'])->name('forgot-password-set');
Route::get('/'.env('ADMINBASE_NAME').'/set-password', [LoginController::class, 'set_password_index'])->name('set-password');



Route::get('/'.env('ADMINBASE_NAME'), function () {
    if (Session::has('adminid')) {
        return redirect()->route('dashboard'); 
    } else {
    	return redirect()->route('loginpage');
    }
})->name('loginscreen');





Route::get('/', function () {
    return view('welcome');
});
