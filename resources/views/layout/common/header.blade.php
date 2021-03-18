@section('header')

  <head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width,initial-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{config('origin.site.title')}}</title>
    <link href="{{ asset('files/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/assets/index.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,700&amp;display=swap&amp;subset=japanese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif+JP:700&amp;display=swap&amp;subset=japanese" rel="stylesheet">
<link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192" href="images/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
<link rel="manifest" href="images/favicon/manifest.json" crossorigin="use-credentials">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<link rel="stylesheet" href="{{ asset('/css/assets/index.css') }}">
</head>
  <body class="page page-lp1"><a class="skip-link screen-reader-text sr-only" href="#main">Skip to content</a>
    <header class="header" id="header">
      <div class="container">
        <nav class="navbar navbar-expand-lg">
          <h1><a class="navbar-brand" href="index.html" title="{{config('origin.site.title')}}"><img src="images/logo.png" srcset="images/logo@2x.png 2x, images/logo@3x.png 3x" alt="{{config('origin.site.title')}}"></a><span class="sr-only">{{config('origin.site.title')}}</span></h1>
          <h2 class="sr-only">{{config('origin.site.title')}}</h2>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"><span></span><span></span><span></span></span></button>
          <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav">
              <li class="menu-item"><a class="bgs-33befc" href="" title="ログイン">ログイン</a></li>
              <li class="menu-item"><a class="bgs-f99f00" href="" title="会員登録する（無料）">会員登録する（無料）</a></li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
@endsection
