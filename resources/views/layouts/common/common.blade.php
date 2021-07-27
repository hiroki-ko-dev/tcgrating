<!DOCTYPE html>
<html class="no-js no-svg" lang="ja">
<head>
  @yield('tag_manager_header')
  @yield('analitics')
  @yield('header')
  @yield('addCss')

  @yield('addJs')
</head>
  <body>

    @yield('tag_manager_body')
    @yield('bodyHeader')
    @yield('adsense')
    <main class="py-4" id="main">
  {{-- <div class="main-wrap">--}}
      @yield('content')
  {{-- </div>--}}
    </main>

    @yield('footer')
  </body>
</html>

