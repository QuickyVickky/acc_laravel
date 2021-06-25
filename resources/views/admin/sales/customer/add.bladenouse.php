@include('admin.layout.meta') 
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar') 
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid"> @php
    
    
      if(count($one)>0){
      $control = 'Edit Customer';
      }
      else
      {
      $control = 'Add Customer';
      }
      @endphp 
      
      <!-- Page Header -->
      <div class="page-header">
        <div class="row">
          <div class="col">
            <h3 class="page-title">{{ $control }} </h3>
          </div>
        </div>
      </div>
      <!-- /Page Header --> 
      
      @php
      $editId = isset($_GET["edit"]) ? intval(trim($_GET["edit"])) : 0;
      @endphp
      @if($editId>0 && count($one)==0)
      
      Not found
      
      @else
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h6 class="card-title">Customer to Add in Invoice</h6>
            </div>
            <div class="card-body"> @if(!$errors->isEmpty())
              @foreach ($errors->all(':message') as $input_error)
              <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $input_error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              </div>
              @endforeach 
              @endif
              @if(Session::get("msg")!='')
              <div class="alert alert-{{ Session::get("cls") }} alert-dismissible fade show" role="alert">{{ Session::get("msg") }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              </div>
              @endif
              <form action="{{ route('add-update-customer') }}" method="post" enctype="multipart/form-data" id="formid">
                @csrf
                <div class="form-group row">
                  <label class="col-form-label col-md-2">First Name </label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" maxlength="150" name="firstname" id="firstname" placeholder="First Name" value="{{ @$one[0]->firstname }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Last Name</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" maxlength="150" name="lastname" id="lastname" placeholder="Last Name" value="{{ @$one[0]->lastname }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Full Name *</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" maxlength="150" name="fullname" id="fullname" placeholder="Full Name" value="{{ @$one[0]->fullname }}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Email</label>
                  <div class="col-md-4">
                    <input type="email" class="form-control" maxlength="150" name="email" id="email" placeholder="Email" value="{{ @$one[0]->email }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Mobile</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" id="mobile" value="{{ @$one[0]->mobile }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" maxlength="13" minlength="10">
                  </div>
                </div>
                <h6 class="card-title">Address (optional)</h6>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Address </label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" maxlength="250" name="address" id="address" placeholder="Address" value="{{ @$one[0]->address }}" >
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Landmark </label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" maxlength="250" name="landmark" id="landmark" placeholder="Landmark" value="{{ @$one[0]->landmark }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Country </label>
                  <div class="col-md-4">
                    <input type="text" name="country" class="form-control" id="country1"  placeholder="Country" value="{{ isset($one[0]->country) ? $one[0]->country : 'India' }}"  >
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">State</label>
                  <div class="col-md-4">
                    <input type="text" name="state" class="form-control" id="state1" placeholder="State" value="{{ @$one[0]->state }}" >
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">City</label>
                  <div class="col-md-4">
                    <input type="text" name="city" class="form-control showcls24mec" id="city1" placeholder="City" value="{{ @$one[0]->city }}" >
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Pincode </label>
                  <div class="col-md-4">
                    <input type="text" name="pincode" class="form-control showcls24mec"  id="pincode1" placeholder="Pincode" maxlength="6"  minlength="6" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" value="{{ @$one[0]->pincode }}">
                  </div>
                </div>
                <input type="hidden" id="is_active" name="is_active" value="{{ isset($one[0]->is_active) ? $one[0]->is_active : 1 }}">
                <input type="hidden" id="hid" name="hid"  value="{{ isset($one[0]->id) ? $one[0]->id : 0 }}">
                <input type="hidden" id="typehid" name="typehid" value="Customer" >
                <div class="text-right">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endif </div>
  </div>
  <!-- /Page Wrapper --> 
  
</div>
<!-- /Main Wrapper --> 
@include('admin.layout.js')