@section('header')

<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width,initial-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{config('origin.site.title')}}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/assets/index.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/assets/common/header.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,700&amp;display=swap&amp;subset=japanese" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Serif+JP:700&amp;display=swap&amp;subset=japanese" >
    <link rel="manifest" href="images/favicon/manifest.json" crossorigin="use-credentials">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
</head>

<header class="header pt-2" id="header">
    <div class="container">
        <nav class="navbar-expand-lg">
                <h1><a class="navbar-brand" href="/" title="{{config('origin.site.title')}}">
                <img src="{{ asset('/images/site/hashimu-icon.png') }}" alt="hashimu-icon">{{config('origin.site.title')}}</a>
                <span class="sr-only">{{config('origin.site.title')}}</span></h1>
                <h2 class="sr-only">{{config('origin.site.title')}}</h2>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><span></span><span></span><span></span></span></button>
            <div class="collapse navbar-collapse" id="navbar">
                <div class="hamburger-menu">
                    <input type="checkbox" id="menu-btn-check">
                    <label for="menu-btn-check" class="menu-btn"><span></span></label>
                    <!--ここからメニュー-->
                    <div class="menu-content">
                        <ul>
                            <li><a href="#">マイページ</a></li>
                            <li><a href="#">大会</a></li>
                            <li><a href="#">ランキング</a></li>
                            <li><a href="#">ログイン</a></li>
                        </ul>
                    </div>
                    <!--ここまでメニュー-->
                </div>
            </div>
        </nav>
    </div>
</header>
@endsection
