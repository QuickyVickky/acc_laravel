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
@if(Session::get("forgotemail")!='')
<!-- Main Wrapper -->
<div class="main-wrapper login-body">
  <div class="login-wrapper">
    <div class="container"> 
      <div class="loginbox">
        <div class="login-right">
          <div class="login-right-wrap">
            <h1>Set Password</h1>
            @if(Session::get("msg")!='')
            <p class="account-subtitle">{{ Session::get("msg") }}</p>
            @endif
            <form  method="post" action="{{ route('forgot-password-set') }}" enctype="multipart/form-data">
            @csrf
           <input type="hidden" id="hid" name="hid" value="0" required>
           <input type="hidden" id="email" name="email" value="{{ Session::get('forgotemail') }}" required>
           <div class="form-group">
                <label class="form-control-label">OTP</label>
                <input id="otp" name="otp" type="text" class="form-control" placeholder="Enter 6 digits OTP" autocomplete="off" maxlength="6" required>
              </div>
              
              <div class="form-group">
                <label class="form-control-label">Password *</label>
                <div class="pass-group">
                  <input type="password" id="password" name="password" class="form-control pass-input" placeholder="Your Password" required autocomplete="off" required>
                  <span class="fas fa-eye toggle-password"></span> </div>
              </div>
              <button class="btn btn-lg btn-block btn-primary" type="submit">Change Password</button>
              <div class="text-center dont-have">Back Login ? <a href="{{ route('loginpage') }}">Login</a></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Main Wrapper --> 
@endif
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