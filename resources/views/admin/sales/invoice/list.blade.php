@include('admin.layout.meta') 

<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar') 
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">{{ $control }} <a href="{{ route('invoices') }}" class="btn btn-primary float-right">Create New Invoice</a></h4>
            </div>
            <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab">Unpaid</a></li>
                <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">Draft</a></li>
                <li class="nav-item"><a class="nav-link" href="#bottom-tab3" data-toggle="tab">All Invoice</a></li>
              </ul>
              
              
               <div class="tab-content">
                <div class="tab-pane show active" id="bottom-tab1">
              <div class="table">
                <table id="t1" class="datatable table table-stripped" style="width:100%">
                  <thead>
                    <tr>
                      <th>Status</th>
                      <th>Due</th>
                      <th>Date</th>
                      <th>Invoice No.</th>
                      <th>Customer</th>
                      <th>Due Amount</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              </div>
              
               <div class="tab-pane show" id="bottom-tab2">
              <div class="table">
                <table id="t2" class="datatable table table-stripped" style="width:100%">
                  <thead>
                    <tr>
                      <th>Status</th>
                      <th>Date</th>
                      <th>Invoice No.</th>
                      <th>Customer</th>
                      <th>Amount</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              </div>
              
               <div class="tab-pane show" id="bottom-tab3">
              <div class="table">
                <table id="t3" class="datatable table table-stripped" style="width:100%">
                  <thead>
                    <tr>
                      <th>Status</th>
                      <th>Date</th>
                      <th>Invoice No.</th>
                      <th>Customer</th>
                      <th>Total</th>
                       <th>Amount Due</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
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
 		<form id="invoice_downloadpdf_formid" method="post" action="{{ route('download-customer-invoice') }}" enctype="multipart/form-data">
      <div class="modal-body">
       
          @csrf
          <input type="hidden" name="hidden_invoiceid_download" id="hidden_invoiceid_download" value="0" required="required">
          <h4>Your invoice is ready to be downloaded as a PDF.</h4>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="invoice_downloadpdf_submitbtnid">Download PDF</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!------modal ---------download------invoice---------pdf------------->


<!-- /Main Wrapper --> 
@include('admin.layout.js') 
<script type="text/javascript">
     var t1; var t2;  var t3; 
	 
	$.fn.dataTable.ext.errMode = 'none'; errorCount = 1;
	$('#t1,t2,t3').on('error.dt', function(e, settings, techNote, message) {
		if(errorCount>1){
   		showSweetAlert('something went wrong','please refresh page and try again', 0); 
		}
		else
		{
			t1.draw(false);t2.draw(false);t3.draw(false);
		}
		errorCount++;
	});


$(document).ready(function () {
	
	
   t3 = $('#t3').DataTable({
    processing: true,
	language: {
		processing: processingHTML_Datatable,
  	},
	serverSide: true,
 	paging: true,
	 searching: true,
    lengthMenu: [[10, 50, 100,500], [10, 50, 100,500]],
	pageLength: 10, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: {"invoice_status": "'P','R','U'" },
    url: "{{ route('get-invoice-list') }}" ,
	type: "get" 
	},
    aoColumnDefs: 
	[{ 
		'bSortable': false,
		 'aTargets': [-1] 
	}],
   }); 


   t2 = $('#t2').DataTable({
    processing: true,
	language: {
		processing: processingHTML_Datatable,
  	},
	serverSide: true,
 	paging: true,
	 searching: true,
    lengthMenu: [[10, 50, 100,500], [10, 50, 100,500]],
	pageLength: 10, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: {"invoice_status": "'D'" },
    url: "{{ route('get-invoice-list-draft') }}" ,
	type: "get" 
	},
    aoColumnDefs: 
	[{ 
		'bSortable': false,
		 'aTargets': [-1] 
	}],
   }); 


   t1 = $('#t1').DataTable({
    processing: true,
	language: {
		processing: processingHTML_Datatable,
  	},
	serverSide: true,
 	paging: true,
	 searching: true,
    lengthMenu: [[10, 50, 100,500], [10, 50, 100,500]],
	pageLength: 10, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: {"invoice_status": "'U','R'" },
    url: "{{ route('get-invoice-list-unpaid') }}" ,
	type: "get" 
	},
    aoColumnDefs: 
	[{ 
		'bSortable': false,
		 'aTargets': [-1] 
	}],
   }); 
   
   
});
	
	
				
$('body').on('click', '.deleteit', function () {
		var dataid = $(this).data('id');
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
            url: "{{ route('change-invoice-deleted') }}",
            data: {
              _token : '{{ csrf_token() }}',
              id: dataid,
			  status: 2, 
            },
            type: 'post',
            dataType: 'json',
            success: function (data) {
             t1.draw(false);t2.draw(false);t3.draw(false);
			  toast({
				type: 'success',
				title: data.msg,
				padding: '2em',
			  })

            },  error: function(){ showSweetAlert('Something Went Wrong!','please refresh page and try again', 0);  }
        });

      }
    });
});


$('body').on('click', '.editit', function () {
	var dataid = $(this).data('id');
	window.location.href = "{{ route('invoices') }}?edit="+dataid;
});


$('body').on('click', '.makeduplicateit', function () {
	var dataid = $(this).data('id');
	
	$.ajax({
            url: "{{ route('makeduplicate-invoice') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: dataid
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
					window.location.href = "{{ route('invoices') }}?edit="+data.data;
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
});

$('body').on('click', '.recordapaymentit', function () {
	var dataid = $(this).data('id');
	show_record_payment_invoiceModal(dataid);
});

$('body').on('click', '.exportpdfit', function () {
	var dataid = $(this).data('id');
	$("#hidden_invoiceid_download").val(dataid);
	$("#invoice_downloadpdfModal").modal('show');
});

$('body').on('click', '.approvedraftit', function () {
	var dataid = $(this).data('id');
	var x = confirm("Approve This Draft ?");
	if(x==true){
		$.ajax({
            url: "{{ route('draft-invoice-approve') }}",
            data: {
              _token:'{{ csrf_token() }}',
              invoice_id: dataid
            },
            type: 'post',
            dataType: 'json',
            success: function (e) {
				t1.draw(false);
				t2.draw(false);
				t3.draw(false);
				
				toast({
				type: 'success',
				title: e.msg,
				padding: '2em',
			  });
			  
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
	}

});


				
</script> 

<!----Add here global Js ----start----->
@include('admin.layout.snippets.record_payment_invoice') 
</body></html>