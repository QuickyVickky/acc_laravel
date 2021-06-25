<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_newvendorModal"> Launch Add-Account modal</button-->

<!-- Add-Account Modal Starts -->

<div class="modal fade" id="add_newvendorModal" tabindex="-1" role="dialog" aria-labelledby="add_newvendorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_newvendorModalLabel">Add</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs nav-tabs-bottom">
          <li class="nav-item"><a class="nav-link active" href="#customer-tab1" data-toggle="tab" id="vendor-tab1a">Vendor</a></li>
          <li class="nav-item"><a class="nav-link" href="#address-tab2" data-toggle="tab" id="address-tab2a">Address</a></li>
        </ul>
        <form id="add_newvendorformid">
          @csrf
          <input type="hidden" name="hidaddnewvendorid" id="hidaddnewvendorid" value="0" >
          <div class="tab-content">
            <div class="tab-pane show active" id="customer-tab1">
              <div class="form-group row">
                <label class="col-form-label col-md-4">First Name </label>
                <div class="col-md-8">
                  <input type="text" class="form-control" maxlength="150" name="add_newvendorfirstname" id="add_newvendorfirstname" placeholder="First Name" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-4">Last Name</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" maxlength="150" name="add_newvendorlastname" id="add_newvendorlastname" placeholder="Last Name" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-4">Full Name *</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" maxlength="150" name="add_newvendorfullname" id="add_newvendorfullname" placeholder="Full Name" value="" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-4">Email</label>
                <div class="col-md-8">
                  <input type="email" class="form-control" maxlength="150" name="add_newvendoremail" id="add_newvendoremail" placeholder="Email" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-4">Mobile</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" placeholder="Mobile Number" name="add_newvendormobile" id="add_newvendormobile" value="" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" maxlength="13" minlength="10">
                </div>
              </div>
            </div>
            <div class="tab-pane" id="address-tab2">
              <h6 class="card-title">Address (optional)</h6>
              <div class="form-group row">
                <label class="col-form-label col-md-2">Address </label>
                <div class="col-md-10">
                  <textarea type="text" class="form-control" rows="3" maxlength="250" name="add_newvendoraddress" id="add_newvendoraddress" placeholder="Address" ></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-2">Landmark </label>
                <div class="col-md-10">
                  <input type="text" class="form-control" maxlength="250" name="add_newvendorlandmark" id="add_newvendorlandmark" placeholder="Landmark" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-2">Country </label>
                <div class="col-md-4">
                  <input type="text" name="add_newvendorcountry" class="form-control" id="add_newvendorcountry1"  placeholder="Country" value=""  >
                </div>
                <label class="col-form-label col-md-2">State</label>
                <div class="col-md-4">
                  <input type="text" name="add_newvendorstate" class="form-control" id="add_newvendorstate1" placeholder="State" value="" >
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-2">City</label>
                <div class="col-md-4">
                  <input type="text" name="add_newvendorcity" class="form-control showcls24mec" id="add_newvendorcity1" placeholder="City" value="" >
                </div>
                <label class="col-form-label col-md-2">Pincode </label>
                <div class="col-md-4">
                  <input type="text" name="add_newvendorpincode" class="form-control showcls24mec"  id="add_newvendorpincode1" placeholder="Pincode" maxlength="6"  minlength="6" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" value="">
                </div>
              </div>
              <input type="hidden" id="add_newvendoris_active" name="add_newvendoris_active" value="1">
              <input type="hidden" id="add_newvendortypehid" name="add_newvendortypehid" value="Vendor" >
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_newvendorformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Add-Account Modal Ends --> 
<!----vendor Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#add_newvendorformsaveid', function () {
        var id = $('#hidaddnewvendorid').val();
		var add_newvendorfirstname = $('#add_newvendorfirstname').val();
		var add_newvendorlastname = $('#add_newvendorlastname').val();
		var add_newvendorfullname = $('#add_newvendorfullname').val();
		var add_newvendoris_active = $('#add_newvendoris_active').val();
		var add_newvendoremail = $('#add_newvendoremail').val();
		var add_newvendormobile = $('#add_newvendormobile').val();
		var add_newvendoraddress = $('textarea#add_newvendoraddress').val();
		var add_newvendorlandmark = $('#add_newvendorlandmark').val();
		var add_newvendorcountry1 = $('#add_newvendorcountry1').val();
		var add_newvendorstate1 = $('#add_newvendorstate1').val();
		var add_newvendorcity1 = $('#add_newvendorcity1').val();
		var add_newvendorpincode1 = $('#add_newvendorpincode1').val();
		var add_newvendortypehid = $('#add_newvendortypehid').val();
		
        if(id=='' || add_newvendorfullname=='' || add_newvendoris_active=='' || add_newvendortypehid=='' || isEmail(add_newvendoremail)==false ){
		showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }

        $("#add_newvendorModal").modal('hide');
		
     $.ajax({
            url: "{{ route('add-update-vendor') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
              fullname: add_newvendorfullname,
			  email: add_newvendoremail,
			  firstname: add_newvendorfirstname,
			  lastname: add_newvendorlastname,
			  is_active : add_newvendoris_active,
			  mobile : add_newvendormobile,
			  address : add_newvendoraddress,
			  landmark : add_newvendorlandmark,
			  country : add_newvendorcountry1,
			  state : add_newvendorstate1,
			  city : add_newvendorcity1,
			  pincode : add_newvendorpincode1,
			  typehid : add_newvendortypehid,
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
  
  
  function show_add_newvendorModal(idx=0){
	  $("#select_vendors_from_select2_dropdown_id").select2("close");
	  $('#add_newvendorformid')[0].reset();
	  $('#add_newvendortypehid').val('Customer');
	  $('#vendor-tab1a').click();
	  
	  if(idx==0){
		  $("#add_newvendorModal").modal('show');
		  $('#hidaddnewvendorid').val(0);
		}
		else if(idx>0){
		$('#add_newvendorModalLabel').html('Edit');
		$('#hidaddnewvendorid').val(idx);

     $.ajax({
            url: "{{ route('vendors-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: idx
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data !== 'undefined' && data != null) {
				$("#add_newvendorModal").modal('show');
				$('#hidaddnewvendorid').val(data.id);
				$('#add_newvendorfirstname').val(data.firstname);
				$('#add_newvendorlastname').val(data.lastname);
				$('#add_newvendorfullname').val(data.fullname);
				$('#add_newvendoris_active').val(data.is_active);
				$('#add_newvendoremail').val(data.email);
				$('#add_newvendormobile').val(data.mobile);
				$('#add_newvendoraddress').val(data.address);
				$('#add_newvendorlandmark').val(data.landmark);
				$('#add_newvendorcountry1').val(data.country);
				$('#add_newvendorstate1').val(data.state);
				$('#add_newvendorcity1').val(data.city);
				$('#add_newvendorpincode1').val(data.pincode);
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
		
		}
  }


var addNewVendorBtnId = '<button type="button" onclick="show_add_newvendorModal()" class="btn btn-warning fullwidthbtncls">Add New Vendor +</button>';

var select_vendors_from_select2_dropdown_idvar = $("#select_vendors_from_select2_dropdown_id").select2({
    		placeholder: "Select A Vendor ",
    		width:"100%",
                ajax: {
					url: "{{ route('VendorInDropDown') }}",
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
 

    var flg = 0;
    $("#select_vendors_from_select2_dropdown_id").on("select2:open", function () {
        flg++;
        if (flg == 1) {
            $(".select2-results").append(addNewVendorBtnId);
        }
    });










</script> 
<!----vendor Add Snippet------ends------here------>