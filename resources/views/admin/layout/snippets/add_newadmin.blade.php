<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_newadminModal"> Launch Add-Account modal</button-->

<!-- Add-Account Modal Starts -->

<div class="modal fade" id="add_newadminModal" tabindex="-1" role="dialog" aria-labelledby="add_newadminModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_newadminModalLabel">Add</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs nav-tabs-bottom">
          <li class="nav-item"><a class="nav-link active" href="#customer-tab1" data-toggle="tab" id="customer-tab1a">Admin</a></li>

        </ul>
        <form id="add_newadminformid">
          @csrf
          <input type="hidden" name="hidaddnewacustomerid" id="hidaddnewacustomerid" value="0" >
          <div class="tab-content">
            <div class="tab-pane show active" id="customer-tab1">
              <div class="form-group row">
                <label class="col-form-label col-md-4">Full Name *</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" maxlength="150" name="add_newadminfullname" id="add_newadminfullname" placeholder="Full Name" value="" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-4">Email*</label>
                <div class="col-md-8">
                  <input type="email" class="form-control" maxlength="150" name="add_newadminemail" id="add_newadminemail" placeholder="Email" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-4">Mobile</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" placeholder="Mobile Number" name="add_newadminmobile" id="add_newadminmobile" value="" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" maxlength="13" minlength="10">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-4">Password</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" maxlength="150" name="add_newadminpassword" id="add_newadminpassword" placeholder="Password" value="" required>
                </div>
              </div>
            </div>
            
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_newadminformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Add-Account Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#add_newadminformsaveid', function () {
        var id = $('#hidaddnewacustomerid').val();
		var add_newadminfullname = $('#add_newadminfullname').val();
		var add_newadminemail = $('#add_newadminemail').val();
		var add_newadminmobile = $('#add_newadminmobile').val();
		var add_newadminpassword = $('#add_newadminpassword').val();
        if(id=='' || add_newadminfullname==''  || isEmail(add_newadminemail)==false){
		showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }

        $("#add_newadminModal").modal('hide');
		
     $.ajax({
            url: "{{ route('add-update-admin') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
              fullname: add_newadminfullname,
			  email: add_newadminemail,
			  mobile : add_newadminmobile,
			  password:add_newadminpassword,
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
  
  
  function show_add_newadminModal(idx=0){
	  $('#add_newadminformid')[0].reset();
	  $('#add_newadmintypehid').val('Admin');
	  $('#customer-tab1a').click();
	  
	  if(idx==0){
		  $("#add_newadminModal").modal('show');
		  $('#hidaddnewacustomerid').val(0);
		}
		else if(idx>0){
		$('#add_newadminModalLabel').html('Edit');
		$('#hidaddnewacustomerid').val(idx);

     $.ajax({
            url: "{{ route('admin-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: idx
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data !== 'undefined' && data != null) {
				$("#add_newadminModal").modal('show');
				$('#hidaddnewacustomerid').val(data.id);
				$('#add_newadminfullname').val(data.fullname);
				$('#add_newadminemail').val(data.email);
				$('#add_newadminmobile').val(data.mobile);
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
		
		}
  }








</script> 
<!----Customer Add Snippet------ends------here------>