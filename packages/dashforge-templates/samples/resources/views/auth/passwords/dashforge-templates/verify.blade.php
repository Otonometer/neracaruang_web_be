<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@redtech">
    <meta name="twitter:creator" content="@redtech">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Webcore">
    <meta name="twitter:description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="twitter:image" content="https://via.placeholder.com/1260x950?text=Webcore">

    <!-- Facebook -->
    <meta property="og:url" content="https://dandisy.github.io">
    <meta property="og:title" content="Webcore">
    <meta property="og:description" content="Webcore - Web Backend Generate">

    <meta property="og:image" content="https://via.placeholder.com/1260x950?text=Webcore">
    <meta property="og:image:secure_url" content="https://via.placeholder.com/1260x950?text=Webcore">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Webcore - Web Backend Generate">
    <meta name="author" content="Redtech">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <title>Webcore - Web Backend Generate</title>

    <!-- vendor css -->
    <link href="{{ asset('vendor/dashforge/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/dashforge/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/dashforge/assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashforge/assets/css/dashforge.auth.css') }}">

    <style>
    .df-settings {
      display: none;
    }
    </style>
  </head>
  <body>

    <header class="navbar navbar-header navbar-header-fixed">
      <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
      <div class="navbar-brand">
        <a href=" {{ url('/') }} " class="df-logo">
          <!-- web<span>core</span> -->        
          <img src="{{ asset('webcore-logo.png') }}" alt="Webcore" width="120">
        </a>
      </div><!-- navbar-brand -->
      {{--<div id="navbarMenu" class="navbar-menu-wrapper">
        <div class="navbar-menu-header">
          <a href="../../index.html" class="df-logo">web<span>app</span></a>
          <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
        </div><!-- navbar-menu-header -->
        <ul class="nav navbar-menu">
          <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
          <li class="nav-item with-sub">
            <a href="" class="nav-link"><i data-feather="pie-chart"></i> Dashboard</a>
            <ul class="navbar-menu-sub">
              <li class="nav-sub-item"><a href="dashboard-one.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Sales Monitoring</a></li>
              <li class="nav-sub-item"><a href="dashboard-two.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Website Analytics</a></li>
              <li class="nav-sub-item"><a href="dashboard-three.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Cryptocurrency</a></li>
              <li class="nav-sub-item"><a href="dashboard-four.html" class="nav-sub-link"><i data-feather="bar-chart-2"></i>Helpdesk Management</a></li>
            </ul>
          </li>
          <li class="nav-item with-sub">
            <a href="" class="nav-link"><i data-feather="package"></i> Apps</a>
            <ul class="navbar-menu-sub">
              <li class="nav-sub-item"><a href="app-calendar.html" class="nav-sub-link"><i data-feather="calendar"></i>Calendar</a></li>
              <li class="nav-sub-item"><a href="app-chat.html" class="nav-sub-link"><i data-feather="message-square"></i>Chat</a></li>
              <li class="nav-sub-item"><a href="app-contacts.html" class="nav-sub-link"><i data-feather="users"></i>Contacts</a></li>
              <li class="nav-sub-item"><a href="app-file-manager.html" class="nav-sub-link"><i data-feather="file-text"></i>File Manager</a></li>
              <li class="nav-sub-item"><a href="app-mail.html" class="nav-sub-link"><i data-feather="mail"></i>Mail</a></li>
            </ul>
          </li>
          <li class="nav-item with-sub">
            <a href="" class="nav-link"><i data-feather="layers"></i> Pages</a>
            <div class="navbar-menu-sub">
              <div class="d-lg-flex">
                <ul>
                  <li class="nav-label">Authentication</li>
                  <li class="nav-sub-item"><a href="page-signin.html" class="nav-sub-link"><i data-feather="log-in"></i> Sign In</a></li>
                  <li class="nav-sub-item"><a href="page-signup.html" class="nav-sub-link"><i data-feather="user-plus"></i> Sign Up</a></li>
                  <li class="nav-sub-item"><a href="page-verify.html" class="nav-sub-link"><i data-feather="user-check"></i> Verify Account</a></li>
                  <li class="nav-sub-item"><a href="page-forgot.html" class="nav-sub-link"><i data-feather="shield-off"></i> Forgot Password</a></li>
                  <li class="nav-label mg-t-20">User Pages</li>
                  <li class="nav-sub-item"><a href="page-profile-view.html" class="nav-sub-link"><i data-feather="user"></i> View Profile</a></li>
                  <li class="nav-sub-item"><a href="page-connections.html" class="nav-sub-link"><i data-feather="users"></i> Connections</a></li>
                  <li class="nav-sub-item"><a href="page-groups.html" class="nav-sub-link"><i data-feather="users"></i> Groups</a></li>
                  <li class="nav-sub-item"><a href="page-events.html" class="nav-sub-link"><i data-feather="calendar"></i> Events</a></li>
                </ul>
                <ul>
                  <li class="nav-label">Error Pages</li>
                  <li class="nav-sub-item"><a href="page-404.html" class="nav-sub-link"><i data-feather="file"></i> 404 Page Not Found</a></li>
                  <li class="nav-sub-item"><a href="page-500.html" class="nav-sub-link"><i data-feather="file"></i> 500 Internal Server</a></li>
                  <li class="nav-sub-item"><a href="page-503.html" class="nav-sub-link"><i data-feather="file"></i> 503 Service Unavailable</a></li>
                  <li class="nav-sub-item"><a href="page-505.html" class="nav-sub-link"><i data-feather="file"></i> 505 Forbidden</a></li>
                  <li class="nav-label mg-t-20">Other Pages</li>
                  <li class="nav-sub-item"><a href="page-timeline.html" class="nav-sub-link"><i data-feather="file-text"></i> Timeline</a></li>
                  <li class="nav-sub-item"><a href="page-pricing.html" class="nav-sub-link"><i data-feather="file-text"></i> Pricing</a></li>
                  <li class="nav-sub-item"><a href="page-help-center.html" class="nav-sub-link"><i data-feather="file-text"></i> Help Center</a></li>
                  <li class="nav-sub-item"><a href="page-invoice.html" class="nav-sub-link"><i data-feather="file-text"></i> Invoice</a></li>
                </ul>
              </div>
            </div><!-- nav-sub -->
          </li>
          <li class="nav-item"><a href="../../components/" class="nav-link"><i data-feather="box"></i> Components</a></li>
          <li class="nav-item"><a href="../../collections/" class="nav-link"><i data-feather="archive"></i> Collections</a></li>
        </ul>
      </div><!-- navbar-menu-wrapper -->--}}
      {{--<div class="navbar-right">
        <a href="http://dribbble.com/themepixels" class="btn btn-social"><i class="fab fa-dribbble"></i></a>
        <a href="https://github.com/themepixels" class="btn btn-social"><i class="fab fa-github"></i></a>
        <a href="https://twitter.com/themepixels" class="btn btn-social"><i class="fab fa-twitter"></i></a>
        <a href="https://themeforest.net/item/azia-responsive-bootstrap-4-dashboard-template/22983790" class="btn btn-buy"><i data-feather="shopping-bag"></i> <span>Buy Now</span></a>
      </div><!-- navbar-right -->--}}
    </header><!-- navbar -->

    <div class="content content-fixed content-auth-alt">
      <div class="container ht-100p">
        <div class="ht-100p d-flex flex-column align-items-center justify-content-center">
          <div class="wd-150 wd-sm-250 mg-b-30"><img src="https://source.unsplash.com/250x190/?tech,software" class="img-fluid" alt=""></div>
          <h4 class="tx-20 tx-sm-24">Verify your email address</h4>
          <p class="tx-color-03 mg-b-40">Please check your email and click the verify button or link to verify your account.</p>
          <div class="tx-13 tx-lg-14 mg-b-40">
            <a href="" class="btn btn-brand-02 d-inline-flex align-items-center">Resend Verification</a>
            <a href="" class="btn btn-white d-inline-flex align-items-center mg-l-5">Contact Support</a>
          </div>
          <span class="tx-12 tx-color-03">Simple embedding for <a href="https://source.unsplash.com" target="_blank">unsplash (source.unsplash.com) photos</a></span>
        </div>
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
