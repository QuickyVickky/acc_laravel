@include('admin.layout.meta') 

<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar')
  <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/bootstrap-multiselect.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/assets/css/daterangepicker.min.css') }}">
  <style>
  .opacitydowncls {
	  opacity:0.6;
	  }
	  .btn-group {
					 width:100%;
				 }
  </style>
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header"> @if(Session::get("msg")!='')
              <div class="alert alert-{{ Session::get("cls") }} alert-dismissible fade show" role="alert">{{ Session::get("msg") }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              </div>
              @endif
              <h4 class="card-title">{{ $control }} <a style="cursor: pointer;" class="btn btn-info float-right" id="add_income_a_id" data-val="Cr">Add Income</a><a style="cursor: pointer;" class="btn btn-warning float-right" id="add_expense_a_id" data-val="Dr">Add Expense</a></h4>
            </div>
            <!---- transaction ---->
            
            <div class="btn-group card-header">
              <button type="button" class="btn dropdown-toggle transaction-box" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="transaction-name"> <span id="all_account_span_htmlid">All Accounts</span> </div>
              <div class="transaction-rs d-flex align-items-center">
                <div> <span class="all_final_amount_accountscls" id="all_accountamount_span_htmlid">&#8377; 0.00</span> </div>
                <div class="transaction-toggle-arrow"> <span><i class="fas fa-sort-down"></i></span> </div>
              </div>
              </button>
              <div class="dropdown-menu transaction-toggle-menu-box">
                <div id="alldatabalanceidhtml"></div>
                <div class="transaction-menu-label transaction-all-a-c "> <a class="d-flex transaction-toggle-menu-cash accountbanks_idclickcls" data-id="" data-name="All Accounts" data-amount="" id="allamount_accountbanks_idclickcls">
                  <p>All Accounts</p>
                  <p class="all_final_amount_accountscls">&#8377; 0.00</p>
                  </a> </div>
                <a style="cursor: pointer;" onclick="show_add_newaccountModal()">
                <div class="transaction-menu-label transaction-menu-button text-center"> <i class="fas fa-plus-circle"></i> Add a new account </div>
                </a> </div>
            </div>
            <form method="post" action="{{ route('transactions_export_excel') }}" enctype="multipart/form-data" id="myExcelForm">
              @csrf
              <div class="card-header">
                <div class="row">
                  <div class="form-group col-md-4">
                    <label>All Category </label>
                    <select id="filter_global_subcategory_id" name="subcategory_id[]" class="transaction_filter_multi_selectid" multiple="multiple">
                      
@foreach($subCategoryInDropDown as $sb)

                      <option value="{{ $sb->id }}"  selected="selected"> {{ $sb->text }}</option>
                      
@endforeach

                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label>All Type </label>
                    <select id="filter_global_transaction_type" name="transaction_type[]" class="transaction_filter_multi_selectid" multiple="multiple">
 				@foreach(ShortHelper("deposit_or_withdrawal") as $dw)
                      <option value="{{ $dw->short }}" selected="selected">{{ $dw->name }}</option>
 				@endforeach

                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Transaction Date </label>
                    <input type="text" id="filter_global_transaction_date" class="form-control" placeholder="Select Date" name="filter_global_transaction_date" required="required" value="" autocomplete="off">
                  </div>
                  <div class="form-group col-md-2">
                    <label>All Status </label>
                    <select id="filter_global_reviewed" name="filter_global_reviewed[]" class="transaction_filter_multi_selectid" multiple="multiple">
                      
@foreach(ShortHelper("is_reviewed_type") as $rt)

                      <option value="{{ $rt->short }}" selected="selected">{{ $rt->name }}</option>
                      
@endforeach
     

                    </select>
                  </div>
                  <input type="hidden" name="filter_global_accountbanks_id" id="filter_global_accountbanks_id" value="">
                  <div class="form-group col-md-3"> <a class="btn btn-outline-success" id="Apply_Filter_Btn_Id" onclick="getAllTransactionsData()"> Apply Filter</a> <a class="btn btn-outline-info" id="Export_Excel_Filter_Btn_Id" onclick="$('#myExcelForm').submit()"> Export Excel</a> </div>
                </div>
              </div>
            </form>
            <!---- transaction ---->
            
            <div class="card-body">
              <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab" id="ahref-bottom-tab1">{{ $control }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab" id="ahref-bottom-tab2" style="display:none;">Add/Edit</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane show active" id="bottom-tab1">
                  <div class="table">
                    <table id="t1" class="datatable table table-stripped" style="width:100%">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Description</th>
                          <th>Amount &#x20B9;</th>
                          <th>Details</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane show" id="bottom-tab2">
                  <form id="new_transactionformid">
                    @csrf
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>Description (required)</label>
                        <input type="text" name="new_transaction_description" class="form-control" id="new_transaction_description" placeholder="Description" value="" required="required">
                      </div>
                      <div class="form-group col-md-2">
                        <label> Date * </label>
                        <input type="date" name="new_transaction_paymentdate" class="form-control" id="new_transaction_paymentdate" value="{{ date('Y-m-d') }}" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-2">
                        <label>Deposit or Withdraw * </label>
                        <select class="form-control" name="new_transaction_deposit_or_withdrawal_id" id="new_transaction_deposit_or_withdrawal_id" required>
                          
                    @foreach(ShortHelper("deposit_or_withdrawal") as $dw)
                          
                          <option value="{{ $dw->short }}" >{{ $dw->name }}</option>
                          
                      @endforeach
                    
                        
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label>Amount *</label>
                        <input type="text" name="new_transaction_record_payment_amount_id" class="form-control" id="new_transaction_record_payment_amount_id" placeholder="Amount" value="0.00" maxlength="17" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8 || event.keyCode === 46;">
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label> Account * </label>
                        <select class="form-control" name="new_transaction_accounts_or_banks_id" id="new_transaction_accounts_or_banks_id" required>
                          
                    @foreach(AccountnBanks() as $ab)
                          
                          <option value="{{ $ab->id }}" >{{ $ab->name }}</option>
                          
                      @endforeach
                    
                        
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label>Payment Type * </label>
                        <select class="form-control" name="new_transaction_payment_method_id" id="new_transaction_payment_method_id" required>
                          
                      @foreach(ShortHelper("payment_method") as $pm)
                          
                          <option value="{{ $pm->short }}" >{{ $pm->name }}</option>
                          
                      @endforeach
                    
                        
                        </select>
                      </div>
                    </div>
                    <!----hidden values-------------->
                    <input type="hidden" name="hidden_bill_id" id="hidden_bill_id" value="0" >
                    <input type="hidden" name="hidden_invoice_id" id="hidden_invoice_id" value="0" >
                    <input type="hidden" name="hidden_main_category_id" id="hidden_main_category_id" value="0" >
                    <input type="hidden" name="hidden_sub_category_id" id="hidden_sub_category_id" value="0" >
                    <input type="hidden" name="hidden_transaction_id" id="hidden_transaction_id" value="0" >
                    <input type="hidden" name="hidden_accounts_or_banks_id_transfer_fromto" id="hidden_accounts_or_banks_id_transfer_fromto" value="0" >
                    <!----hidden values-------------->
                    <div class="row" id="select_sub_category_from_select2_rowid">
                      <div class="form-group col-md-6">
                        <label>Select Category * </label>
                        <select class="form-control select_sub_category_from_select2_dropdownidcls"  name="select_sub_category_from_select2_dropdownid" id="select_sub_category_from_select2_dropdownid">
                          <!--option value="0">Please Select</option-->
                        </select>
                      </div>
                    </div>
                    <div class="row" id="select_accounts_or_banks_id_transfer_from_select2_rowid" style="display:none;">
                      <div class="form-group col-md-6">
                        <label>Select Bank * </label>
                        <select class="form-control select_accounts_or_banks_id_transfer_from_select2_dropdownidcls"  name="select_accounts_or_banks_id_transfer_from_select2_dropdownid" id="select_accounts_or_banks_id_transfer_from_select2_dropdownid">
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label>Notes (optional)</label>
                        <textarea type="text" rows="3" name="new_transaction_notes" class="form-control" id="new_transaction_notes" placeholder="Notes"></textarea>
                      </div>
                    </div>
                    <hr />
                    <div class="text-right">
                      <button type="button" class="btn btn-primary float-right" id="new_transactionformsaveid">Save</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Page Wrapper --> 
  
</div>

<!------modal ---------download------invoice---------pdf------------->
<div class="modal fade" id="invoice_downloadpdfModal" tabindex="-1" role="dialog" aria-labelledby="invoice_downloadpdfModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="invoice_downloadpdfModalLabel">Export to PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form id="invoice_downloadpdf_formid" method="post"  enctype="multipart/form-data">
        <div class="modal-body"> @csrf
          <input type="hidden" name="hidden_invoiceid_download" id="hidden_invoiceid_download" value="0" required="required">
          <h4>Your invoice is ready to be downloaded as a PDF.</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="invoice_downloadpdf_submitbtnid">Download PDF</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!------modal ---------download------invoice---------pdf-------------> 

<!-- /Main Wrapper --> 
@include('admin.layout.js') 
<script src="{{ asset('admin_assets/assets/js/bootstrap-multiselect.min.js') }}"></script> 
<script src="{{ asset('admin_assets/assets/js/daterangepicker.min.js') }}"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('.transaction_filter_multi_selectid').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
			 maxHeight: 300,
        });
		
    });
	$(document).ready(function () {
	getAllTransactionsData() 
   getTransactionAllAcountBalanace();
   $('#filter_global_transaction_date').val('');
});

