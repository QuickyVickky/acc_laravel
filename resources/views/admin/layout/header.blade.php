<!-- Header -->

<div class="header"> 
  
  <!-- Logo -->
  <div class="header-left"> <a href="javascript:void(0)" class="logo"> <img src='{{ sendPath(constants("company_files")).getCompanyConfiguration()->invoice_logo}}'  alt="Logo"> </a> <a href="javascript:void(0)" class="logo logo-small"> <img src='{{ sendPath(constants("company_files")).getCompanyConfiguration()->invoice_logo}}' alt="Logo" width="30" height="30"> </a> </div>
  <!-- /Logo --> 

  <!-- Sidebar Toggle> 
  <a href="javascript:void(0);" id="toggle_btn"> <i class="fas fa-bars"></i> </a> 
  <!-- /Sidebar Toggle --> 
  
  <!-- Search --> 
  
  <!-- /Search --> 
  
  <!-- Mobile Menu Toggle --> 
  <a class="mobile_btn" id="mobile_btn"> <i class="fas fa-bars"></i> </a> 
  <!-- /Mobile Menu Toggle --> 
  
  <!-- Header Menu -->
  <ul class="nav user-menu">
    
    <!-- Flag --> 
    
    <!-- /Flag --> 
    
    <!-- Notifications --> 
    
    <!-- /Notifications --> 
    
    <!-- User Menu -->
    <li class="nav-item dropdown has-arrow main-drop"> <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <span class="user-img"> 
    <!--img src="{{ asset('admin_assets/assets/img/logo.png') }}" alt=""--> <span class="status online"></span> </span> <span>{{ Session::get('fullname') }}</span> </a>
      <div class="dropdown-menu"> <a class="dropdown-item" href="{{ route('log-out') }}"><i data-feather="log-out" class="mr-1"></i> Logout</a> </div>
    </li>
    <!-- /User Menu -->
    
  </ul>
  <!-- /Header Menu --> 
  
</div>
<!-- /Header --> 