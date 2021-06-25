@include('admin.layout.meta') 
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  
  @include('admin.layout.sidebar')
  <style>
  .select2-dropdown .select2-results__option {
  position: relative;
}

.table th, .table td{
	width: 30%;
	white-space: pre-line;
}
  </style>
  @php
  $editId = isset($_GET["edit"]) ? intval(trim($_GET["edit"])) : 0;
  if(!empty($one)){
  $control = 'Edit Invoice #'.@$one->invoice_number;
  }
  else
  {
  $control = 'New Invoice';
  }
  //dde($one->invoice_title);
  
  @endphp 
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid" style="max-width:80%"> 
      <!----errors-----------> 
      @if(!$errors->isEmpty())
      @foreach ($errors->all(':message') as $input_error)
      <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $input_error }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      @endforeach 
      @endif
      @if(Session::get("msg")!='')
      <div class="alert alert-{{ Session::get("cls") }} alert-dismissible fade show" role="alert">{{ Session::get("msg") }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      @endif 
      <!----errors-----------> 
      @if($editId>0 && empty($one))
      <h6> Not found</h6>
      @else 
      
      <!-- Page Header -->
      <form method="post" action="{{ route('add-update-invoice') }}" enctype="multipart/form-data" id="invoice_formsaveid">
        @csrf
        <input type="hidden" id="is_active" name="is_active" value="{{ isset($one->is_active) ? $one->is_active : 1 }}">
        <input type="hidden" id="invoice_hid" name="invoice_hid"  value="{{ isset($one->id) ? $one->id : 0 }}">
        <input type="hidden" id="invoice_typehid" name="invoice_typehid" value="Invoice" >
        <div class="page-header">
          <div class="row">
            <div class="col">
              <h3 class="page-title">{{ $control }}</h3>
            </div>
            <div class="">
              <button type="submit" class="btn btn-rounded btn-primary page-header-button submitcls">Save and continue</button>
            </div>
          </div>
        </div>
        <div>
          <div class="invoice-page">
            <button class="invoice-top-button" type="button">
            <div class="invoice-top-add">Business address and contact details, title, summary, and logo <i class="fas fa-chevron-down"></i> </div>
            </button>
          </div>
          <div class="invoice-page-main active">
            <div class="invoice-page-main-con row">
              <div class="col-xl-6 col-md-5 col-sm-12" >
                <div class="logo__dropzone" > @if($company_configurations->invoice_logo!='')
                  <div class="logo-img"> <img src='{{ sendPath(constants("company_files")).$company_configurations->invoice_logo}}' height="200px" width="180px"  alt="" > </div>
                  @endif </div>
              </div>
              <div class="invoice-page-address col-xl-6 col-md-7 col-sm-12">
                <div class="invoice-default-input">
                  <input class="margintop-bottom" placeholder="Invoice Title" type="text" autocapitalize="default" autocorrect="ON" name="invoice_title" id="invoice_title" value="{{ isset($one->invoice_title) ? $one->invoice_title : 'Invoice' }}">
                  <br>
                  <input class="margintop-bottom" placeholder="Summary (e.g. project name, description of invoice)" type="text" autocapitalize="default" autocorrect="ON" value="{{ @$one->invoice_description }}" name="invoice_description" id="invoice_description">
                </div>
                <div class="page-address"> <strong class="page-address-test">{{ $company_configurations->company_name }}</strong>
                  <div class="">
                    <div class="page-address-add"> <span class="">{{ $company_configurations->address }}</span> </div>
                    <div class="page-address-add"> <span class="">{{ $company_configurations->state }}</span> </div>
                    <div class="page-address-add"> <span class="">{{ $company_configurations->city }}-{{ $company_configurations->pincode }}</span> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="add-custmor-detile">
          <div class="row">
            <div class="col-md-4" id="select_customers_from_select2_dropdown_iddiv" style="display:block">
              <select class="form-control"  name="select_customers_from_select2_dropdown_id" id="select_customers_from_select2_dropdown_id" required="">
                <option value="{{ @$one->customer->id }}"></option>
              </select>
            </div>
            <div class="col-md-4" id="select_customers_from_select2_dropdown_iddiv2"  style="display:none">
              <p id="bill_toid">Bill To<br />
              </p>
              <a href="javascript:void(0)" id="edit_customer_from_id" data-id="0">Edit </a> OR <a href="javascript:void(0)" id="change_customer_from_dropdown_id" data-id="0">Change Customer</a> </div>
            <div class="col-md-8">
              <div class="form-group row" style="justify-content: flex-end;">
                <label class="col-form-label col-md-4">Invoice number *</label>
                <div class="col-md-4">
                  <input type="text" name="invoice_number" class="form-control " id="invoice_number"  placeholder="Invoice number" value="{{ @$one->invoice_number }}" required="">
                </div>
              </div>
              <div class="form-group row" style="justify-content: flex-end;">
                <label class="col-form-label col-md-4">Invoice date *</label>
                <div class="col-md-4">
                  <input type="text" name="invoice_date" class="form-control datepicker" id="invoice_date" data-date-format="yyyy-mm-dd" value="{{ isset($one->invoice_date) ? date('Y-m-d',strtotime($one->invoice_date))  : date('Y-m-d') }}" required="">
                </div>
              </div>
              <div class="form-group row" style="justify-content: flex-end;">
                <label class="col-form-label col-md-4">Payment due *</label>
                <div class="col-md-4">
                  <input type="text" name="payment_due_date" class="form-control datepicker" id="payment_due_date" data-date-format="yyyy-mm-dd" value="{{ isset($one->payment_due_date) ? date('Y-m-d',strtotime($one->payment_due_date))  : date('Y-m-d', strtotime(' + 15 days')) }}" required="" >
                </div>
              </div>
            </div>
          </div>
          <div class="card-body" style="padding: 0;padding-top: 20px;">
            <table class="table table-stripped table-center table-hover">
              <thead>
                <tr>
                  <th width="30%">Items</th>
                  <th width="20%">Description</th>
                  <th class="quantity-text-right" width="5%">Quantity</th>
                  <th width="20%">Price</th>
                  <th width="20%">Amount</th>
                  <th width="5%"></th>
                </tr>
              </thead>
              <tbody class="table-body" id="tbodyid">
              
              @if(isset($one->invoice_item) && !empty($one->invoice_item))
              @foreach($one->invoice_item as $row)
              <tr id="trt{{ $row->id }}">
                <td id="tdfirst_id{{ $row->id }}">{{ $row->productnservice->name }}
                  <input type="hidden" name="selectedsalesproductnservices_id[]" id="selectedsalesproductnservices_id{{ $row->id }}" data-id="'+dataid+'" value="{{ $row->products_or_services_id }}" required=""></td>
                <td id="tdsecond_id{{ $row->id }}"><textarea type="text" rows="3" class="form-control" name="invoice_product_description[]" id="invoice_product_description{{ $row->id }}" data-id="{{ $row->id }}" placeholder="description">{{ $row->description }}</textarea></td>
                <td id="tdthird_id{{ $row->id }}"><input type="text" class="form-control quantity-number text-align-right-new margin-right-auto invoice_product_qtycls" value="{{ $row->qty }}" data-id="{{ $row->id }}" name="invoice_product_qty[]" id="invoice_product_qty{{ $row->id }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" maxlength="9" minlength="1"  required=""></td>
                <td id="tdforth_id{{ $row->id }}"><input type="text" class="form-control price-input text-align-right-new invoice_product_pricecls" value="{{ $row->price }}" data-id="{{ $row->id }}"  name="invoice_product_price[]" id="invoice_product_price{{ $row->id }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8 || event.keyCode === 46;" maxlength="15" minlength="1"  required=""></td>
                <td id="tdfifth_id{{ $row->id }}"><span data-id="{{ $row->id }}" id="invoice_product_priceamount{{ $row->id }}">&#x20B9; {{ $row->amount }} </span></td>
                <td id="tdsixth_id{{ $row->id }}"><span onClick="removethisid({{ $row->id }})"><i class="far fa-trash-alt button-color-trash"></i></span></td>
              </tr>
              <tr id="trb{{ $row->id }}">
                <td id="tdfirsta_id{{ $row->id }}"></td>
                <td id="tdseconda_id{{ $row->id }}"><select class="form-control invoice_product_select_a_tax_idcls" name="invoice_product_select_a_tax_id[]" id="invoice_product_select_a_tax_id{{ $row->id }}" data-id="{{ $row->id }}">
                    
                     @foreach(getTax() as $tax) 
                     @php
                     $selected = ""; 
                     if($tax->id==$row->tax_id) { $selected = "selected"; }
                     @endphp
                    <option value="{{ $tax->id }}" data-taxrate="{{ $tax->current_tax_rate }}" {{ $selected }}>{{ $tax->abbreviation }} {{ ($tax->current_tax_rate>0) ? $tax->current_tax_rate.' %' : ''}}</option>
                     @endforeach 
                  </select></td>
                <td id="tdthirda_id{{ $row->id }}"><input type="hidden" name="invoice_tax_rateid[]" id="invoice_tax_rateid{{ $row->id }}" data-id="{{ $row->id }}" value="{{ $row->tax_rate }}">
                  <input type="hidden" name="invoice_taxsubtotal_valueid[]" id="invoice_taxsubtotal_valueid{{ $row->id }}" data-id="{{ $row->id }}" value="{{ $row->totaltax }}"></td>
                <td id="tdfortha_id{{ $row->id }}"><input type="hidden" name="invoice_subtotalid[]" id="invoice_subtotalid{{ $row->id }}" data-id="{{ $row->id }}" value="{{ $row->amount }}"></td>
                <td id="tdfiftha_id{{ $row->id }}"><span data-id="{{ $row->id }}" id="invoice_product_taxamount{{ $row->id }}" >&#x20B9; {{ $row->totaltax }} </span></td>
                <td id="tdsixtha_id{{ $row->id }}"></td>
              </tr>
              @endforeach
              @endif
                </tbody>
              
              <tr id="addanitemidbtn">
                <td colspan="12" class="add-item"><div>
                    <button type="button" class="btn btn-primary" style="width:100%" id="clickaddmoreid"><i class="fas fa-plus-circle"></i> Add an item </button>
                  </div>
                  <br />
                  <div>
                    <button type="button" class="btn btn-dark" style="width:100%" id="createanew_clickaddmoreid"> Create A New Item</button>
                  </div></td>
              </tr>
              
            </table>
            <div class="table-total">
              <div class="display-flex-new sub-total table-total-margin">
                <div class="sub-total-title"> <span>Subtotal</span> </div>
                <div class="sub-total-amount"><span id="subtotal_final_id_span">&#x20B9; {{ isset($one->subtotal) ? $one->subtotal : '0.00' }}</span> </div>
              </div>
              <div class="display-flex-new sub-total table-total-margin">
                <div class="sub-total-title"> <span>Tax</span> </div>
                <div class="sub-total-amount"><span id="subtotaltax_final_id_span">&#x20B9; {{ isset($one->tax_total) ? $one->tax_total : '0.00' }}</span> </div>
              </div>
              <div class="table-total-margin">
                <div class="display-flex-new">
                  <div class="total-main-usd">
                    <div class="table-total-now sub-total-title"> <b>Total</b> </div>
                  </div>
                  <div class="sub-total-amount"> <span id="alltotal_final_id_span">&#x20B9; {{ isset($one->total) ? $one->total : '0.00'  }}</span> </div>
                </div>
              </div>
              @if(isset($one->amount_due))
              <div class="table-total-margin">
                <div class="display-flex-new">
                  <div class="total-main-usd">
                    <div class="table-total-now sub-total-title"> <b> Due</b> </div>
                  </div>
                  <div class="sub-total-amount"> <span id="alltotal_final_id_span">&#x20B9; {{ $one->amount_due }}</span> </div>
                </div>
              </div>
              @endif </div>
          </div>
          <div>
            <div class="border-new-notes margintop-bottom">
              <p class="margintop-bottom">Notes / Terms</p>
              <textarea rows="5" class="button-back note-textarea" placeholder="Enter notes or terms of service that are visible to your customer" name="invoice_comment" id="invoice_comment">{{ @$one->invoice_comment }}</textarea>
            </div>
            <div class="form-group row" style="display:{{ isset($one->amount_due) ? 'none' : 'block' }}">
              <label class="col-lg-3 col-form-label">Save As</label>
              <div class="col-lg-9">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="invoice_status" id="SaveAsDraft" value="D" >
                  <label class="form-check-label" for="SaveAsDraft"> Draft </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="invoice_status" id="SaveAsUnPaid" value="U" checked="">
                  <label class="form-check-label" for="SaveAsUnPaid"> UnPaid </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <footer>
          <div class="invoice-page">
            <button class="invoice-top-button" type="button">
            <div class="invoice-top-add">Footer <i class="fas fa-chevron-down"></i> </div>
            </button>
            <textarea rows="5" class="button-back note-textarea  footer-box" placeholder="Enter notes or terms of service that are visible to your customer"  name="footer_comment" id="footer_comment">{{ @$one->footer_comment }}</textarea>
          </div>
        </footer>
        <div class="text-align-right-new">
          <button type="submit" class="btn btn-rounded btn-primary page-header-button page-botoom-button submitcls">Save and continue</button>
        </div>
      </form>
      @endif </div>
  </div>
  <!-- /Page Wrapper --> 
  
</div>

<!-- /Main Wrapper --> 
@include('admin.layout.js') 
@include('admin.layout.snippets.add_newcustomer') 
@include('admin.layout.snippets.add_newproductnserviceales') 
<script type="text/javascript">

$('.invoice-page').click(function(){
    $('.invoice-page-main').toggleClass('active');
});
$('.invoice-top-button').click(function(){
    $('.footer-box').toggleClass('active');
});
$('.select-text-value-js').click(function(){
    $('.select-taxt-drop-toggle').toggleClass('active');
});


</script> 
@if($editId>0 && !empty($one)) 
<script type="text/javascript">
var customerId = "{{ $one->customer->id }}";
$(document).ready(function(e) {
	$('#select_customers_from_select2_dropdown_id').val(customerId).trigger("change");
	showsubmitbtn();
});
</script> 
@endif 
<script type="text/javascript">
 $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
	
	

	//$("#select_customers_from_select2_dropdown_id").on("select2:select", function () {
$('body').on('change', '#select_customers_from_select2_dropdown_id', function () {
    var select_customers_from_select2_dropdown_id = $("#select_customers_from_select2_dropdown_id").val();
	$("#select_customers_from_select2_dropdown_iddiv").css('display','none'); 
	$("#select_customers_from_select2_dropdown_iddiv2").css('display','block'); 
	$.ajax({
            url: "{{ route('customers-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: select_customers_from_select2_dropdown_id
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data !== 'undefined' && data != null) {
					htmladdress = ''; htmlstate = ''; htmlcity = ''; htmlpincode = '';  
					if(data.address!=null){
						htmladdress = data.address+"<br/>";
					}
					if(data.state!=null){
						htmlstate = data.state+"<br/>";
					}
					if(data.city!=null){
						htmlcity = data.city+"<br/>";
					}
					if(data.pincode!=null){
						htmlpincode = data.pincode+"<br/>";
					}
					
					$('#bill_toid').html("Bill To<br /><b>"+data.fullname+"</b><br/>"+htmladdress+htmlstate+htmlcity+htmlpincode);
					$("#edit_customer_from_id").attr('data-id',data.id);
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
});

 $("#change_customer_from_dropdown_id").click(function() {
	$("#select_customers_from_select2_dropdown_iddiv").css('display','block'); 
	$("#select_customers_from_select2_dropdown_iddiv2").css('display','none'); 
	select_customers_from_select2_dropdown_idvar.select2("open");
});

$('body').on('click', '#edit_customer_from_id', function () {
	var id = $(this).data('id');
	show_add_newcustomerModal(id);
});
	
/*-----------------------add products-------------------*/

$('body').on('click', '#createanew_clickaddmoreid', function () {
	show_add_newpnssalesModal();
});
$('body').on('click', '#clickaddmoreid', function () {
    ehtml = '';
	var r_val = makeid(13,1);
	
	ehtml +=  '<tr id="trt'+r_val+'"> <td id="tdfirst_id'+r_val+'"><select class="form-control select_salesproductnservices_from_select2_dropdown_class" data-id="'+r_val+'" name="select_salesproductnservices_from_select2_dropdown_id[]" id="select_salesproductnservices_from_select2_dropdown_id'+r_val+'" required=""> </select></td> <td id="tdsecond_id'+r_val+'"><textarea rows="3" type="text" class="form-control" name="invoice_product_description[]" id="invoice_product_description'+r_val+'" data-id="'+r_val+'" placeholder="description"></textarea></td> <td id="tdthird_id'+r_val+'"><input type="text" class="form-control quantity-number text-align-right-new margin-right-auto invoice_product_qtycls" value="1" data-id="'+r_val+'" name="invoice_product_qty[]" id="invoice_product_qty'+r_val+'" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" maxlength="9" minlength="1"  required=""></td> <td id="tdforth_id'+r_val+'"><input type="text" class="form-control price-input text-align-right-new invoice_product_pricecls" value="0.00" data-id="'+r_val+'"  name="invoice_product_price[]" id="invoice_product_price'+r_val+'" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8 || event.keyCode === 46;" maxlength="15" minlength="1"  required=""></td> <td id="tdfifth_id'+r_val+'"><span data-id="'+r_val+'" id="invoice_product_priceamount'+r_val+'">&#x20B9; 0.00 </span></td> <td id="tdsixth_id'+r_val+'"><span onClick="removethisid('+r_val+')"><i class="far fa-trash-alt button-color-trash"></i></span></td> </tr> <tr id="trb'+r_val+'"> <td id="tdfirsta_id'+r_val+'"></td> <td id="tdseconda_id'+r_val+'"><select class="form-control invoice_product_select_a_tax_idcls" name="invoice_product_select_a_tax_id[]" id="invoice_product_select_a_tax_id'+r_val+'" data-id="'+r_val+'"> @foreach(getTax() as $tax) <option value="{{ $tax->id }}" data-taxrate="{{ $tax->current_tax_rate }}">{{ $tax->abbreviation }} {{ ($tax->current_tax_rate>0) ? $tax->current_tax_rate.' %' : ''}}</option> @endforeach </select></td> <td id="tdthirda_id'+r_val+'"><input type="hidden" name="invoice_tax_rateid[]" id="invoice_tax_rateid'+r_val+'" data-id="'+r_val+'" value="0"> <input type="hidden" name="invoice_taxsubtotal_valueid[]" id="invoice_taxsubtotal_valueid'+r_val+'" data-id="'+r_val+'" value="0"></td> <td id="tdfortha_id'+r_val+'"><input type="hidden" name="invoice_subtotalid[]" id="invoice_subtotalid'+r_val+'" data-id="'+r_val+'" value="0"></td> <td id="tdfiftha_id'+r_val+'"><span data-id="'+r_val+'" id="invoice_product_taxamount'+r_val+'" >&#x20B9; 0.00 </span></td> <td id="tdsixtha_id'+r_val+'"></td> </tr>';
					
	$('#tbodyid').append(ehtml);
	showsubmitbtn();
	
});
function removethisid(id) {
	x = confirm("do you want to delete this row, are you sure ?");
	if(x==true){ $("#trt"+id).remove();   $("#trb"+id).remove();   }
	final_amount_show();
	showsubmitbtn();
	}

function removethisidgst(id) {
	x = confirm("do you want to delete this section from row, are you sure ?");
	if(x==true){   $("#trb"+id).remove(); }
	}
	




$('body').on('click', '#clickaddmoreid', function () {
$(".select_salesproductnservices_from_select2_dropdown_class").select2({
    		placeholder: "Select A Product",
    		width:"100%",
                ajax: {
					url: "{{ route('salesproductnservicesInDropDown') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                     data: function (params) {
                        return {
                            searchTerm: params.term ,
							_token:'{{ csrf_token() }}',
							'includeid': 1, 
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
});
 
	


$('body').on('change', '.select_salesproductnservices_from_select2_dropdown_class', function () {
	var dataid = $(this).data('id');
	selectedmainid = $("#select_salesproductnservices_from_select2_dropdown_id"+dataid).val(); 
	
		$.ajax({
            url: "{{ route('productservice-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: selectedmainid
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data !== 'undefined' && data != null) {
					$('#tdfirst_id'+dataid).html(data.name);
					$('#tdfirst_id'+dataid).append('<input type="hidden" name="selectedsalesproductnservices_id[]" id="selectedsalesproductnservices_id'+dataid+'" data-id="'+dataid+'" value="'+selectedmainid+'" required="">');
					$('#invoice_product_description'+dataid).val(data.description);
					$('#invoice_product_price'+dataid).val(data.price);
					$('#invoice_product_select_a_tax_id'+dataid).val(data.tax_id);
					$('#invoice_tax_rateid'+dataid).val(data.tax.current_tax_rate);
					final_amount_show();
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });

});	
	
/*-----------------------add products-------------------*/	
	
/*	window.onbeforeunload = function(event)
    {
        return confirm("Confirm refresh");
    };*/
	
	
</script> 
<script type="text/javascript" >
$('body').on('keyup', '.invoice_product_pricecls,.invoice_product_qtycls', function () {
	final_amount_show();
});
$('body').on('change', '.invoice_product_select_a_tax_idcls', function () {
	var vv = $(this).data('id');
	var element = $("option:selected", this);
    var taxrate = element.attr("data-taxrate");
	$("#invoice_tax_rateid"+vv).val(taxrate);
	final_amount_show();
});
function showsubmitbtn() {
	var invoice_item_counthid = $('.invoice_product_qtycls').length;
	if(invoice_item_counthid<1){ $(".submitcls").prop('disabled',true);}
	else { $(".submitcls").prop('disabled',false); }
}
function final_amount_show(){
	var subtotalamount_final = 0;
	var totaltax_final = 0;
	var grosstotal_final = 0;

	 $('.invoice_product_qtycls').each(function(){  
	  var vv = $(this).data('id');
	 invoice_product_price_c = parseFloat($("#invoice_product_price"+vv).val());
	 invoice_product_qty_c = parseFloat($("#invoice_product_qty"+vv).val());
	 invoice_tax_rateid_c = parseFloat($("#invoice_tax_rateid"+vv).val());
	 thissubtotal = parseFloat(invoice_product_price_c*invoice_product_qty_c);
	 thissubtax = parseFloat(invoice_tax_rateid_c*thissubtotal*0.01);
	 subtotalamount_final += parseFloat(thissubtotal);
	 totaltax_final += parseFloat(thissubtax);
	 $("#invoice_taxsubtotal_valueid"+vv).val(thissubtax.toFixed(2)); 
	 $("#invoice_subtotalid"+vv).val(thissubtotal.toFixed(2));
	 $("#invoice_product_taxamount"+vv).html("&#8377; "+thissubtax.toFixed(2)); 
	 $("#invoice_product_priceamount"+vv).html("&#8377; "+thissubtotal.toFixed(2)); 
	});
	
	grosstotal_final = subtotalamount_final + totaltax_final;
	 $("#subtotal_final_id_span").html("&#8377; "+subtotalamount_final.toFixed(2)); 
	 $("#alltotal_final_id_span").html("&#8377; "+grosstotal_final.toFixed(2)); 
	 $("#subtotaltax_final_id_span").html("&#8377; "+totaltax_final.toFixed(2));  
}
</script> 
<script>
 /* $( function() {
    $( "#tbodyid" ).sortable();
  } );*/
  </script> 