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
              <h4 class="card-title">{{ $control }} <a href="javascript:void(0)" class="btn btn-success float-right" id="add_expense_category_btnid">Add Expense-Category</a><a href="javascript:void(0)" class="btn btn-primary float-right" id="add_income_category_btnid">Add Income-Category</a></h4>
            </div>
            <div class="card-body">
              <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab">Category</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane show active" id="bottom-tab1">
                  <div class="table">
                    <table id="t1" class="datatable table table-stripped" style="width:100%">
                      <thead>
                        <tr>
                          <th> Name</th>
                          <th>Main Category Name</th>
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
	 var tbl = '{{ $tbl }}';
     var t1; var t2; 
	 
	$.fn.dataTable.ext.errMode = 'none';
	$('#t1').on('error.dt', function(e, settings, techNote, message) {
   		showSweetAlert('something went wrong','please refresh page and try again', 0); 
	});


$(document).ready(function () {
	/*--------------*/
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
	pageLength: 50, 
	order: [[ 0, "desc" ]],
    ajax:  { 
    data: {"testonly": 1 },
    url: "{{ route('get-subcategory-list') }}" ,
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
	
	
				
$('body').on('click', '.change_statusit', function () {
		var id = $(this).data('id');
		var status = $(this).data('val');
		
		if(status==0){
			texttext = "Do You Want to DeActivate This ?";
		}
		else if(status==1){
			texttext = "Do You Want to Activate This ?";
		}
		else
		{
			return false;
		}
		
		
  swal({
      title: 'Are You Sure ?',
      text: texttext,
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      padding: '-2em'
    }).then(function(result) {
      if (result.value) {
		  
		 $.ajax({
            url: "{{ route('change-subcategory-status') }}",
            data: {
              _token : '{{ csrf_token() }}',
              id: id,
			  status: status, 
            },
            type: 'post',
            dataType: 'json',
            success: function (data) {
             t1.draw(); 
			 getTransactionAllAcountBalanace();
			  toast({
				type: 'success',
				title: 'Deleted Successfully.',
				padding: '2em',
			  })

            },  error: function(){ showSweetAlert('Something Went Wrong!','please refresh page and try again', 0);  }
        });

      }
    });
});

				
</script> 
<script type="text/javascript">
$('body').on('click', '#add_expense_category_btnid', function () {
	$('#sub_categoryformid')[0].reset();
	var val = "{{ constants('Expense_Main_Category_Id') }}";
	$("#hidmaincategoryid").val(val);
	$("#addnew_sub_category_typehid").val('Expense');
	show_add_newsubcategoryModal();
});

$('body').on('click', '#add_income_category_btnid', function () {
	$('#sub_categoryformid')[0].reset();
	var val = "{{ constants('Income_Main_Category_Id') }}";
	$("#hidmaincategoryid").val(val);
	$("#addnew_sub_category_typehid").val('Income');
	show_add_newsubcategoryModal();
});
$('body').on('click', '.editit', function () {
	$('#sub_categoryformid')[0].reset();
	var id = $(this).data('id');
	var typehid = $(this).data('typehid');
	$("#addnew_sub_category_typehid").val(typehid);
	show_add_newsubcategoryModal(id);
});
</script>
<!----Add here global Js ----start----->
@include('admin.layout.snippets.sub_category') 
</body></html>