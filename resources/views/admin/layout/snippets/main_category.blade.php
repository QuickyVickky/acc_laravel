<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#main_categoryModal"> Launch Main-Category modal</button-->

<!-- Main-Category Modal Starts -->

<div class="modal fade" id="main_categoryModal" tabindex="-1" role="dialog" aria-labelledby="main_categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="main_categoryModalLabel">Main-Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form id="main_categoryformid">
          @csrf
          <input type="hidden" name="hidmaincategoryid" id="hidmaincategoryid" value="0" >
          <div class="form-group">
            <label>Name * </label>
            <input type="text" name="main_category_name" class="form-control" id="main_category_name" placeholder="Enter Main-Category Name" value="" required>
          </div>
          <div class="form-group">
            <label>Addtional Name (optional)</label>
            <input type="text" name="main_category_name2" class="form-control" id="main_category_name2" placeholder="Addtional Name (optional)" value="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="main_categoryformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Main-Category Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#main_categoryformsaveid', function () {
        var id = $('#hidmaincategoryid').val();
		var main_category_name = $('#main_category_name').val();
		var main_category_name2 = $('#main_category_name2').val();
		var main_category_status = 1; 

        if(id=='' || main_category_name=='' || main_category_status==''){
		showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }

        $("#main_categoryModal").modal('hide');
		
     $.ajax({
            url: "{{ route('add-update-maincategory') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
              name: main_category_name,
			  name2: main_category_name2,
			  status: main_category_status,
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				showSweetAlert("Completed",e.msg, 1); 
              	t1.draw(false);
            },
			error: function(jqXHR, textStatus, errorThrown) {
                showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
  });












</script> 
<!----Customer Add Snippet------ends------here------>