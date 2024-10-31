<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    {{-- <link rel="manifest" href="site.webmanifest"> --}}


    <title>Webcore - Web Backend Generate</title>

    <!-- vendor css -->
    <link href="{{ asset('vendor/dashforge/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/dashforge/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/dashforge/assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashforge/assets/css/dashforge.auth.css') }}">
  </head>
  <body>

    <header class="navbar navbar-header navbar-header-fixed">
      <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
      <div class="navbar-brand">
        <a href=" {{ url('/') }} " class="df-logo">
          <img src="{{ asset('webcore-logo.png') }}" alt="Webcore" width="120">
        </a>
      </div>
    </header>

    <div class="content content-fixed content-auth">
      <div class="container">
        <div class="media align-items-stretch justify-content-center ht-100p">
          <div class="sign-wrapper mg-lg-r-50 mg-xl-r-60">
            <div class="pd-t-20 wd-100p">
              <h4 class="tx-color-01 mg-b-5">Create New Account</h4>
              <p class="tx-color-03 tx-16 mg-b-40">It's free to signup and only takes a minute.</p>

              <div class="form-group">
                <label>Email address</label>
                <input type="email" class="form-control" placeholder="Enter your email address">
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-between mg-b-5">
                  <label class="mg-b-0-f">Password</label>
                </div>
                <input type="password" class="form-control" placeholder="Enter your password">
              </div>
              <div class="form-group">
                <label>Firstname</label>
                <input type="text" class="form-control" placeholder="Enter your firstname">
              </div>
              <div class="form-group">
                <label>Lastname</label>
                <input type="text" class="form-control" placeholder="Enter your lastname">
              </div>
              <div class="form-group tx-12">
                By clicking <strong>Create an account</strong> below, you agree to our terms of service and privacy statement.
              </div><!-- form-group -->

              <button class="btn btn-brand-02 btn-block">Create Account</button>
              <div class="divider-text">or</div>
              <button class="btn btn-outline-facebook btn-block">Sign Up With Facebook</button>
              <button class="btn btn-outline-twitter btn-block">Sign Up With Twitter</button>
              <div class="tx-13 mg-t-20 tx-center">Already have an account? <a href="page-signin.html">Sign In</a></div>
            </div>
          </div><!-- sign-wrapper -->
          <div class="media-body pd-y-30 pd-lg-x-50 pd-xl-x-60 align-items-center d-none d-lg-flex pos-relative">
            <div class="mx-lg-wd-500 mx-xl-wd-550">
              <img src="https://via.placeholder.com/1280x1225" class="img-fluid" alt="">
            </div>
            <div class="pos-absolute b-0 r-0 tx-12">
              Social media marketing vector is created by <a href="https://www.freepik.com/pikisuperstar" target="_blank">pikisuperstar (freepik.com)</a>
            </div>
          </div><!-- media-body -->
        </div><!-- media -->
      </div><!-- container -->
    </div><!-- content -->

    <footer class="footer">
      <div>
        <span>&copy; 2019 Webcore v1.0.0. </span>
        <span>Created by <a href="javascript:void(0)">Redtech</a></span>
      </div>
      <div>
        <nav class="nav">
          <a href="javascript:void(0)" class="nav-link">Licenses</a>
          <a href="javascript:void(0)" class="nav-link">Change Log</a>
          <a href="javascript:void(0)" class="nav-link">Get Help</a>
        </nav>
      </div>
    </footer>

    <script src="{{ asset('vendor/dashforge/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <script src="{{ asset('vendor/dashforge/assets/js/dashforge.js') }}"></script>

    <!-- append theme customizer -->
    <script src="{{ asset('vendor/dashforge/lib/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/assets/js/dashforge.settings.js') }}"></script>
  </body>
</html>
