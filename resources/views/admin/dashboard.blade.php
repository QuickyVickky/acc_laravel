@include('admin.layout.meta') 
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar')
  <?php

$last12months = array(); 
$last12months_name = array(); 
$thisyearallincomeinjson = [];  
$thisyearallexpensesinjson = []; 
$thisyearallNetChangeinjson = []; 
$ThisMonth_Expenses_Breakdown_injson_Series = []; 
$ThisMonth_Expenses_Breakdown_injson_Labels = []; 




$now = date('Y-m');
for($x = 11; $x >= 0; $x--) {
    $ym = date('Y-m', strtotime($now . " -$x month"));
    $last12months[$x] = $ym;
	$last12months_name[] = date('M-Y', strtotime($now . " -$x month"));
	$thisyearallexpensesinjson[$ym] = 0; 
	$thisyearallincomeinjson[$ym] = 0; 
	$thisyearallNetChangeinjson[$ym] = 0; 
}

		foreach($chartdata['last12monthsdata'] as $row){
			if(strlen($row->month_number)!=2) {   $row->month_number = "0".$row->month_number; }
			if($row->transaction_type=='Cr'){
				  $thisyearallincomeinjson[$row->year_number."-".$row->month_number] =  round($row->total_amount,2) ;
			}
			else
			{
				$thisyearallexpensesinjson[$row->year_number."-".$row->month_number] =   round($row->total_amount,2) ;
			}
		}
		
		foreach($thisyearallincomeinjson as $key2 => $row2){
			$thisyearallNetChangeinjson[$key2] =  round($row2-$thisyearallexpensesinjson[$key2],2) ;
		}
		
		foreach($chartdata['thismonth_expensebreakdown_data'] as $eb){
			if($eb->transaction_type=='Dr'){
			$ThisMonth_Expenses_Breakdown_injson_Series[] = round($eb->total_amount,2);
			$ThisMonth_Expenses_Breakdown_injson_Labels[] = trim($eb->abname);
			}
		}
		

