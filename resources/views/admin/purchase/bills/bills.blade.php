@include('admin.layout.meta') 
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  
  @include('admin.layout.sidebar')
  <style>
  .select2-dropdown .select2-results__option {
  position: relative;
}
  </style>
  @php
  $editId = isset($_GET["edit"]) ? intval(trim($_GET["edit"])) : 0;
  if(!empty($one)){
  $control = 'Edit Bill';
  }
  else
  {
  $control = 'New Bill';
  }
  //dde($one->bills_title);
  
  @endphp 
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid" style="max-width:99%"> 
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
      <form method="post" action="{{ route('add-update-bills') }}" enctype="multipart/form-data" id="bills_formsaveid">
        @csrf
        <input type="hidden" id="is_active" name="is_active" value="{{ isset($one->is_active) ? $one->is_active : 1 }}">
        <input type="hidden" id="bills_hid" name="bills_hid"  value="{{ isset($one->id) ? $one->id : 0 }}">
        <input type="hidden" id="bills_typehid" name="bills_typehid" value="Bills" >
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
        
        <div class="add-custmor-detile">
          <div class="row">
          
            <div class="col-md-4" id="select_vendors_from_select2_dropdown_iddiv" style="display:block">
            <label class="col-form-label">Vendor *</label>
              <select class="form-control"  name="select_vendors_from_select2_dropdown_id" id="select_vendors_from_select2_dropdown_id" required="">
                <option value="{{ @$one->vendor->id }}"></option>
              </select>
            </div>
            <div class="col-md-4" id="select_vendors_from_select2_dropdown_iddiv2"  style="display:none">
              <p id="bill_toid">Vendor<br />
              </p>
              <a href="javascript:void(0)" id="edit_vendor_from_id" data-id="0">Edit </a> OR <a href="javascript:void(0)" id="change_vendor_from_dropdown_id" data-id="0">Change Vendor</a> </div>
            <div class="col-md-8">
              <div class="form-group row" style="justify-content: flex-end;">
                <label class="col-form-label col-md-4">Bill number *</label>
                <div class="col-md-4">
                  <input type="text" name="bill_number" class="form-control " id="bill_number"  placeholder="bills number" value="{{ @$one->bill_number }}" required="">
                </div>
              </div>
              <div class="form-group row" style="justify-content: flex-end;">
                <label class="col-form-label col-md-4">Bill date *</label>
                <div class="col-md-4">
                  <input type="text" name="bill_date" class="form-control datepicker" id="bill_date" data-date-format="yyyy-mm-dd" value="{{ isset($one->bill_date) ? date('Y-m-d',strtotime($one->bill_date))  : date('Y-m-d') }}" required="">
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
                  <th>Items</th>
                  <th>Description</th>
                  <th class="quantity-text-right">Quantity</th>
                  <th>Price</th>
                  <th>Amount</th>
                  <th>Tax</th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="table-body" id="tbodyid">
              
              @if(isset($one->bills_item) && !empty($one->bills_item))
              @foreach($one->bills_item as $row)
            




              <tr id="trt{{ $row->id }}">
                <td id="tdfirst_id{{ $row->id }}">{{ $row->productnservice->name }}
                  <input type="hidden" name="selectedexpensesproductnservices_id[]" id="selectedexpensesproductnservices_id{{ $row->id }}" data-id="'+dataid+'" value="{{ $row->products_or_services_id }}" required=""></td>
                <td id="tdsecond_id{{ $row->id }}"><textarea type="text" rows="3" class="form-control" name="bills_product_description[]" id="bills_product_description{{ $row->id }}" data-id="{{ $row->id }}" placeholder="description">{{ $row->description }}</textarea></td>
                <td id="tdthird_id{{ $row->id }}"><input type="text" class="form-control quantity-number text-align-right-new margin-right-auto bills_product_qtycls" value="{{ $row->qty }}" data-id="{{ $row->id }}" name="bills_product_qty[]" id="bills_product_qty{{ $row->id }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" maxlength="9" minlength="1"  required=""></td>
                <td id="tdforth_id{{ $row->id }}"><input type="text" class="form-control price-input text-align-right-new bills_product_pricecls" value="{{ $row->price }}" data-id="{{ $row->id }}"  name="bills_product_price[]" id="bills_product_price{{ $row->id }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8 || event.keyCode === 46;" maxlength="15" minlength="1"  required=""></td>
                <td id="tdfifth_id{{ $row->id }}"><span data-id="{{ $row->id }}" id="bills_product_priceamount{{ $row->id }}">&#x20B9; {{ $row->amount }} </span></td>
                <td id="tdseconda_id{{ $row->id }}"><select class="form-control bills_product_select_a_tax_idcls" name="bills_product_select_a_tax_id[]" id="bills_product_select_a_tax_id{{ $row->id }}" data-id="{{ $row->id }}">
                    
                     @foreach(getTax() as $tax) 
                     @php
                     $selected = ""; 
                     if($tax->id==$row->tax_id) { $selected = "selected"; }
                     @endphp
                    <option value="{{ $tax->id }}" data-taxrate="{{ $tax->current_tax_rate }}" {{ $selected }}>{{ $tax->abbreviation }} {{ ($tax->current_tax_rate>0) ? $tax->current_tax_rate.' %' : ''}}</option>
                     @endforeach 
                  </select></td>
                  
                  <input type="hidden" name="bills_tax_rateid[]" id="bills_tax_rateid{{ $row->id }}" data-id="{{ $row->id }}"  value="{{ $row->tax_rate }}">
                   <input type="hidden" name="bills_subtotalid[]" id="bills_subtotalid{{ $row->id }}" data-id="{{ $row->id }}" value="{{ $row->amount }}"> 
                   <input type="hidden" name="bills_taxsubtotal_valueid[]" id="bills_taxsubtotal_valueid{{ $row->id }}" data-id="{{ $row->id }}" value="{{ $row->totaltax }}"> 
                   <td id="tdsixth_id{{ $row->id }}"><span onClick="removethisid({{ $row->id }})"><i class="far fa-trash-alt button-color-trash"></i></span></td>
                  
                  
              </tr>
              
              @endforeach
              @endif
                </tbody>
              
              <tr id="addanitemidbtn">
                <td colspan="12" class="add-item"><div>
                    <button type="button" class="btn btn-primary" style="width:100%" id="clickaddmoreid"><i class="fas fa-plus-circle"></i> Add an Item </button>
                  </div>
                  <br />
                  <div>
                    <button type="button" class="btn btn-dark" style="width:100%" id="createanew_clickaddmoreid"> Create A New Item</button>
                  </div>
                  </td>
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
              <p class="margintop-bottom">Notes</p>
              <textarea rows="5" class="button-back note-textarea" placeholder="Enter notes" name="bill_notes" id="bill_notes">{{ @$one->bill_notes }}</textarea>
            </div>
            
          </div>
        </div>
        
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
@include('admin.layout.snippets.add_newvendor') 
@include('admin.layout.snippets.add_newproductnserviceexpenses') 

