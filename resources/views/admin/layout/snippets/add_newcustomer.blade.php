<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_newcustomerModal"> Launch Add-Account modal</button-->

<!-- Add-Account Modal Starts -->

<div class="modal fade" id="add_newcustomerModal" tabindex="-1" role="dialog" aria-labelledby="add_newcustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_newcustomerModalLabel">Add</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs nav-tabs-bottom">
          <li class="nav-item"><a class="nav-link active" href="#customer-tab1" data-toggle="tab" id="customer-tab1a">Customer</a></li>
          <li class="nav-item"><a class="nav-link" href="#address-tab2" data-toggle="tab" id="address-tab2a">Address</a></li>
        </ul>
        <form id="add_newcustomerformid">
          @csrf
          <input type="hidden" name="hidaddnewacustomerid" id="hidaddnewacustomerid" value="0" >
          <div class="tab-content">
            <div class="tab-pane show active" id="customer-tab1">
              <div class="form-group row">
                <label class="col-form-label col-md-4">First Name </label>
                <div class="col-md-8">
                  <input type="text" class="form-control" maxlength="150" name="add_newcustomerfirstname" id="add_newcustomerfirstname" placeholder="First Name" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-4">Last Name</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" maxlength="150" name="add_newcustomerlastname" id="add_newcustomerlastname" placeholder="Last Name" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-4">Company Name *</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" maxlength="150" name="add_newcustomerfullname" id="add_newcustomerfullname" placeholder="Full Name" value="" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-4">Email</label>
                <div class="col-md-8">
                  <input type="email" class="form-control" maxlength="150" name="add_newcustomeremail" id="add_newcustomeremail" placeholder="Email" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-4">Mobile</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" placeholder="Mobile Number" name="add_newcustomermobile" id="add_newcustomermobile" value="" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" maxlength="13" minlength="10">
                </div>
              </div>
            </div>
            <div class="tab-pane" id="address-tab2">
              <h6 class="card-title">Address (optional)</h6>
              <div class="form-group row">
                <label class="col-form-label col-md-2">Address </label>
                <div class="col-md-10">
                  <textarea type="text" class="form-control" rows="3" maxlength="250" name="add_newcustomeraddress" id="add_newcustomeraddress" placeholder="Address" ></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-2">Landmark </label>
                <div class="col-md-10">
                  <input type="text" class="form-control" maxlength="250" name="add_newcustomerlandmark" id="add_newcustomerlandmark" placeholder="Landmark" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-2">Country </label>
                <div class="col-md-4">
                  <input type="text" name="add_newcustomercountry" class="form-control" id="add_newcustomercountry1"  placeholder="Country" value=""  >
                </div>
                <label class="col-form-label col-md-2">State</label>
                <div class="col-md-4">
                  <input type="text" name="add_newcustomerstate" class="form-control" id="add_newcustomerstate1" placeholder="State" value="" >
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-2">City</label>
                <div class="col-md-4">
                  <input type="text" name="add_newcustomercity" class="form-control showcls24mec" id="add_newcustomercity1" placeholder="City" value="" >
                </div>
                <label class="col-form-label col-md-2">Pincode </label>
                <div class="col-md-4">
                  <input type="text" name="add_newcustomerpincode" class="form-control showcls24mec"  id="add_newcustomerpincode1" placeholder="Pincode" maxlength="6"  minlength="6" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" value="">
                </div>
              </div>
              <input type="hidden" id="add_newcustomeris_active" name="add_newcustomeris_active" value="1">
              <input type="hidden" id="add_newcustomertypehid" name="add_newcustomertypehid" value="Customer" >
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_newcustomerformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Add-Account Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#add_newcustomerformsaveid', function () {
        var id = $('#hidaddnewacustomerid').val();
		var add_newcustomerfirstname = $('#add_newcustomerfirstname').val();
		var add_newcustomerlastname = $('#add_newcustomerlastname').val();
		var add_newcustomerfullname = $('#add_newcustomerfullname').val();
		var add_newcustomeris_active = $('#add_newcustomeris_active').val();
		var add_newcustomeremail = $('#add_newcustomeremail').val();
		var add_newcustomermobile = $('#add_newcustomermobile').val();
		var add_newcustomeraddress = $('textarea#add_newcustomeraddress').val();
		var add_newcustomerlandmark = $('#add_newcustomerlandmark').val();
		var add_newcustomercountry1 = $('#add_newcustomercountry1').val();
		var add_newcustomerstate1 = $('#add_newcustomerstate1').val();
		var add_newcustomercity1 = $('#add_newcustomercity1').val();
		var add_newcustomerpincode1 = $('#add_newcustomerpincode1').val();
		var add_newcustomertypehid = $('#add_newcustomertypehid').val();
		
        if(id=='' || add_newcustomerfullname=='' || add_newcustomeris_active=='' || add_newcustomertypehid=='' || isEmail(add_newcustomeremail)==false ){
		showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }

        $("#add_newcustomerModal").modal('hide');
		
     $.ajax({
            url: "{{ route('add-update-customer') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
              fullname: add_newcustomerfullname,
			  email: add_newcustomeremail,
			  firstname: add_newcustomerfirstname,
			  lastname: add_newcustomerlastname,
			  is_active : add_newcustomeris_active,
			  mobile : add_newcustomermobile,
			  address : add_newcustomeraddress,
			  landmark : add_newcustomerlandmark,
			  country : add_newcustomercountry1,
			  state : add_newcustomerstate1,
			  city : add_newcustomercity1,
			  pincode : add_newcustomerpincode1,
			  typehid : add_newcustomertypehid,
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				if(e.success==1){
					showSweetAlert("Completed",e.msg, 1); 
              		if(typeof t1 !== "undefined"){ t1.draw(false); } 
				}
				else
				{
					showSweetAlert("Error",e.msg, 0); 
              		if(typeof t1 !== "undefined"){ t1.draw(false); } 
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
                showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
  });
  
  
  function show_add_newcustomerModal(idx=0){
	  $("#select_customers_from_select2_dropdown_id").select2("close");
	  $('#add_newcustomerformid')[0].reset();
	  $('#add_newcustomertypehid').val('Customer');
	  $('#customer-tab1a').click();
	  
	  if(idx==0){
		  $("#add_newcustomerModal").modal('show');
		  $('#hidaddnewacustomerid').val(0);
		}
		else if(idx>0){
		$('#add_newcustomerModalLabel').html('Edit');
		$('#hidaddnewacustomerid').val(idx);

     $.ajax({
            url: "{{ route('customers-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: idx
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data !== 'undefined' && data != null) {
				$("#add_newcustomerModal").modal('show');
				$('#hidaddnewacustomerid').val(data.id);
				$('#add_newcustomerfirstname').val(data.firstname);
				$('#add_newcustomerlastname').val(data.lastname);
				$('#add_newcustomerfullname').val(data.fullname);
				$('#add_newcustomeris_active').val(data.is_active);
				$('#add_newcustomeremail').val(data.email);
				$('#add_newcustomermobile').val(data.mobile);
				$('#add_newcustomeraddress').val(data.address);
				$('#add_newcustomerlandmark').val(data.landmark);
				$('#add_newcustomercountry1').val(data.country);
				$('#add_newcustomerstate1').val(data.state);
				$('#add_newcustomercity1').val(data.city);
				$('#add_newcustomerpincode1').val(data.pincode);
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
		
		}
  }


var addNewCustomerBtnId = '<button type="button" onclick="show_add_newcustomerModal()" class="btn btn-warning fullwidthbtncls">Add New Customer +</button>';

 var select_customers_from_select2_dropdown_idvar = $("#select_customers_from_select2_dropdown_id").select2({
    		placeholder: "Select A Customer",
    		width:"100%",
                ajax: {
					url: "{{ route('CustomerInDropDown') }}",
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
 
 /*$(document).ready(function(e) {
    //var newOption = new Option("please select", 4, true, true);
	//$('#select_customers_from_select2_dropdown_id').append(newOption).trigger('change');
	$('#select_customers_from_select2_dropdown_id').val(4); 
	$('#select_customers_from_select2_dropdown_id').trigger('change'); 
});
 */
  		


    var flg = 0;
    $("#select_customers_from_select2_dropdown_id").on("select2:open", function () {
        flg++;
        if (flg == 1) {
			$('body').find('.select2-results').append(addNewCustomerBtnId);
        }
    });










</script> 
<!----Customer Add Snippet------ends------here------>