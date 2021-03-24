<!DOCTYPE html>
<html class="no-js no-svg" lang="ja">
    @yield('header')
    <body>
        @yield('bodyHeader')
        @yield('adsense')
        <main class="py-4" id="main">
    {{--        <div class="main-wrap">--}}
                @yield('content')
    {{--        </div>--}}
        </main>
        @yield('footer')
    </body>
</html>
