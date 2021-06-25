@include('admin.layout.meta') 
<!-- Main Wrapper -->
<div class="main-wrapper"> @include('admin.layout.header')
  @include('admin.layout.sidebar') 
  
  <!-- Page Wrapper -->
  <div class="page-wrapper">
    <div class="content container-fluid"> @php
      if(count($one)>0){
      $control = 'Edit This Product or Service (Purchases)';
      }
      else
      {
      $control = 'Add a Product or Service (Purchases)';
      }
      @endphp 
      
      <!-- Page Header -->
      <div class="page-header">
        <div class="row">
          <div class="col">
            <h3 class="page-title">{{ $control }}</h3>
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
              <h6 class="card-title">Products and services that you buy from vendors are used as items on Bills to record those purchases, and the ones that you sell to customers are used as items on Invoices to record those sales.</h6>
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
              <form action="{{ route('add-update-product-services') }}" method="post" enctype="multipart/form-data" id="formid">
                @csrf
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Name *</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" maxlength="150" name="name" id="name" placeholder="Name" value="{{ @$one[0]->name }}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Description (optional)</label>
                  <div class="col-md-10">
                    <textarea rows="3" cols="5" name="description" id="description" class="form-control" placeholder="Enter description">{{ @$one[0]->description }}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Price &#x20B9; *</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" maxlength="20" placeholder="like 456.00 &#x20B9;" name="price" id="price" value="{{ isset($one[0]->price) ? $one[0]->price : '0.00' }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8 || event.keyCode === 46;" required>
                  </div>
                </div>
                <input type="hidden" id="is_active" name="is_active" value="{{ isset($one[0]->is_active) ? $one[0]->is_active : 1 }}">
                <input type="hidden" id="hid" name="hid"  value="{{ isset($one[0]->id) ? $one[0]->id : 0 }}">
                <input type="hidden" id="typehid" name="typehid" value="Expense">
                <input type="hidden" id="main_category_hid" name="main_category_hid" value="{{ constants('Expense_Main_Category_Id') }}">
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Buy Expense Account *</label>
                  <div class="col-md-10">
                    <select class="form-control" name="sub_category" id="sub_category" required>
                      <option value="">-- Please Select --</option>

                    @foreach($Expense_Subcategory as $row)

                      <option value="{{ $row->id }}" {{ (isset($one[0]->sub_category_id) && $row->id==$one[0]->sub_category_id) ? 'selected' : '' }} >{{ $row->name }}</option>

                    @endforeach

                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-md-2">Tax (optional)</label>
                  <div class="col-md-10">
                    <select class="form-control" name="tax_id" id="tax_id">
                    @foreach($Tax as $row)
                      <option value="{{ $row->id }}" {{ (isset($one[0]->sub_category_id) && $row->id==$one[0]->tax_id) ? 'selected' : '' }}>{{ $row->abbreviation }} {{ ($row->current_tax_rate>0) ? $row->current_tax_rate.' %' : ''}}</option>
                    @endforeach
                    
                    </select>
                  </div>
                </div>
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