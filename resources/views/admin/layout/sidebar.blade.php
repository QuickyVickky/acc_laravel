<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
      <ul>
        <li class="menu-title"><span>Main</span></li>
        <li class="{{ (request()->is(env("ADMINBASE_NAME").'/dashboard')) ? 'active' : '' }}"> <a href="{{ route('dashboard') }}" ><i data-feather="home"></i> <span>Dashboard</span></a> </li>
        <li class="submenu {{ ( 'product-services-sales-list'==Route::currentRouteName() || 'product-services-sales'==Route::currentRouteName()  || 'customer-list'==Route::currentRouteName() || 'invoices'==Route::currentRouteName() ) ? 'active' : '' }}"> <a href="#"><i data-feather="grid"></i> <span> Sales</span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="{{ route('invoice-list') }}" class="submenu {{ ( 'invoice-list'==Route::currentRouteName() || 'invoices'==Route::currentRouteName() ) ? 'active' : '' }}">Invoice</a></li>
            <li><a href="{{ route('product-services-sales-list') }}"  class="submenu {{ ( 'product-services-sales-list'==Route::currentRouteName() ) ? 'active' : '' }}">Products & Services</a></li>
            <li><a href="{{ route('customer-list') }}"  class="{{ ( 'customer-list'==Route::currentRouteName() ) ? 'active' : '' }}">Customers</a></li>
          </ul>
        </li>
        <li class="submenu {{ ( 'product-services-expense'==Route::currentRouteName() || 'product-services-expense'==Route::currentRouteName() || 'vendor-list'==Route::currentRouteName() || 'vendors-client'==Route::currentRouteName() ) ? 'active' : '' }}"> <a href="#"><i data-feather="package"></i> <span> Purchases</span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="{{ route('bills-list') }}" class="submenu {{ ( 'bills-list'==Route::currentRouteName() || 'bills'==Route::currentRouteName() ) ? 'active' : '' }}">Bills</a></li>
            <li><a href="{{ route('product-services-expense-list') }}"  class="submenu {{ ( 'product-services-expense-list'==Route::currentRouteName() ) ? 'active' : '' }}" >Products & Services</a></li>
            <li><a href="{{ route('vendor-list') }}"  class="{{ ( 'vendor-list'==Route::currentRouteName() || 'vendors-client'==Route::currentRouteName() ) ? 'active' : '' }}">Vendors</a></li>
          </ul>
        </li>
        <li class="submenu"> <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-columns">
          <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"></path>
          </svg> <span> Accounting</span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="{{ route('transactions-list') }}"  class="{{ ( 'transactions-list'==Route::currentRouteName()  ) ? 'active' : '' }}">Transactions</a></li>
            <li><a href="{{ route('all-accounts-list') }}"  class="{{ ( 'all-accounts-list'==Route::currentRouteName()  ) ? 'active' : '' }}">Accounts</a></li>
          </ul>
        </li>
        <li  class="{{ ( 'category-list'==Route::currentRouteName() ) ? 'active' : '' }}"> <a href="{{ route('category-list') }}"  ><i data-feather="users"></i> <span>Category</span></a> </li>
        <li  class="{{ ( 'company-configuration'==Route::currentRouteName() ) ? 'active' : '' }}"> <a href="{{ route('company-configuration') }}"  ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg> <span>Company</span></a> </li>
        
        
        <li  class="{{ ( 'admin-list'==Route::currentRouteName() ) ? 'active' : '' }}"> <a href="{{ route('admin-list') }}"  ><i data-feather="users"></i> <span>Admin</span></a> </li>
        
        
        
      </ul>
    </div>
  </div>
</div>
<!-- /Sidebar --> 