?>
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid">
      <div class="row">
        <div class="col">
          <h3 class="page-title">{{ $control }}</h3>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-rounded btn-primary page-header-button dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Create a New For</button>
          <div class="dropdown-menu" style=""> <a class="dropdown-item" href="{{ route('invoices') }}">Invoice</a> <a class="dropdown-item" href="{{ route('bills') }}">Bill</a> <a class="dropdown-item" href="{{ route('customer-list') }}">Customer</a> <a class="dropdown-item" href="{{ route('vendor-list') }}">Vendor</a> <a class="dropdown-item" href="{{ route('product-services-sales') }}">Product/Service Sales</a> <a class="dropdown-item" href="{{ route('product-services-expense') }}">Product/Service Purchase</a> </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header"> <span class="dash-widget-icon bg-1"> <i class="fas fa-rupee-sign"></i> </span>
                <div class="dash-count">
                  <div class="dash-title">Amount Due</div>
                  <div class="dash-counts">
                    <p>{{ @$all_time['invoice_amount_due'] }}</p>
                  </div>
                </div>
              </div>
              <div class="progress progress-sm mt-3">
                <div class="progress-bar bg-5" role="progressbar" style="width: 83%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <p class="text-muted mt-3 mb-0">All Time Invoice</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12" >
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header"> <span class="dash-widget-icon bg-2"> <i class="fas fa-users"></i> </span>
                <div class="dash-count">
                  <div class="dash-title">Customers</div>
                  <div class="dash-counts">
                    <p>{{ @$all_time['customer_count'] }}</p>
                  </div>
                </div>
              </div>
              <div class="progress progress-sm mt-3">
                <div class="progress-bar bg-6" role="progressbar" style="width: 65%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <p class="text-muted mt-3 mb-0">Total Customers</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12" style="visibility:hidden">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header"> <span class="dash-widget-icon bg-3"> <i class="fas fa-file-alt"></i> </span>
                <div class="dash-count">
                  <div class="dash-title">Invoices</div>
                  <div class="dash-counts">
                    <p>{{ @$all_time['invoice_count'] }}</p>
                  </div>
                </div>
              </div>
              <div class="progress progress-sm mt-3">
                <div class="progress-bar bg-7" role="progressbar" style="width: 85%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <p class="text-muted mt-3 mb-0">All Invoices</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12" style="visibility:hidden">
          <div class="card">
            <div class="card-body">
              <div class="dash-widget-header"> <span class="dash-widget-icon bg-4"> <i class="far fa-file"></i> </span>
                <div class="dash-count">
                  <div class="dash-title">Bills</div>
                  <div class="dash-counts">
                    <p>{{ @$all_time['bill_count'] }}</p>
                  </div>
                </div>
              </div>
              <div class="progress progress-sm mt-3">
                <div class="progress-bar bg-8" role="progressbar" style="width: 45%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <p class="text-muted mt-3 mb-0">All Bills</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-12 d-flex">
          <div class="card flex-fill">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Profit & Loss</h5>
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap">
                <div class="w-md-100 d-flex align-items-center mb-3">
                  <div> <span>Total Income</span>
                    <p class="h3 text-primary mr-5">₹ {{ @end($thisyearallincomeinjson) }}</p>
                  </div>
                  <div> <span>Total Expense</span>
                    <p class="h3 text-danger mr-5">₹ {{ @end($thisyearallexpensesinjson) }}</p>
                  </div>
                  <div> <span>Total Net Change</span>
                    <p class="h3 text-dark mr-5">₹ {{ @end($thisyearallNetChangeinjson) }}</p>
                  </div>
                </div>
              </div>
              <div id="salesnexpense_chart_id"></div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col">
                  <h5 class="card-title">Recent OverDue Invoices</h5>
                </div>
                <div class="col-auto"> <a href="{{ route('invoice-list') }}" class="btn-right btn btn-sm btn-outline-primary"> View All </a> </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-stripped table-hover">
                  <thead class="thead-light">
                    <tr>
                      <th>Customer</th>
                      <th>Amount</th>
                      <th>Due Date</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  @if(!empty($all_time['recent_invoice']))
                  @foreach($all_time['recent_invoice'] as $riv)
                  <tr>
                    <td>{{ $riv->cfullname }} </td>
                    <td>₹ {{ $riv->amount_due }}</td>
                    <td>{{ date('d-M-Y',strtotime( $riv->invoice_date)) }}</td>
                    <td><span class="badge bg-danger-light">Overdue</span></td>
                  </tr>
                  @endforeach
                  @endif
                    </tbody>
                  
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col">
                  <h5 class="card-title">Recent OverDue Bills</h5>
                </div>
                <div class="col-auto"> <a href="{{ route('bills-list') }}" class="btn-right btn btn-sm btn-outline-primary"> View All </a> </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="thead-light">
                    <tr>
                      <th>Vendor</th>
                      <th>Amount</th>
                      <th>Due Date</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  @if(!empty($all_time['recent_bill']))
                  @foreach($all_time['recent_bill'] as $rb)
                  <tr>
                    <td>{{ $rb->vfullname }} </td>
                    <td>₹ {{ $rb->amount_due }}</td>
                    <td>{{ date('d-M-Y',strtotime( $rb->bill_date)) }}</td>
                    <td><span class="badge bg-danger-light">Overdue</span></td>
                  </tr>
                  @endforeach
                  @endif
                    </tbody>
                  
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-5 d-flex">
          <div class="card flex-fill">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Expenses Breakdown (This-Month)</h5>
              </div>
            </div>
            <div class="card-body">
              <div id="Expenses_Breakdown_Chart_Id_ThisMonth" style="min-height: 350.7px;"></div>
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

