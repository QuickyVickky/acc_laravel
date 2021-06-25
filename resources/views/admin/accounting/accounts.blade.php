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
              <h4 class="card-title">{{ $control }} <a href="javascript:void(0)" class="btn btn-primary float-right" onclick="show_add_newaccountModal()">Add A New Account</a></h4>
            </div>
            <div class="card-body">
              <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab">All Accounts</a></li>
                <!--li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">Sub-Category</a></li-->
              </ul>
              <div class="tab-content">
                <div class="tab-pane show active" id="bottom-tab1">
                  <div class="table-responsive">
                     <table id="t1" class="datatable table table-stripped" style="width:100%">
                      <thead>
                        <tr>
                          <th>Names</th>
                          <th>Description</th>
                          <th>Category</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="bottom-tab2">
                  
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
	 var tbl = '{{ $tbl }}';
     var t1; var t2; 
	 
	$.fn.dataTable.ext.errMode = 'none';
	$('#t1').on('error.dt', function(e, settings, techNote, message) {
   		showSweetAlert('something went wrong','please refresh page and try again', 0); 
	});


$(document).ready(function () {
	/*--------------*/
   t1 = $('#t1').DataTable({
    processing: true,
	language: {
		processing: processingHTML_Datatable,
  	},
	serverSide: true,
 	paging: true,
	 searching: true,
     lengthMenu: [[10, 50, 100,500,1000], [10, 50, 100,500,1000]],
	pageLength: 10, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: {"testonly": 1 },
    url: "{{ route('get-all-accounts-data') }}" ,
	type: "get" 
	},
    aoColumnDefs: 
	[{ 
		'bSortable': false,
		 'aTargets': [-1] 
	}],
   }); 
  /*--------------*/
});
	
				
</script> 

<!----Add here global Js ----start----->
@include('admin.layout.snippets.add_newaccount') 
</body></html>