</script> 
<script type="text/javascript">
     var t1; var t2;  var t3; 
	$.fn.dataTable.ext.errMode = 'none'; errorCount = 1;
	$('#t1').on('error.dt', function(e, settings, techNote, message) {
   		if(errorCount>2){
   		//showSweetAlert('something went wrong','please refresh page and try again...', 0); 
		}
		else
		{
			t1.draw();
		}
		errorCount++;
	});




<!------------filter---------------------->
$("#select_allsub_category_from_select2_dropdownid").select2({
    		placeholder: "All Category",
    		width:"100%",
                ajax: {
					url: "{{ route('subcategoryInSelectDropdown') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                     data: function (params) {
                        return {
                            searchTerm: params.term ,
							_token:'{{ csrf_token() }}',
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
 });	
<!------------filter---------------------->


function getAllTransactionsData() {
	accountbanks_id = $("#filter_global_accountbanks_id").val();
	subcategory_id = $("#filter_global_subcategory_id").val();
	transaction_type = $("#filter_global_transaction_type").val();
	filter_global_transaction_date =  $("#filter_global_transaction_date").val();
	reviewed = $("#filter_global_reviewed").val();
	
	
	t1 = $('#t1').DataTable({
    processing: true,
	destroy: true,
	language: {
		processing: processingHTML_Datatable,
  	},
	serverSide: true,
 	paging: true,
	 searching: true,
    lengthMenu: [[10, 50, 100,500,1000], [10, 50, 100,500,1000]],
	pageLength: 100, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: { 
	accountbanks_id:accountbanks_id,
	subcategory_id:subcategory_id,  
	transaction_type:transaction_type,  
	filter_global_transaction_date:filter_global_transaction_date,  
	reviewed:reviewed, 
	},
    url: "{{ route('get-transactions-data') }}" ,
	type: "get" 
	},
    aoColumnDefs: 
	[{ 
		'bSortable': false,
		 'aTargets': [-1] 
	}],
   }); 
	
}
	
	function getTransactionAllAcountBalanace() {
		$.ajax({
            url: "{{ route('get-all-accounts-balanace') }}",
            data: {
              _token:'{{ csrf_token() }}',
              testonly: 1,
            },
            type: 'get',
            dataType: 'json',
            success: function (e) {
				ehtml = '';
				final_amount = 0;

				for(var i=0; i<e.CrData.length; i++){
					ehtml += '<div class="transaction-menu-label"><label>'+e.CrData[i].name+'</label>';
						for(var j=0; j<e.CrData[i].all_account_banks.length; j++){
							     this_amount = parseFloat(e.CrData[i].all_account_banks[j].sumCr - e.DrData[i].all_account_banks[j].sumDr);
								 final_amount += this_amount;
                    			ehtml += '<div><a class="d-flex transaction-toggle-menu-cash accountbanks_idclickcls" data-id="'+e.CrData[i].all_account_banks[j].id+'" data-name="'+e.CrData[i].all_account_banks[j].name+'" data-amount="'+this_amount.toFixed(2)+'"><p>'+e.CrData[i].all_account_banks[j].name+'</p><p>&#8377; '+this_amount.toFixed(2)+'</p></a></div>';
						}
                    ehtml += '</div><hr class="transaction-hr-margin">';
				}
				$("#alldatabalanceidhtml").html(ehtml);
				$(".all_final_amount_accountscls").html("&#8377; " +final_amount.toFixed(2));
				$("#allamount_accountbanks_idclickcls").attr("data-amount",final_amount.toFixed(2));
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An Error Occurred, Please Refresh Page and Try again.', 0); 
            },
        });
	}

$('body').on('click', '.accountbanks_idclickcls', function () {
	var dataid = $(this).data('id');
	var amount = $(this).data('amount');
	var name = $(this).data('name');
	$('#filter_global_accountbanks_id').val(dataid);
	$('#all_accountamount_span_htmlid').html("&#8377; " +amount);
	$('#all_account_span_htmlid').html(name);
});


				
</script> 
<script type="text/javascript">
$('body').on('click', '#add_expense_a_id', function () {
	$('#new_transactionformid')[0].reset();
	$("#hidden_transaction_id,#hidden_accounts_or_banks_id_transfer_fromto").val(0);
	var Main_Category_Id = "{{ constants('Expense_Main_Category_Id') }}";
	$("#hidden_main_category_id").val(Main_Category_Id);
	var val = $(this).data('val');
	$("#ahref-bottom-tab2").click();
	$("#ahref-bottom-tab2").css("display", "block");
	$("#new_transaction_deposit_or_withdrawal_id").val(val);
	$("#new_transactionformsaveid").css('display','block');
	$('#new_transaction_record_payment_amount_id,#new_transaction_deposit_or_withdrawal_id,#select_sub_category_from_select2_dropdownid').prop('disabled',false);
	$("#myExcelForm").hide();
});

$('body').on('click', '#add_income_a_id', function () {
	$('#new_transactionformid')[0].reset();
	$("#hidden_transaction_id,#hidden_accounts_or_banks_id_transfer_fromto").val(0);
	var Main_Category_Id = "{{ constants('Income_Main_Category_Id') }}";
	$("#hidden_main_category_id").val(Main_Category_Id);
	var val = $(this).data('val');
	$("#ahref-bottom-tab2").click();
	$("#ahref-bottom-tab2").css("display", "block");
	$("#new_transaction_deposit_or_withdrawal_id").val(val);
	$("#new_transactionformsaveid").css('display','block');
	$('#new_transaction_record_payment_amount_id,#new_transaction_deposit_or_withdrawal_id,#select_sub_category_from_select2_dropdownid').prop('disabled',false);
	$("#myExcelForm").hide();
});

</script> 
<script>
$('body').on('click', '#ahref-bottom-tab1', function () {
$("#ahref-bottom-tab2").css("display", "none");
$("#myExcelForm").show();
});
$('body').on('click', '#add_expense_a_id,#add_income_a_id', function () {
$("#select_sub_category_from_select2_dropdownid").select2("val", 0);
});



$('body').on('change', '#new_transaction_deposit_or_withdrawal_id', function () {
$("#select_sub_category_from_select2_dropdownid").select2("val", 0);
$("#select_accounts_or_banks_id_transfer_from_select2_dropdownid").select2("val", 0);
	var eTrans_Type = $("#new_transaction_deposit_or_withdrawal_id").val();

	if(eTrans_Type=="Dr"){
		var Main_Category_Id = "{{ constants('Expense_Main_Category_Id') }}";
		$("#hidden_main_category_id").val(Main_Category_Id);
	}
	else
	{
		var Main_Category_Id = "{{ constants('Income_Main_Category_Id') }}";
	    $("#hidden_main_category_id").val(Main_Category_Id);
	}
});


//function select2d(){
$("#select_sub_category_from_select2_dropdownid").select2({
    		placeholder: "Select A Category",
    		width:"100%",
                ajax: {
					url: "{{ route('subcategoryInSelectDropdown') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                     data: function (params) {
                        return {
                            searchTerm: params.term ,
							_token:'{{ csrf_token() }}',
							'main_category_id': $("#hidden_main_category_id").val(), 
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
 });	
//}


$('body').on('click', '#new_transactionformsaveid', function () {
        var hidden_transaction_id = $('#hidden_transaction_id').val();
		var hidden_accounts_or_banks_id_transfer_fromto = $('#hidden_accounts_or_banks_id_transfer_fromto').val();
		var select_sub_category_from_select2_dropdownid = $('#select_sub_category_from_select2_dropdownid').val();
		var select_accounts_or_banks_id_transfer_from_select2_dropdownid = $('#select_accounts_or_banks_id_transfer_from_select2_dropdownid').val();
		var new_transaction_description = $('#new_transaction_description').val();
		var new_transaction_paymentdate = $('#new_transaction_paymentdate').val();
		var new_transaction_record_payment_amount_id = $('#new_transaction_record_payment_amount_id').val();
		var new_transaction_deposit_or_withdrawal_id = $('#new_transaction_deposit_or_withdrawal_id').val();
		var new_transaction_accounts_or_banks_id = $('#new_transaction_accounts_or_banks_id').val();
		var new_transaction_payment_method_id = $('#new_transaction_payment_method_id').val();
		var new_transaction_notes = $('textarea#new_transaction_notes').val();
		var hidden_bill_id = $('#hidden_bill_id').val();
		var hidden_invoice_id = $('#hidden_invoice_id').val();
		
	
        if(hidden_transaction_id<0 || new_transaction_paymentdate.length!=10 || new_transaction_deposit_or_withdrawal_id.length!=2 || new_transaction_accounts_or_banks_id<1 || select_sub_category_from_select2_dropdownid<1 || new_transaction_payment_method_id<1 || new_transaction_record_payment_amount_id=='' || new_transaction_description=='' || hidden_accounts_or_banks_id_transfer_fromto!=0){
		 showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }

        $("#new_transactionformsaveid").css('display','none');
		
     $.ajax({
            url: "{{ route('add-update-record-payment') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: 0, 
              payment_method: new_transaction_payment_method_id,
			  transaction_date: new_transaction_paymentdate,
			  sub_category_id:select_sub_category_from_select2_dropdownid,
			  accounts_or_banks_id_transfer_fromto: select_accounts_or_banks_id_transfer_from_select2_dropdownid,
			  amount: new_transaction_record_payment_amount_id,
			  accounts_or_banks_id: new_transaction_accounts_or_banks_id,
			  description: new_transaction_description,
			  is_editable : 1,
			  is_active: 1,
			  transaction_type: new_transaction_deposit_or_withdrawal_id,
			  transactions_id : hidden_transaction_id,
			  notes: new_transaction_notes,
			  invoice_id:hidden_invoice_id,
			  bills_id:hidden_bill_id,
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				if(e.success==1){
					showSweetAlert("Completed",e.msg, 1); 
				}
				else
				{
					showSweetAlert("Wrong",e.msg, 0); 
				}
              	t1.draw();
				$("#new_transactionformsaveid").css('display','block');
				$("#ahref-bottom-tab1").click();
				getTransactionAllAcountBalanace();
            },
			error: function(jqXHR, textStatus, errorThrown) {
                showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
  });
  
  
 $('body').on('click', '.editit', function () {
	var dataidx = $(this).data('id');
	$('#new_transaction_record_payment_amount_id,#new_transaction_deposit_or_withdrawal_id,#select_sub_category_from_select2_dropdownid').prop('disabled',false);
	
	$.ajax({
            url: "{{ route('getedit-transactions') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: dataidx,
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data !== 'undefined' && data != null) {
					if((data.sub_category_id>0 && data.bills_id==0 && data.invoice_id==0) || (data.sub_category_id>0 && data.bills_id>0 && data.invoice_id==0) || (data.sub_category_id>0 && data.bills_id==0 && data.invoice_id>0)){
						var transaction_date = data.transaction_date.substring(0, 10);
						$('#add_income_a_id').click();
						$('#hidden_transaction_id').val(data.id);
						$('#hidden_invoice_id').val(data.invoice_id);
						$('#hidden_bill_id').val(data.bills_id);
						$('#new_transaction_description').val(data.description);
						$('#new_transaction_paymentdate').val(transaction_date);
						$('#new_transaction_record_payment_amount_id').val(data.amount);
						$('#new_transaction_deposit_or_withdrawal_id').val(data.transaction_type);
						$('#new_transaction_accounts_or_banks_id').val(data.accounts_or_banks_id);
						$('#new_transaction_payment_method_id').val(data.payment_method);
						$('#new_transaction_notes').val(data.notes);
						$('#hidden_sub_category_id').val(data.sub_category_id);
						$('#select_sub_category_from_select2_dropdownid').html("<option value="+data.sub_category_id+">"+data.sub_category.name+"</option>");
						$('#hidden_main_category_id').val(data.sub_category.main_category_id);
						
						
					}
					if(data.invoice_id>0 || data.bills_id>0)
					{
						$('#new_transaction_record_payment_amount_id,#new_transaction_deposit_or_withdrawal_id,#select_sub_category_from_select2_dropdownid').prop('disabled',true);
					}
					if(data.accounts_or_banks_id_transfer_fromto>0)
					{
						$('#new_transactionformsaveid').hide();
					}
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
	
});


$('body').on('click', '.deleteit', function () {
		var id = $(this).data('id');
  swal({
      title: 'Are You Sure ?',
      text: "Do You Want to Delete This ?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      padding: '-2em'
    }).then(function(result) {
      if (result.value) {
		  
		 $.ajax({
            url: "{{ route('change-transactions-deleted') }}",
            data: {
              _token : '{{ csrf_token() }}',
              id: id,
			  status: 2, 
            },
            type: 'post',
            dataType: 'json',
            success: function (data) {
             t1.draw(); 
			 getTransactionAllAcountBalanace();
			  toast({
				type: 'success',
				title: 'Deleted Successfully.',
				padding: '2em',
			  })

            },  error: function(){ showSweetAlert('Something Went Wrong!','please refresh page and try again', 0);  }
        });

      }
    });
});

$('body').on('click', '.reviewit', function () {
		var id = $(this).data('id');
		var review = $(this).data('review');

		 $.ajax({
            url: "{{ route('change-transactions-reviewed') }}",
            data: {
              _token : '{{ csrf_token() }}',
              id: id,
			  status: review, 
            },
            type: 'post',
            dataType: 'json',
            success: function (data) {
             t1.draw(); 
			  toast({
				type: 'success',
				title: data.msg,
				padding: '2em',
			  })
            },  error: function(){ showSweetAlert('Something Went Wrong!','please refresh page and try again', 0);  }
        });

 
});

</script> 
<script type="text/javascript">
$(function () {
            var start = moment().subtract(365, 'days'); //new Date();
            var end = new Date();

            function cb(start, end) {
                /*$('#filter_global_transaction_date').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));*/
            }

            $('#filter_global_transaction_date').daterangepicker({
                autoUpdateInput: true,
                maxDate: moment().endOf("day"),
                startDate: start,
                endDate: end,
                ranges: {
					'Last 365 Days': [moment().subtract(365, 'days'), moment()],
					'Last 30 Days': [moment().subtract(30, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Today': [moment(), moment()],
                    'Last 7 Days': [moment().subtract(7, 'days'), moment()],
                }, locale: {
                    format: 'YYYY-MM-DD'
                }
            }, cb);

            /*$('input[name="date"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });*/
             $('input[name="date"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });
		
$(document).ready(function () {
   $('#filter_global_transaction_date').val('');
});
</script> 
<script type="text/javascript">

$("#select_accounts_or_banks_id_transfer_from_select2_dropdownid").select2({
    		placeholder: "Select An Account",
    		width:"100%",
                ajax: {
					url: "{{ route('accountsOrBanksInSelectDropdown') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                     data: function (params) {
                        return {
                            searchTerm: params.term ,
							_token:'{{ csrf_token() }}',
							'excludeids': $('#new_transaction_accounts_or_banks_id').val(), 
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
 });	

var Transfer_From_Bank_Subcategory_Id = "{{ constants('Transfer_From_Bank_Subcategory_Id') }}";
var Transfer_To_Bank_Subcategory_Id = "{{ constants('Transfer_To_Bank_Subcategory_Id') }}";

$('body').on('change', '#new_transaction_deposit_or_withdrawal_id,#new_transaction_accounts_or_banks_id,#select_sub_category_from_select2_dropdownid', function () {
	$("#select_accounts_or_banks_id_transfer_from_select2_dropdownid").select2("val", 0);
	var select_sub_category_from_select2_dropdownid = $('#select_sub_category_from_select2_dropdownid').val();
	var hidden_transaction_id = $('#hidden_transaction_id').val();
	
	if((Transfer_From_Bank_Subcategory_Id==select_sub_category_from_select2_dropdownid || Transfer_To_Bank_Subcategory_Id==select_sub_category_from_select2_dropdownid) && hidden_transaction_id==0){
		$("#select_accounts_or_banks_id_transfer_from_select2_rowid").show();
	}
	else
	{
		$("#select_accounts_or_banks_id_transfer_from_select2_rowid").hide();
	}
});

</script> 

<!----Add here global Js ----start-----> 
@include('admin.layout.snippets.record_payment_bill')
@include('admin.layout.snippets.record_payment_invoice')
@include('admin.layout.snippets.add_newaccount')
</body></html>