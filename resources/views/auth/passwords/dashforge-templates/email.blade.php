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

    <div class="content content-fixed content-auth-alt">
      <div class="container d-flex justify-content-center ht-100p">
        <div class="mx-wd-300 wd-sm-450 ht-100p d-flex flex-column align-items-center justify-content-center">
          <h4 class="tx-20 tx-sm-24">Reset your password</h4>
          <p class="tx-color-03 mg-b-30 tx-center">Enter your username or email address and we will send you a link to reset your password.</p>
          <div class="wd-100p d-flex flex-column flex-sm-row mg-b-40">
            <input type="text" class="form-control wd-sm-250 flex-fill" placeholder="Enter username or email address">
            <button class="btn btn-brand-02 mg-sm-l-10 mg-t-10 mg-sm-t-0">Reset Password</button>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer">
      <div>
        <span>&copy; {{ date('Y') }} Webcore v1.1.0. </span>
        <span>Created by <a href="javascript:void(0)">Redtech</a></span>
      </div>
      <div>
        <nav class="nav">
          {{-- <a href="javascript:void(0)" class="nav-link">Licenses</a>
          <a href="javascript:void(0)" class="nav-link">Change Log</a>
          <a href="javascript:void(0)" class="nav-link">Get Help</a> --}}
        </nav>
      </div>
    </footer>

    <script src="{{ asset('vendor/dashforge/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <script src="{{ asset('vendor/dashforge/assets/js/dashforge.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/js-cookie/js.cookie.js') }}"></script>
  </body>
</html>
