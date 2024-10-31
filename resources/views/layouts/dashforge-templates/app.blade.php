<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Meta -->
    <meta name="description" content="Neraca Ruang - Content Management System">
    <meta name="author" content="Redtech">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    {{-- <link rel="manifest" href="site.webmanifest"> --}}

    <title>Neraca Ruang - Content Management System</title>
    <link href="{{ asset('vendor/dashforge/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/dashforge/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fancybox/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fileuploader/jquery.fileuploader.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashforge/lib/dropify/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashforge/lib/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashforge/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashforge/assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashforge/assets/css/dashforge.dashboard.css') }}">
    <style>
        .aside.minimize img {
            display: none;
        }

        .file-item {
            margin-top: 15px;
            /* padding: 5px; */
            border: 1px solid #d2d6de;
        }
        .file-item > div:first-child {
            margin-left: -10px;
        }

        #image-thumb {
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }

        .demo-forms{
            border: 2px solid #e5e7ef;
            padding: 15px;
        }
        .select2-container {
            width: 100% !important;
        }
        .table.dataTable thead{
            background: #eceff3;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            position: inherit;
            top: inherit;
            left: inherit;
        }
        .tr-wrap.active {
            color: green;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff !important;
            font-size: 22px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0168fa !important;
            padding: 2px;
        }
    </style>

    <style>
        .select2-container {
            width: 100% !important;
        }

        @media screen and (max-width: 767px) {
        }

        @media screen and (max-width: 576px) {
        }
        #chevron.rotate {
            transform: rotate(180deg);
            transition: transform .3s linear;
        }
        #chevron {
            color: lightgray;
            transform: rotate(0deg);
            transition: transform .3s linear;
        }
    </style>

    @yield('styles')
  </head>
  <body>
    @include('layouts.dashforge-templates.sidebar')

    <div class="content ht-100v pd-0">
      <div class="content-header">
        <div class="content-search"></div>
        <nav class="nav">
            <a class="nav-link" href="{!! url('/logout') !!}" data-toggle="tooltip" title="Sign out"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i data-feather="log-out"></i>
            </a>
        </nav>
      </div>

      @yield('contents')
    </div>

    <script src="{{ asset('vendor/dashforge/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <script src="{{ asset('vendor/dashforge/assets/js/dashforge.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/assets/js/dashforge.aside.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/js-cookie/js.cookie.js') }}"></script>

    <script src="{{ asset('vendor/fancybox/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('vendor/fileuploader/jquery.fileuploader.min.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>

    <script crossorigin="anonymous"
            src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js"
            integrity="sha512-3tlegnpoIDTv9JHc9yJO8wnkrIkq7WO7QJLi5YfaeTmZHvfrb1twMwqT4C0K8BLBbaiR6MOo77pLXO1/PztcLg==">
    </script>
    <script>
        var editor_config = {
            skin: "lightgray",
            height: 300,
            min_height: 300,
            path_absolute : "/",
            selector: "textarea.my-editor",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            remove_script_host : false,
            document_base_url : '{{url("/")}}',
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
                cmsURL = cmsURL + "&type=Files";

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>
    @yield('scripts')
    @yield('script-menu')
  </body>
</html>
