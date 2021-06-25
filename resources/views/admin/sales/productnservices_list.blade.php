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
              <h4 class="card-title">{{ $control }} <a href="{{ route('product-services-sales') }}" class="btn btn-primary float-right">Add a Product Or Service</a></h4>
              
            </div>
            <div class="card-body">
              <div class="table">
                <table id="t1" class="datatable table table-stripped" style="width:100%">
                  <thead>
                    <tr>
                      <th width="15%">Name</th>
                      <th width="20%"> Description</th>
                      <th width="10%">Price</th>
                      <th width="20%">Action</th>
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
  <!-- /Page Wrapper --> 
  
</div>
<!-- /Main Wrapper --> 
@include('admin.layout.js')
<script type="text/javascript">
	 var tbl = '{{ $tbl }}';
	 var isdelete = 2;
     var t1; var t2; 
	 var Main_Category_Id = "{{ constants('Income_Main_Category_Id') }}";
	 
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
    lengthMenu: [[10, 50, 100,500], [10, 50, 100,500]],
	pageLength: 10, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: {"main_category_id": Main_Category_Id },
    url: "{{ route('get-productnservices') }}" ,
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
            url: "{{ route('change-pns-deleted') }}",
            data: {
              _token : '{{ csrf_token() }}',
              pnsid: dataid,
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


		
</script>

<!----Add here global Js ----start----->

</body>
</html>