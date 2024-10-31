<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <!-- include Summernote -->
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote.css') }}">

    <!-- include Fancybox -->
    <link rel="stylesheet" href="{{ asset('vendor/fancybox/jquery.fancybox.min.css') }}">

    <!-- include Fileuploader -->
    <link rel="stylesheet" href="{{ asset('vendor/fileuploader/jquery.fileuploader.css') }}">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/dashforge/assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashforge/assets/css/dashforge.dashboard.css') }}"> 
    
    <style>
        .aside.minimize img {
            display: none;
        }
    </style>

    @yield('styles')
    @yield('style')
    @yield('css')
  </head>
  <body>
    @include('layouts.dashforge-templates.sidebar')

    <div class="content ht-100v pd-0">
      <div class="content-header">
        <div class="content-search">
          <i data-feather="search"></i>
          <input type="search" class="form-control" placeholder="Search...">
        </div>
        <nav class="nav">
          <a href="" class="nav-link"><i data-feather="help-circle"></i></a>
          <a href="" class="nav-link"><i data-feather="grid"></i></a>
          <a href="" class="nav-link"><i data-feather="align-left"></i></a>
        </nav>
      </div><!-- content-header -->

      @yield('contents')
    </div>

    <script src="{{ asset('vendor/dashforge/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/jquery.flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/lib/jquery.flot/jquery.flot.resize.js') }}"></script>

    <script src="{{ asset('vendor/dashforge/assets/js/dashforge.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/assets/js/dashforge.aside.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/assets/js/dashforge.sampledata.js') }}"></script>

    <!-- Summernote -->
    <script src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>

    <!-- Fancybox -->
    <script src="{{ asset('vendor/fancybox/jquery.fancybox.min.js') }}"></script>

    <!-- Fileuploader -->
    <script src="{{ asset('vendor/fileuploader/jquery.fileuploader.min.js') }}"></script>

    <!-- append theme customizer -->
    <script src="{{ asset('vendor/dashforge/lib/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('vendor/dashforge/assets/js/dashforge.settings.js') }}"></script>
    
    <script>
      // filemanager auto run when close fancybox, after select file and then insert image thumbnail
      var OnMessage = function(data){
          if(data.appendId == 'album') {
              $('#' + data.appendId + '-thumb').append('' +
              '<div class="file-item">' +
              '<div class="col-md-3 col-sm-3 col-xs-3"><img src="' + data.thumb + '" style="width:100%"></div>' +
              '<div class="col-md-8" col-sm-8 col-xs-8" style="overflow-x:auto">' + data.thumb + '</div>' +
              '<div class="col-md-1" col-sm-1 col-xs-1"><span class="fa fa-trash" style="cursor:pointer;color:red"></span></div>' +
              '<div class="clearfix"></div>' +
              '<input type="hidden" name="files[]" value="' + data.thumb + '" />' +
              '</div>');
          } else {
              $('#' + data.appendId + '-thumb').html('<img src="' + data.thumb + '" style="width:100%">');
          }
          $('input[name="' + data.appendId + '"]').val(data.thumb);
          $.fancybox.close();
      };

      $(document).ready(function() {
          // start summernote
          var snfmContext;

          var fileManager = function(context) {
              snfmContext = context;

              var ui = $.summernote.ui;

              // create button
              var button = ui.button({
                  contents: '<i class="fa fa-photo"/>',
                  tooltip: 'File Manager',
                  click: function() {
                      $('.sn-filemanager').trigger('click');
                  }
              });

              return button.render();
          }

          $('.rte').summernote({
              height: 250,
              minHeight: 100,
              maxHeight: 300,
              toolbar: [
                  ['style', ['bold', 'italic', 'underline', 'clear']],
                  ['fontsize', ['fontsize']],
                  ['color', ['color']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['table', ['table']],
                  ['insert', ['link', 'hr']],
                  ['image', ['fm']],
                  ['video', ['video']],
                  ['misc', ['fullscreen', 'codeview']]
              ],
              buttons: {
                  fm: fileManager
              }
          });

          $('.sn-filemanager').fancybox({
              type : 'iframe',
              afterClose: function() {
                  var snfmImage = $('#snfmImage-thumb').find('img').attr('src');
                  snfmContext.invoke('editor.insertImage', snfmImage, snfmImage.substr(snfmImage.lastIndexOf('/') + 1));
              }
          });
          // end summernote

          $('.filemanager').fancybox({
              type : 'iframe'
          });

          $('#filer_input').fileuploader({
              enableApi: true,
              maxSize: 10,
              extensions: ["jpg", "png", "jpeg"],
              captions: {
                  feedback: 'Upload foto',
                  button: '+ Foto Album'
              },
              showThumbs: true,
              addMore: true,
              allowDuplicates: false,
              onRemove: function (data, el) {
                  albumDeleted.push(data.data.album);
              }
          });

          $(document).on('click', '.file-item .fa-trash', function() {
              $(this).parents('.file-item').remove();
              $('#album-thumb').append('<input type="hidden" name="deleteFiles[]" value="' + $(this).data('identity') + '" />');
          });

          $('.album-manager').on('click', 'button', function(e) {
              e.preventDefault();

              $('#album-thumb').append('' +
              '<div class="file-item">' +
              '<div class="col-md-3 col-sm-3 col-xs-3"><img src="http://img.youtube.com/vi/' + $('#album').val() + '/mqdefault.jpg" style="width:100%"></div>' +
              '<div class="col-md-8" col-sm-8 col-xs-8" style="overflow-x:auto">' + $('#album').val() + '</div>' +
              '<div class="col-md-1" col-sm-1 col-xs-1"><span class="fa fa-trash" style="cursor:pointer;color:red"></span></div>' +
              '<div class="clearfix"></div>' +
              '<input type="hidden" name="files[]" value="' + $('#album').val() + '" />' +
              '</div>');

              $('#album').val('');
          });

          $('#myModalPermissions').on('show.bs.modal', function (e) {
              var content = '';

              $.ajax({
                  type: 'get',
                  url: '{{ url("api/permissions") }}'
              }).done(function (res) {
                  $.each(res.data, function (index, value) {
                      content += '<div class="checkbox col-sm-6"><label><input type="checkbox" name="permission" value="' + value.id + '">' + ' ' + value.display_name + '</label></div>';
                  });

                  $('#permission-container').html(content);
              });
          });

          $('#myModalRole').on('show.bs.modal', function (e) {
              var content = '';

              $.ajax({
                  type: 'get',
                  url: '{{ url("api/roles") }}'
              }).done(function (res) {
                  $.each(res.data, function (index, value) {
                      content += '<div class="checkbox col-sm-6"><label><input type="radio" name="role" value="' + value.id + '">' + ' ' + value.display_name + '</label></div>';
                  });

                  $('#role-container').html(content);
              });
          });
      });
    </script>

    @yield('scripts')
    @yield('script')
    @yield('js')
  </body>
</html>
