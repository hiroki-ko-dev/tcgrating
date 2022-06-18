<!DOCTYPE html >
<html class="no-js no-svg" lang="ja">
  <head>
    @if(config('assets.common.appEnv') == 'production')
      @yield('tag_manager_header')
      @yield('analitics')
    @endif

      {{--メタタグ--}}
    <title>{{config('assets.site.title')}} | @yield('title')</title>
    @yield('description')

    @yield('header')
    @yield('twitterHeader')
    @yield('addCss')

    @yield('addJs')
  </head>
  <body class="bg-light">
      @if(config('assets.common.appEnv') == 'production')
        @yield('tag_manager_body')
      @endif
      @yield('bodyHeader')
      @if(config('assets.common.appEnv') == 'production')
        @yield('adsense')
      @endif
    <main class="py-4" id="main">
      @yield('content')
      @yield('addScript')
    </main>

    @yield('footer')
  </body>
</html>

