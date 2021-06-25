@include('admin.layout.meta') 
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar') 
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid"> 
      <!-- Page Header -->
      <div class="page-header">
        <div class="row">
          <div class="col">
            <h3 class="page-title">{{ $control }} </h3>
          </div>
        </div>
      </div>
      <!-- /Page Header -->
      
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h6 class="card-title">Update{{ $control }}</h6>
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
              <form action="{{ route('update-company-details') }}" method="post" enctype="multipart/form-data" id="formid">
                @csrf
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Company Name *</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" maxlength="150" name="company_name" id="company_name" placeholder="Company Name" value="{{ @$one->company_name }}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Email</label>
                  <div class="col-md-4">
                    <input type="email" class="form-control" maxlength="150" name="email" id="email" placeholder="Email" value="{{ @$one->email }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Mobile</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" id="mobile" value="{{ @$one->mobile }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" maxlength="13" minlength="10">
                  </div>
                </div>
                <h6 class="card-title">Address (optional)</h6>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Address </label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" maxlength="250" name="address" id="address" placeholder="Address" value="{{ @$one->address }}" >
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Landmark </label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" maxlength="250" name="landmark" id="landmark" placeholder="Landmark" value="{{ @$one->landmark }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Country </label>
                  <div class="col-md-4">
                    <input type="text" name="country" class="form-control" id="country1"  placeholder="Country" value="{{ isset($one->country) ? $one->country : 'India' }}"  >
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">State</label>
                  <div class="col-md-4">
                    <input type="text" name="state" class="form-control" id="state1" placeholder="State" value="{{ @$one->state }}" >
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">City</label>
                  <div class="col-md-4">
                    <input type="text" name="city" class="form-control showcls24mec" id="city1" placeholder="City" value="{{ @$one->city }}" >
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Pincode </label>
                  <div class="col-md-4">
                    <input type="text" name="pincode" class="form-control showcls24mec"  id="pincode1" placeholder="Pincode" maxlength="6"  minlength="6" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8;" value="{{ @$one->pincode }}">
                  </div>
                </div>
                
                <h6 class="card-title">Invoice Details (optional)</h6>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Invoice Logo </label>
                  <div class="col-md-6">
                    <input type="file" name="invoice_logo" class="form-control" id="invoice_logo" accept="image/jpeg,image/jpg,image/gif,image/png,">
                  </div>
                </div>
                @if($one->invoice_logo!='')
                <div class="form-group row">
                  <label class="col-form-label col-md-2"></label>
                  <div class="col-md-3 cursor-pointer">
                  <input type="hidden" id="existing_img" name="existing_img" value="{{ $one->invoice_logo }}" />
                    <img src='{{ sendPath(constants("company_files")).$one->invoice_logo}}' class="profile-img" alt="img" width="250px" height="250px" onClick="imgDisplayInModal(this.src)"> 
                  </div>
                </div>
                @endif
                
                <input type="hidden" id="hid" name="hid"  value="{{ constants('company_configurations_id') }}">
                <input type="hidden" id="typehid" name="typehid" value="Company Information" >
                <div class="text-right">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
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
@include('admin.layout.snippets.imginmodal') 
<script type="text/javascript">



</script> 
