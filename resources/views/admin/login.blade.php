<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Admin - Login</title>
<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('admin_assets/assets/img/favicon.png') }}">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('admin_assets/assets/css/bootstrap.min.css') }}">
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{ asset('admin_assets/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin_assets/assets/plugins/fontawesome/css/all.min.css') }}">
<!-- Main CSS -->
<link rel="stylesheet" href="{{ asset('admin_assets/assets/css/style.css') }}">
</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper login-body">
  <div class="login-wrapper">
    <div class="container"> <img class="img-fluid logo-dark mb-2" src='{{ sendPath(constants("company_files")).getCompanyConfiguration()->invoice_logo}}' alt="Logo">
      <div class="loginbox">
        <div class="login-right">
          <div class="login-right-wrap">
            <h1>Login</h1>
            @if(Session::get("msg")!='')
            <p class="account-subtitle">{{ Session::get("msg") }}</p>
            @endif
            <form  method="post" action="{{ route('log-in') }}" enctype="multipart/form-data">
            @csrf
           <input type="hidden" id="hid" name="hid" value="0">
              <div class="form-group">
                <label class="form-control-label">Email Address</label>
                <input id="username" name="username" type="text" class="form-control" placeholder="Type Your Email address Or Mobile">
              </div>
              <div class="form-group">
                <label class="form-control-label">Password</label>
                <div class="pass-group">
                  <input type="password" id="password" name="password" class="form-control pass-input" placeholder="Your Password">
                  <span class="fas fa-eye toggle-password"></span> </div>
              </div>
              <!--
              <div class="form-group">
                <div class="row">
                  <div class="col-6">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="cb1">
                      <label class="custom-control-label" for="cb1">Remember me</label>
                    </div>
                  </div>
                  <div class="col-6 text-right"> <a class="forgot-link" href="">Forgot Password ?</a> </div>
                </div>
              </div>
              -->
              <button class="btn btn-lg btn-block btn-primary" type="submit">Login</button>
              <div class="text-center dont-have">Forgot Password ? <a href="{{ route('forgot-password') }}">Reset Password</a></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Main Wrapper --> 

<!-- jQuery --> 
<script src="{{ asset('admin_assets/assets/js/jquery-3.5.1.min.js') }}"></script> 

<!-- Bootstrap Core JS --> 
<script src="{{ asset('admin_assets/assets/js/popper.min.js') }}"></script> 
<script src="{{ asset('admin_assets/assets/js/bootstrap.min.js') }}"></script> 

<!-- Feather Icon JS --> 
<script src="{{ asset('admin_assets/assets/js/feather.min.js') }}"></script> 

<!-- Custom JS --> 
<script src="{{ asset('admin_assets/assets/js/script.js') }}"></script>
</body>
</html>