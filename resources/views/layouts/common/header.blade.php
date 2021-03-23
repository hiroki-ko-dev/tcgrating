@section('header')

<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width,initial-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{config('origin.site.title')}}</title>
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/assets/index.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/assets/common/header.css') }}">

    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <link rel="stylesheet" href="{{ mix('/js/all.js') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,700&amp;display=swap&amp;subset=japanese" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Serif+JP:700&amp;display=swap&amp;subset=japanese" >
    <link rel="manifest" href="images/favicon/manifest.json" crossorigin="use-credentials">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
</head>

<header class="header" id="header">
    <div class="container">
        <div class="row"></div>
            <nav class="navbar-expand-lg  d-flex align-items-center pt-md-3">
                <h1><a class="navbar-brand d-flex align-items-center" href="/" title="{{config('origin.site.title')}}">
                <img class="img-responsive" src="{{ asset('/images/site/hashimu-icon.png') }}" alt="hashimu-icon">
                    <span class="header-site-title">  {{config('origin.site.title')}}</span></a>
                </h1>
{{--                <h2 class="sr-only">{{config('origin.site.title')}}</h2>--}}

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    </span><span></span><span></span></button>
                <div class="navbar-collapse" id="navbar">
                    <div class="hamburger-menu">
                        <input type="checkbox" id="menu-btn-check">
                        <label for="menu-btn-check" class="menu-btn"><span></span></label>
                        <!--ここからメニュー-->
                        <div class="menu-content">
                            <ul>
                                <li><a href="#">マイページ</a></li>
                                <li><a href="#">大会</a></li>
                                <li><a href="#">ランキング</a></li>
                                <li><a href="/login">ログイン</a></li>
                            </ul>
                        </div>
                        <!--ここまでメニュー-->
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
@endsection
