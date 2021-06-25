@include('admin.layout.meta') 

<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar') 
  <style>
  .btotalbill {
	  opacity:0.4;
	  }
  </style>
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">{{ $control }} <a href="{{ route('bills') }}" class="btn btn-primary float-right">Create New Bill</a></h4>
            </div>
            <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab">Bills</a></li>
              </ul>
              
              
               <div class="tab-content">
                <div class="tab-pane show active" id="bottom-tab1">
              <div class="table">
                <table id="t1" class="datatable table table-stripped" style="width:100%">
                  <thead>
                    <tr>
                      <th>Status</th>
                      <th>Date</th>
                      <th>Bill No.</th>
                      <th>Vendor</th>
                      <th>Due Amount</th>
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



<!-- /Main Wrapper --> 
@include('admin.layout.js') 
<script type="text/javascript">
     var t1; var t2;  var t3; 
	 
	$.fn.dataTable.ext.errMode = 'none';
	$('#t1').on('error.dt', function(e, settings, techNote, message) {
   		showSweetAlert('something went wrong','please refresh page and try again', 0); 
	});


$(document).ready(function () {

   t1 = $('#t1').DataTable({
    processing: true,
	language: {
		processing: processingHTML_Datatable,
  	},
	serverSide: true,
 	paging: true,
	 searching: true,
    lengthMenu: [[10, 50, 100,500,1000], [10, 50, 100,500,1000]],
	pageLength: 100, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: {"testonly": 1 },
    url: "{{ route('get-bills-list') }}" ,
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
            url: "{{ route('change-bills-deleted') }}",
            data: {
              _token : '{{ csrf_token() }}',
              id: dataid,
			  status: 2, 
            },
            type: 'post',
            dataType: 'json',
            success: function (data) {
             t1.draw(); 
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
	window.location.href = "{{ route('bills') }}?edit="+dataid;
});


$('body').on('click', '.makeduplicateit', function () {
	var dataid = $(this).data('id');
	
	$.ajax({
            url: "{{ route('makeduplicate-bill') }}",
            data: {
              _token:'{{ csrf_token() }}',
              id: dataid
            },
            type: 'get',
            dataType: 'json',
            success: function (data) {
					window.location.href = "{{ route('bills') }}?edit="+data.data;
            },
			error: function(jqXHR, textStatus, errorThrown) {
               showSweetAlert('Something Went Wrong!','An error occurred, Please Refresh Page and Try again.', 0); 
            },
        });
});

$('body').on('click', '.recordapaymentit', function () {
	var dataid = $(this).data('id');
	show_record_payment_billModal(dataid);
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
@include('admin.layout.snippets.record_payment_bill') 
</body></html>