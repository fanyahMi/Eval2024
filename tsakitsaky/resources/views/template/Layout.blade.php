
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
        <meta name="description" content="{{ $descriptionMeta }}">
        <meta name="keywords" content="{{ $keywordMeta }}">
        <link href="{{ asset('assets/fontawesome/css/all.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet" />
        <title>{{ $title }}</title>
        
        <script defer="defer" src="{{ asset('main.js') }} "></script>
    </head>
  <body class="app">

    <div id="loader">
      <div class="spinner"></div>
    </div>

    <script>
      window.addEventListener('load', function load() {
        const loader = document.getElementById('loader');
        setTimeout(function() {
            loader.classList.add('fadeOut');
        }, 300);
      });
    </script>


    <div>
      <!-- #Left Sidebar ==================== -->
      <div class="sidebar">
        <div class="sidebar-inner">
          <!-- ### $Sidebar Header ### -->
          @include("template.sidebar.Logo")
          <!-- ### $Sidebar Menu ### -->
          @include("template.sidebar.Menu")
        </div>
      </div>

      <!-- #Main ============================ -->
      <div class="page-container">
        <!-- ### $Topbar ### -->
        @include("template.header.Header")
        <!-- ### $App Screen Content ### -->
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
                @include($page)
            </div>
          </div>
        </main>

        <!-- ### $App Screen Footer ### -->
       @include("template.footer.Footer")
      </div>
    </div>
  </body>
</html>