<!-- Chart JS --> 
<script src="{{ asset('admin_assets/assets/plugins/apexchart/apexcharts.min.js') }}"></script> 
<script type="text/javascript">
var last12months_name_injson =  <?php echo json_encode($last12months_name); ?>;
var last12months_income_injson =  <?php echo json_encode(array_values($thisyearallincomeinjson)); ?>;
var last12months_expenses_injson =  <?php echo json_encode(array_values($thisyearallexpensesinjson)); ?>;
var last12months_NetChange_injson =  <?php echo json_encode(array_values($thisyearallNetChangeinjson)); ?>;
var ThisMonth_Expenses_BreakdownSeries_injson =  <?php echo json_encode(array_values($ThisMonth_Expenses_Breakdown_injson_Series)); ?>;
var ThisMonth_Expenses_BreakdownLabels_injson =  <?php echo json_encode(array_values($ThisMonth_Expenses_Breakdown_injson_Labels)); ?>;


$(document).ready(function() {
	
	
	/*-------------------------------------*/
	
        var Variable_salesnexpense_chart_id = {
			colors: ['#7638ff', '#fda600','#DA20A7'],
          series: [
			{
			name: "Income",
		
			data: last12months_income_injson
			},
			{
			name: "Expense",
		
			data: last12months_expenses_injson
			},
			{
			name: "Net Change",
			data: last12months_NetChange_injson
			}
		],
          chart: {
          height: 350,
		  fontFamily: 'Poppins, sans-serif',
          type: 'line',
          zoom: {
            enabled: true
          },
		  toolbar: {
				show: false
			},
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Cash Flow',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], 
            opacity: 0.5
          },
        },
        xaxis: {
          categories: last12months_name_injson,
        }
        };

        var chart_Variable_salesnexpense_chart_id = new ApexCharts(document.querySelector("#salesnexpense_chart_id"), Variable_salesnexpense_chart_id);
        chart_Variable_salesnexpense_chart_id.render();
		
		
		/*------------This--month----Expenses_Breakdown-- CHart--------start----------*/

		
//Pie Chart
	var Variable_Expenses_Breakdown_Chart_Id_ThisMonth = document.getElementById("Expenses_Breakdown_Chart_Id_ThisMonth"),
	pieConfig = {
		colors: ['#7638ff', '#ff737b', '#fda600', '#1ec1b0', ''],
		series: ThisMonth_Expenses_BreakdownSeries_injson,
		chart: {
			fontFamily: 'Poppins, sans-serif',
			height: 350,
			type: 'donut',
		},
		labels: ThisMonth_Expenses_BreakdownLabels_injson,
		legend: {show: false},
		responsive: [{
			breakpoint: 480,
			options: {
				chart: {
					width: 200
				},
				legend: {
					position: 'bottom'
				}
			}
		}]
	};
	var Chart_Variable_Expenses_Breakdown_Chart_Id_ThisMonth = new ApexCharts(Variable_Expenses_Breakdown_Chart_Id_ThisMonth, pieConfig);
	Chart_Variable_Expenses_Breakdown_Chart_Id_ThisMonth.render();
		
		
/*----------------Expenses_Breakdown-- CHart-----end-------------*/
		/*------------------------------------------*/



	// Column chart
	/*
	var Variable_salesnexpense_chart_id = document.getElementById("salesnexpense_chart_id"),
	columnConfig = {
		colors: ['#7638ff', '#fda600','#DA20A7'],
		series: [
			{
			name: "Income",
			type: "column",
			data: last12months_income_injson
			},
			{
			name: "Expense",
			type: "column",
			data: last12months_expenses_injson
			},
			{
			name: "Net Change",
			type: "column",
			data: last12months_NetChange_injson
			}
		],
		chart: {
			type: 'bar',
			fontFamily: 'Poppins, sans-serif',
			height: 350,
			toolbar: {
				show: false
			}
		},
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '60%',
				endingShape: 'rounded'
			},
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		xaxis: {
			categories: last12months_name_injson,
		},
		yaxis: {
			title: {
				text: '₹ (Rupee)'
			}
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return "₹ " + val + " Rupee"
				}
			}
		}
	};
	var columnChart_salesnexpense_chart = new ApexCharts(Variable_salesnexpense_chart_id, columnConfig);
	columnChart_salesnexpense_chart.render();
	
	*/


  
});

</script>