<!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#record_payment_billModal"> Launch Add-Account modal</button-->

<!-- record_payment_billModal Modal Starts -->

<div class="modal fade" id="record_payment_billModal" tabindex="-1" role="dialog" aria-labelledby="record_payment_billModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="record_payment_billModalLabel">Record Payment Bill</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>

      <div class="modal-body">
        <form id="record_payment_billformid">
          @csrf
          <input type="hidden" name="hidbillid" id="hidbillid" value="0" >
           <input type="hidden" name="hidtransactionsid_ofbill" id="hidtransactionsid_ofbill" value="0" >
          <div class="row">
          <div class="form-group col-md-6">
            <label>Payment Type * </label>
            <select class="form-control" name="record_payment_bill_method_id" id="record_payment_bill_method_id" required>
                    @foreach(ShortHelper("payment_method") as $pm)
                      <option value="{{ $pm->short }}" >{{ $pm->name }}</option>
                      @endforeach
                    </select>
          </div>
          <div class="form-group col-md-6">
            <label>Payment Date * </label>
            <input type="date" name="record_payment_bill_paymentdate" class="form-control" id="record_payment_bill_paymentdate" placeholder="Enter Account Name" value="{{ date('Y-m-d') }}" required>
          </div>
          </div>
          
          <div class="form-group">
            <label>Amount *</label>
            <input type="text" name="record_payment_bill_amount_id" class="form-control" id="record_payment_bill_amount_id" placeholder="Amount" value="0.00" maxlength="17" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8 || event.keyCode === 46;">
          </div>
          
          <div class="form-group">
            <label>Payment Account * </label>
            <select class="form-control" name="record_payment_bill_accounts_or_banks_id" id="record_payment_bill_accounts_or_banks_id" required>
                    @foreach(AccountnBanks() as $ab)
                      <option value="{{ $ab->id }}" >{{ $ab->name }}</option>
                      @endforeach
                    </select>
          </div>
          <div class="form-group">
            <label>Memo/Notes (optional)</label>
            <textarea type="text" rows="3" name="record_payment_bill_description" class="form-control" id="record_payment_bill_description" placeholder="Description"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="record_payment_billformsaveid">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- -record_payment_billModal Modal Ends --> 
<!----Customer Add Snippet------starts------here------> 
<script type="text/javascript" >
$('body').on('click', '#record_payment_billformsaveid', function () {
        var id = $('#hidbillid').val();
		var record_payment_bill_method_id = $('#record_payment_bill_method_id').val();
		var record_payment_bill_paymentdate = $('#record_payment_bill_paymentdate').val();
		var record_payment_bill_amount_id = $('#record_payment_bill_amount_id').val();
		var record_payment_bill_accounts_or_banks_id = $('#record_payment_bill_accounts_or_banks_id').val();
		var record_payment_bill_description = $('textarea#record_payment_bill_description').val();
		var hidtransactionsid_ofbill = $('#hidtransactionsid_ofbill').val();
	
        if(id<1 || record_payment_bill_paymentdate=='' || record_payment_bill_amount_id=='' || record_payment_bill_method_id=='' || record_payment_bill_accounts_or_banks_id<1 || hidtransactionsid_ofbill==''){
		 showSweetAlert('Error','Please Check All Required Fields.', 0); 
          return false;
        }

        $("#record_payment_billModal").modal('hide');
		
     $.ajax({
            url: "{{ route('add-update-bill-record-payment') }}",
            data: {
              _token:'{{ csrf_token() }}',
              hid: id, 
              payment_method: record_payment_bill_method_id,
			  transaction_date: record_payment_bill_paymentdate,
			  amount: record_payment_bill_amount_id,
			  accounts_or_banks_id: record_payment_bill_accounts_or_banks_id,
			  notes: record_payment_bill_description,
			  is_editable : 1,
			  is_active: 1,
			  transaction_type: 'Dr',
			  transactions_id : hidtransactionsid_ofbill,
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				showSweetAlert("Completed",e.msg, 1); 
				if(typeof t1 !== "undefined"){ t1.draw(false); } 
            },
			error: function(jqXHR, textStatus, errorThrown) {
                showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
  });
  
  
  function show_record_payment_billModal(idx=0) {
	  $('#record_payment_billformid')[0].reset();
	  if(idx==0){
		  return false;
		}
		else if(idx>0){
			$('#hidbillid').val(idx);

     $.ajax({
            url: "{{ route('bills-getedit') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: idx
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
				$("#record_payment_billModal").modal('show');
			  	$('#hidbillid').val(data.id);
			  	$('#record_payment_bill_amount_id').val(data.amount_due);
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
		
			
		}
  }












</script> 
<!----record_payment_billModal Snippet------ends------here------>