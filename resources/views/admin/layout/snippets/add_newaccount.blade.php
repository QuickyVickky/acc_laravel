<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_newaccountModal"> Launch Add-Account modal</button-->

<!-- Add-Account Modal Starts -->

<div class="modal fade" id="add_newaccountModal" tabindex="-1" role="dialog" aria-labelledby="add_newaccountModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_newaccountModalLabel">Add-Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form id="add_newaccountformid">
          @csrf
          <input type="hidden" name="hidaddnewaccountid" id="hidaddnewaccountid" value="0" >
          <div class="form-group">
            <label>Account Type * </label>
            <select class="form-control" name="add_newaccount_category_id" id="add_newaccount_category_id" required>
                    @foreach(getAccount_Category() as $row)
                    @if($row->level==0)
                     <optgroup label="{{ $row->name }}" >
                      @foreach(getAccount_Category() as $r)
                    @if($r->level==1 && $row->id==$r->path_to)
                      <option value="{{ $r->id }}" >{{ $r->name }}</option>
                      @endif
                    @endforeach
                      </optgroup>
                      @endif
                    @endforeach
                    </select>
          </div>
          
          <div class="form-group">
            <label>Account Name * </label>
            <input type="text" name="add_newaccount_name" class="form-control" id="add_newaccount_name" placeholder="Enter Account Name" value="" required>
          </div>
          
          <div class="form-group">
            <label>Account Id (optional)</label>
            <input type="text" name="add_newaccount_id" class="form-control" id="add_newaccount_id" placeholder="Account Id" value="">
          </div>
          
          
          <div class="form-group">
            <label>Description (optional)</label>
            <input type="text" name="add_newaccount_description" class="form-control" id="add_newaccount_description" placeholder="Description" value="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_newaccountformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Add-Account Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#add_newaccountformsaveid', function () {
        var id = $('#hidaddnewaccountid').val();
		var add_newaccount_name = $('#add_newaccount_name').val();
		var add_newaccount_category_id = $('#add_newaccount_category_id').val();
		var add_newaccount_description = $('#add_newaccount_description').val();
		var add_newaccount_id = $('#add_newaccount_id').val();
		var add_newaccount_status = 1; 

        if(id=='' || add_newaccount_name=='' || add_newaccount_status=='' || add_newaccount_category_id<1 ){
		showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }

        $("#add_newaccountModal").modal('hide');
		
     $.ajax({
            url: "{{ route('add-update-all-accounts') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
              name: add_newaccount_name,
			  account_category_id: add_newaccount_category_id,
			  description: add_newaccount_description,
			  status: add_newaccount_status,
			  account_id: add_newaccount_id,
			  is_editable : 1,
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				showSweetAlert("Completed",e.msg, 1); 
              	t1.draw(false);
				if (typeof getTransactionAllAcountBalanace == 'function') { 
				getTransactionAllAcountBalanace();
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
                showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
  });
  
  
  function show_add_newaccountModal(idx=0){
	  $('#add_newaccountformid')[0].reset();
	  if(idx==0){
		  $("#add_newaccountModal").modal('show');
		  $('#hidaddnewaccountid').val(0);
		}
		else if(idx>0){
			
		$('#add_newaccountModalLabel').html('Edit');
		$('#hidaddnewaccountid').val(idx);

     $.ajax({
            url: "{{ route('edit-all-accounts') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: idx
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data !== 'undefined' && data.length > 0) {
				$("#add_newaccountModal").modal('show');
			  	$('#hidaddnewaccountid').val(data[0].id);
			  	$('#add_newaccount_category_id').val(data[0].account_category_id);
				$('#add_newaccount_name').val(data[0].name);
				$('#add_newaccount_id').val(data[0].account_id);
		 		$('#add_newaccount_description').val(data[0].description);
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