@if($editId>0 && !empty($one)) 
<script type="text/javascript">
var vendorId = "{{ $one->vendor->id }}";
$(document).ready(function(e) {
	$('#select_vendors_from_select2_dropdown_id').val(vendorId).trigger("change");
	showsubmitbtn();
});
</script> 
@endif 
<script type="text/javascript">
 $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
	
	

	//$("#select_vendors_from_select2_dropdown_id").on("select2:select", function () {
$('body').on('change', '#select_vendors_from_select2_dropdown_id', function () {
    var select_vendors_from_select2_dropdown_id = $("#select_vendors_from_select2_dropdown_id").val();
	$("#select_vendors_from_select2_dropdown_iddiv").css('display','none'); 
	$("#select_vendors_from_select2_dropdown_iddiv2").css('display','block'); 
	$.ajax({
            url: "{{ route('vendors-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: select_vendors_from_select2_dropdown_id
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
					
					$('#bill_toid').html("Vendor<br /><b>"+data.fullname+"</b><br/>"+htmladdress+htmlstate+htmlcity+htmlpincode);
					$("#edit_vendor_from_id").attr('data-id',data.id);
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
});

 $("#change_vendor_from_dropdown_id").click(function() {
	$("#select_vendors_from_select2_dropdown_iddiv").css('display','block'); 
	$("#select_vendors_from_select2_dropdown_iddiv2").css('display','none'); 
	select_vendors_from_select2_dropdown_idvar.select2("open");
});

$('body').on('click', '#edit_vendor_from_id', function () {
	var id = $(this).data('id');
	show_add_newvendorModal(id);
});
	
/*-----------------------add products-------------------*/
$('body').on('click', '#createanew_clickaddmoreid', function () {
	show_add_newpnsexpensesModal();
});
$('body').on('click', '#clickaddmoreid', function () {
    ehtml = '';
	var r_val = makeid(13,1);
	
	ehtml +=  '<tr id="trt'+r_val+'"> <td id="tdfirst_id'+r_val+'"><select class="form-control select_salesproductnservices_from_select2_dropdown_class" data-id="'+r_val+'" name="select_salesproductnservices_from_select2_dropdown_id[]" id="select_salesproductnservices_from_select2_dropdown_id'+r_val+'" required=""> </select></td> <td id="tdsecond_id'+r_val+'"><textarea type="text" rows="3" class="form-control" name="bills_product_description[]" id="bills_product_description'+r_val+'" data-id="'+r_val+'" placeholder="description"></textarea></td> <td id="tdthird_id'+r_val+'"><input type="text" class="form-control quantity-number text-align-right-new margin-right-auto bills_product_qtycls" value="1" data-id="'+r_val+'" name="bills_product_qty[]" id="bills_product_qty'+r_val+'" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" maxlength="9" minlength="1"  required=""></td> <td id="tdforth_id'+r_val+'"><input type="text" class="form-control price-input text-align-right-new bills_product_pricecls" value="0.00" data-id="'+r_val+'"  name="bills_product_price[]" id="bills_product_price'+r_val+'" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8 || event.keyCode === 46;" maxlength="15" minlength="1"  required=""></td> <td id="tdfifth_id'+r_val+'"><span data-id="'+r_val+'" id="bills_product_priceamount'+r_val+'">&#x20B9; 0.00 </span></td> <td id="tdseconda_id'+r_val+'"><select class="form-control bills_product_select_a_tax_idcls" name="bills_product_select_a_tax_id[]" id="bills_product_select_a_tax_id'+r_val+'" data-id="'+r_val+'"> @foreach(getTax() as $tax) <option value="{{ $tax->id }}" data-taxrate="{{ $tax->current_tax_rate }}">{{ $tax->abbreviation }} {{ ($tax->current_tax_rate>0) ? $tax->current_tax_rate.' %' : ''}}</option> @endforeach </select></td> <input type="hidden" name="bills_tax_rateid[]" id="bills_tax_rateid'+r_val+'" data-id="'+r_val+'" value="0"> <input type="hidden" name="bills_subtotalid[]" id="bills_subtotalid'+r_val+'" data-id="'+r_val+'" value="0"> <input type="hidden" name="bills_taxsubtotal_valueid[]" id="bills_taxsubtotal_valueid'+r_val+'" data-id="'+r_val+'" value="0"> <td id="tdsixth_id'+r_val+'"><span onClick="removethisid('+r_val+')"><i class="far fa-trash-alt button-color-trash"></i></span></td> </tr>';
					
	$('#tbodyid').append(ehtml);
	showsubmitbtn();
	
});
function removethisid(id) {
	x = confirm("do you want to delete this row, are you sure ?");
	if(x==true){ $("#trt"+id).remove();   }
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
					url: "{{ route('expensesproductnservicesInDropDown') }}",
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
					$('#tdfirst_id'+dataid).append('<input type="hidden" name="selectedexpensesproductnservices_id[]" id="selectedexpensesproductnservices_id'+dataid+'" data-id="'+dataid+'" value="'+selectedmainid+'" required="">');
					$('#bills_product_description'+dataid).val(data.description);
					$('#bills_product_price'+dataid).val(data.price);
					$('#bills_product_select_a_tax_id'+dataid).val(data.tax_id);
					$('#bills_tax_rateid'+dataid).val(data.tax.current_tax_rate);
					
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
$('body').on('keyup', '.bills_product_pricecls,.bills_product_qtycls', function () {
	final_amount_show();
});
$('body').on('change', '.bills_product_select_a_tax_idcls', function () {
	var vv = $(this).data('id');
	var element = $("option:selected", this);
    var taxrate = element.attr("data-taxrate");
	$("#bills_tax_rateid"+vv).val(taxrate);
	final_amount_show();
});
function showsubmitbtn() {
	var bills_item_counthid = $('.bills_product_qtycls').length;
	if(bills_item_counthid<1){ $(".submitcls").prop('disabled',true);}
	else { $(".submitcls").prop('disabled',false); }
}
function final_amount_show(){
	var subtotalamount_final = 0;
	var totaltax_final = 0;
	var grosstotal_final = 0;

	 $('.bills_product_qtycls').each(function(){  
	  var vv = $(this).data('id');
	 bills_product_price_c = parseFloat($("#bills_product_price"+vv).val());
	 bills_product_qty_c = parseFloat($("#bills_product_qty"+vv).val());
	 bills_tax_rateid_c = parseFloat($("#bills_tax_rateid"+vv).val());
	 thissubtotal = parseFloat(bills_product_price_c*bills_product_qty_c);
	 thissubtax = parseFloat(bills_tax_rateid_c*thissubtotal*0.01);
	 subtotalamount_final += parseFloat(thissubtotal);
	 totaltax_final += parseFloat(thissubtax);
	 $("#bills_taxsubtotal_valueid"+vv).val(thissubtax.toFixed(2)); 
	 $("#bills_subtotalid"+vv).val(thissubtotal.toFixed(2));
	 $("#bills_product_taxamount"+vv).html("&#8377; "+thissubtax.toFixed(2)); 
	 $("#bills_product_priceamount"+vv).html("&#8377; "+thissubtotal.toFixed(2)); 
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