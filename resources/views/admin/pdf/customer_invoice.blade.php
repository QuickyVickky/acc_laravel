<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>{{ @$one->customer->fullname }} Invoice {{ $one->invoice_number }}</title>
	<!--link href="{{ asset('fonts/arial-font/style.css')}}" rel="stylesheet" type="text/css" /-->

	</head>
    <style type="text/css">
thead, th {
	border-collapse: collapse;
}

body {
            font-family: 'Montserrat', sans-serif;
        }
@page{
  margin: 0.1in 0px;
}

</style>

	<body >
    <section style="position: relative;">
      <div style="margin: 0 auto;width: 100%; position: relative;">
        <div  style="display: table;width: 100%;padding-top: 15px;">
          <div  style="display: table-cell;width: 40%;vertical-align: top;padding-left: 30px;">
             <img src='{{ sendPath(constants("company_files")).$company_configurations->invoice_logo}}'  style="max-height: 100px;max-width: 150px;"> 
          </div>
          <div  style="display:table-cell; vertical-align: top; text-align: right; width: 60%;margin: 0 0 0 auto;padding-right: 30px;">
            <div  style="text-align: right; width: 60%;margin: 0 0 0 auto;">
              <p style="margin-top: 0px;margin-bottom: 0px; font-size: 36px;line-height: 22px; ">{{ $one->invoice_title }}</p>
              @if($one->invoice_description!='')
              <span style="margin: 0px;margin-top: 1px; margin-bottom: 10px; font-size: 13px;opacity: 0.4;">{{ $one->invoice_description }}</span>
              @endif
              <p style="margin: 0px;margin-top: 10px; font-size: 14px;"><b>{{ $company_configurations->company_name }}</b></p>
              <p style="margin: 0px;font-size: 14px;">{{ $company_configurations->address }} <br>
                {{ $company_configurations->landmark }} <br>
                {{ $company_configurations->city }}-{{ $company_configurations->pincode }} <br>
                {{ $company_configurations->state }},{{ $company_configurations->country }} <br>
                {{ $company_configurations->mobile }}
                </p>
            </div>
            <!--div style="text-align: right; width: 60%;margin: 0 0 0 auto;">
              <p style="margin: 0px;margin-top: 15px;"><b>Mobile:</b> <span>+91 1234567890</span></p>
              <p style="margin: 0px;">www.technomads.in</p>
            </div--> 
          </div>
        </div>
        <hr style="border: 1px solid #dee1e2;width: 100%;">
        <div class="party_bill_invoice" style="display:table;width: 100%; margin-top: 15px;">
          <div class="party-bill-name" style="display: table-cell; vertical-align: top;width: 50%; padding-left: 30px;">
            <p style="margin: 0px;opacity: 0.4;font-size: 14px;"><b>Bill To: </b>
            <p style="text-transform: capitalize; margin: 0px;font-size: 14px;"> <b>{{ @$one->customer->fullname }}</b> </p>
            @if(isset($one->customer->firstname) && $one->customer->firstname!='') 
            <p style="margin: 0px;font-size: 14px;">{{ @$one->customer->firstname }} {{ @$one->customer->lastname }}</p>
            @endif
            
            <p class="party_bill-address" style="text-transform: capitalize; max-width: 250px;margin: 0;margin-top: 8px;font-size: 13px;"> {{ @$one->customer->address }} </p>
            <p style="margin: 0px; margin-top: 3px;font-size: 14px;"><span>{{ @$one->customer->mobile }}</span></p>
            <p style="margin: 0px;font-size: 14px;">{{ @$one->customer->email }}</p>
          </div>
          <div class="party-bill-name" style="display: table-cell; vertical-align: top;width: 50%; text-align:right; margin:0 0 0 auto;padding-right: 0px;">
            <div style="max-width: 289px;margin: 0 0 0 auto;">
              <table style="border-collapse: collapse;">
                <tbody>
                  <tr>
                    <td colspan="2" style="text-align: right; padding-right: 5px;font-size: 14px;"><b>Invoice Number: </b></td>
                    <td colspan="1" style="padding-left: 10px;text-align: left;font-size: 14px;"><span>{{ @$one->invoice_number }}</span></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: right; padding-right: 5px;font-size: 14px;"><b>Invoice Date: </b></td>
                    <td colspan="1" style="padding-left: 10px;font-size: 14px;" ><span>{{  date('F d, Y',strtotime($one->invoice_date)) }}</span></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: right; padding-right: 5px;font-size: 14px;"><b>Payment Due: </b></td>
                    <td colspan="1" style="padding-left: 10px;font-size: 14px;"><span>{{  date('F d, Y',strtotime($one->payment_due_date)) }}</span></td>
                  </tr>
                  <tr style="background-color: #dee1e2;">
                    <td colspan="2" style="text-align: right; padding: 5px;font-size: 14px;"><b>Amount Due (INR):</b></td>
                    <td colspan="1" style="padding: 5px 5px 5px 10px; text-align: left;font-size: 14px;"><span>Rs. {{ $one->amount_due }}</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        
        
       



        <div  style="padding-top: 10px;">
          <div class="card-body">
            <div class="table-responsive">
            
             <div style="padding-top: 10px;">
          <div style="width: 100%;background-color: #21bee7;padding:8px 30px; display:table">
            <p style="margin:0px; font-size:15px;width: 40%;text-align: left; font-weight: bold;display:table-cell">Items</p>
            <p style="margin:0px; font-size:15px;width: 20%;text-align: center;font-weight: bold;display:table-cell">Quantity</p>
            <p style="margin:0px;font-size:15px;width: 20%;text-align: center;font-weight: bold;display:table-cell">Price</p>
            <p style="margin:0px;font-size:15px;width: 20%;text-align: right; font-weight: bold;display:table-cell">Amount</p>
          </div>
        </div>
        
        
        @if(isset($one->invoice_item) && !empty($one->invoice_item))
                @foreach($one->invoice_item as $row)
        <div style="padding-top: 0px;">
			<div style="width: 100%;padding:6px 30px; display:table">
            	<div style="display:table-cell;width:40%;max-width:40%;">
                    <p style="margin:0px;font-size:14px;font-weight: bold;text-align: left;">{{ $row->productnservice->name }} </p>
                    <p style="margin:0px;font-size:12px;text-align: left;max-width:96%;">{{ $row->description }}</p>
                </div>
                <p style="margin:0px;font-size:14px;width: 20%;text-align: center;display:table-cell">{{ $row->qty }}</p>
                <p style="margin:0px;font-size:14px;width: 20%;text-align: center;display:table-cell">{{ $row->price }}</p>
                <p style="margin:0px;font-size:14px;width: 20%;text-align: right; display:table-cell">Rs. {{ $row->amount }}</p>
              </div>
            </div>
            
             @endforeach
                @endif
            
            {{--
              <table class="table mb-0" style="width: 100%;text-align: left;border-collapse: collapse;">
                <thead>
                  <tr>
                    <th colspan="9" style="text-align: left;color: #21bee7;border-collapse: collapse;background-color: #21bee7;color: black; padding: 8px;padding-left: 30px;font-size: 15px;">Items</th>
                    <th colspan="1" style="text-align: center;color: #21bee7;border-collapse: collapse;background-color: #21bee7;color: black;padding: 8px;font-size: 15px;">Quantity</th>
                    <th colspan="1" style="text-align: center;color: #21bee7;border-collapse: collapse;background-color: #21bee7;color: black;padding: 8px;font-size: 15px;">Price</th>
                    <th colspan="1" style="text-align: right;color: #21bee7;border-collapse: collapse;background-color: #21bee7;color: black;padding: 8px; padding-right: 30px;font-size: 15px;">Amount</th>
                  </tr>
                </thead>
                <tbody>
                
                @if(isset($one->invoice_item) && !empty($one->invoice_item))
                @foreach($one->invoice_item as $row)
                <tr style="vertical-align: top;">
                  <td colspan="9" style="text-transform: capitalize;font-weight: bold;padding-left: 30px;padding-bottom: 5px;padding-top: 8px;font-size: 14px; ">{{ $row->productnservice->name }} <br> <span style="font-size: 12px;opacity: .7;">{{ $row->description }}</span></td>
                  <td colspan="1" style="text-align: center;padding: 5px;padding-top: 8px;font-size: 14px;">{{ $row->qty }}</td>
                  <td colspan="1" style="text-align: center;padding: 5px;padding-top: 8px;font-size: 14px;"> {{ $row->price }}</td>
                  <td colspan="1" style="text-align: right;padding: 5px;padding-right: 30px;padding-top: 8px;font-size: 14px;">Rs. {{ $row->amount }}</td>
                </tr>
                @endforeach
                @endif
                  </tbody>
                
              </table>
              --}}
              <div style="border-top: 2px solid #dee1e2; ">
              </div>


             <div style="width: 100%;text-align: right;">
                <div style="border-top: 2px solid #dee1e2;padding-right: 30px; ">
                  <div style="text-align: right;">
                    <div style="display: table;width: 100%;text-align: right;">
                      <div style="padding-right: 5px; display: table-cell;width: 82%;padding-top: 5px;font-size: 15px;"><b>Subtotal:</b></div>
                      <div style="min-width: 18%;text-align: right; display: table-cell;padding-top: 5px;font-size: 15px;">Rs. {{ $one->subtotal }} </div>
                    </div>
                  </div>
                  <div style="text-align: right;">
                    <div style="display: table;width: 100%;text-align: right;">
                      <div style="padding-right: 5px; display: table-cell;width: 82%;padding-top: 5px;font-size: 15px;"><b>Tax:</b></div>
                      <div style="min-width: 18%;text-align: right; display: table-cell;padding-top: 5px;font-size: 15px;">Rs. {{ $one->tax_total }}</div>
                    </div>
                  </div>
                  <div style="border-bottom: 1px solid #dee1e2; max-width:400px;text-align: right;margin:10px 0 10px auto;"></div>
                  <div style="text-align: right;">
                    <div style="display: table;width: 100%;">
                      <div style="padding-right: 5px; display: table-cell;width: 82%;padding-top: 5px;font-size: 15px;"><b>Total:</b></div>
                      <div style="min-width: 18%;text-align: right; display: table-cell;padding-top: 5px;font-size: 15px;">Rs. {{ $one->total }}</div>
                    </div>
                  </div>

                  @if(isset($one->transaction) && !empty($one->transaction))
                  @foreach($one->transaction as $tr)
                  <div>
                    <div>
                      <div style="text-align: right;">
                        <div style="display: table; width: 100%;">
                          <div style="padding-right: 5px; display: table-cell;width: 82%; font-size: 12px;padding-top: 3px;">Payment on {{  date('F d, Y',strtotime($tr->transaction_date)) }} using {{  $tr->payment_method_name->name }}:</div>
                          <div style="min-width: 18%;text-align: right; display: table-cell;font-size: 12px;padding-top: 3px;">Rs. {{  $tr->amount }} </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  @endif
                  <div style="border-bottom: 3px solid #dee1e2; max-width:600px;text-align: right;margin:10px 0 10px auto;"></div>
                  <div style="display: table;width: 100%;text-align: right;">
                    <div style="padding: 5px; padding-right: 0px; display: table-cell;width: 82%;font-size: 15px;"> <strong>Amount Due (INR): </strong> </div>
                    <div style="min-width: 18%;text-align: right;padding: 5px; padding-left: 0px; display: table-cell;font-size: 15px;">Rs.  {{ $one->amount_due }}</div>
                  </div>
                  
                </div>
             </div>



              <div>
              @if($one->invoice_comment!='')
                <div style="padding-left: 30px;">
                  <p style="margin: 0px;margin-top: 20px;font-size: 14px;"><b>Notes / Terms</b></p>
                  <p style="margin: 0px;margin-top: 8px;font-size: 13px;">{!! nl2br($one->invoice_comment) !!}</p>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
       
     </div>
    </section>
	
    @if($one->footer_comment!='')
    <footer style="width:100%;">
      			
                <div>
                  <p style="text-align: center;position: absolute;bottom: 0;left: 0;padding-left: 30px; opacity: 0.4;font-size: 14px;right:0;padding-right:30px;">{!! nl2br($one->footer_comment) !!} </p>
                </div>
                
    </footer>
    @endif
</body>
</html>
<!--span>&#x20B9;</span-->