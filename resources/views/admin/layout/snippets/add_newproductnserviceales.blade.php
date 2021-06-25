<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_newpnssalesModal"> Launch Add-Account modal</button-->
<!-- Add-Account Modal Starts -->

<div class="modal fade" id="add_newpnssalesModal" tabindex="-1" role="dialog" aria-labelledby="add_newpnssalesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_newpnssalesModalLabel"> Product or Services</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs nav-tabs-bottom">
          <li class="nav-item"><a class="nav-link active" href="#pnssales-tab1" data-toggle="tab" id="pnssales-tab1a">Sales</a></li>
        </ul>
        <form id="add_newpnssalesformid">
          @csrf
          <input type="hidden" name="hidaddnewpnssalesid" id="hidaddnewpnssalesid" value="0" >
          <input type="hidden" id="add_newpnssales_is_active" name="add_newpnssales_is_active" value="1">
          <input type="hidden" id="add_newpnssales_typehid" name="add_newpnssales_typehid" value="Sale" >
          <input type="hidden" id="add_newpnssales_main_category_hid" name="add_newpnssales_main_category_hid" value="{{ constants('Income_Main_Category_Id') }}">
          <div class="tab-content">
            <div class="tab-pane show active" id="pnssales-tab1">
              <div class="row">
                <div class="form-group col-md-6">
                  <label>Sale Income Account * </label>
                  <select class="form-control" name="add_newpnssales_sub_category_id" id="add_newpnssales_sub_category_id" required>
                    @foreach(getIncome_Subcategory() as $isb)
                    <option value="{{ $isb->id }}" >{{ $isb->name }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Tax (optional) </label>
                  <select class="form-control" name="add_newpnssales_tax_id" id="add_newpnssales_tax_id" required>
                    @foreach(getTax() as $t)
                    <option value="{{ $t->id }}" >{{ $t->abbreviation }} {{ ($t->current_tax_rate>0) ? $t->current_tax_rate.' %' : ''}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-6">
                    <label>Name *</label>
                    <input type="text" name="add_newpnssales_name_id" class="form-control" id="add_newpnssales_name_id" placeholder="Name" required>
                  </div>
                   <div class="form-group col-md-6">
                  <label>Price &#x20B9; *</label>
                  <input type="text" name="add_newpnssales_price_id" class="form-control" id="add_newpnssales_price_id" placeholder="Price" value="0.00" maxlength="17" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8 || event.keyCode === 46;">
                </div>
              </div>
              <div class="form-group">
                <label>Description (optional)</label>
                <textarea type="text" rows="3" name="add_newpnssales_description" class="form-control" id="add_newpnssales_description" placeholder="Description"></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_newpnssalesformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Add-Account Modal Ends --> 
<!----vendor Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#add_newpnssalesformsaveid', function () {
        var id = $('#hidaddnewpnssalesid').val();
		var add_newpnssales_description = $('#add_newpnssales_description').val();
		var add_newpnssales_sub_category_id = $('#add_newpnssales_sub_category_id').val();
		var add_newpnssales_tax_id = $('#add_newpnssales_tax_id').val();
		var add_newpnssales_name_id = $('#add_newpnssales_name_id').val();
		var add_newpnssales_price_id = $('#add_newpnssales_price_id').val();
		var add_newpnssales_is_active = $('#add_newpnssales_is_active').val();
		var add_newpnssales_typehid = $('#add_newpnssales_typehid').val();
		var add_newpnssales_main_category_hid = $('#add_newpnssales_main_category_hid').val();
		
		
        if(id=='' || add_newpnssales_tax_id<1 || add_newpnssales_name_id=='' || add_newpnssales_is_active=='' || add_newpnssales_typehid=='' || add_newpnssales_price_id=='' || add_newpnssales_sub_category_id<1 || add_newpnssales_main_category_hid<1 ){
		showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }

        $("#add_newpnssalesModal").modal('hide');
		
     $.ajax({
            url: "{{ route('add-update-product-services-direct') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
              name: add_newpnssales_name_id,
			  price: add_newpnssales_price_id,
			  typehid: add_newpnssales_typehid,
			  main_category_hid: add_newpnssales_main_category_hid,
			  is_active : add_newpnssales_is_active,
			  sub_category : add_newpnssales_sub_category_id,
			  tax_id : add_newpnssales_tax_id,
			  description : add_newpnssales_description,
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				if(e.success==1){
					showSweetAlert("Completed",e.msg, 1); 
              		//t1.draw(false);
				}
				else
				{
					showSweetAlert("Error",e.msg, 0); 
              		//t1.draw(false);
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
                showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
  });
  
  
  function show_add_newpnssalesModal(idx=0){
	  $('#add_newpnssalesformid')[0].reset();
	  $('#add_newpnssales_typehid').val('Sale');
	  
	  if(idx==0){
		  $("#add_newpnssalesModal").modal('show');
		  $('#hidaddnewpnssalesid').val(0);
		}
		else if(idx>0){
		$('#add_newpnssalesModalLabel').html('Edit');
		$('#hidaddnewpnssalesid').val(idx);

     $.ajax({
            url: "{{ route('productservice-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: idx
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				if (typeof data !== 'undefined' && data != null) {
				$("#add_newpnssalesModal").modal('show');
				$('#hidaddnewpnssalesid').val(data.id);
				$('textarea#add_newpnssales_description').val(data.description);
				$('#add_newpnssales_sub_category_id').val(data.sub_category_id);
				$('#add_newpnssales_tax_id').val(data.tax_id);
				$('#add_newpnssales_name_id').val(data.name);
				$('#add_newpnssales_price_id').val(data.price);
				$('#add_newpnssales_is_active').val(data.is_active);
				}
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
		
		}
  }







</script> 
<!----vendor Add Snippet------ends------here------>