@section('header')

<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width,initial-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{config('assets.site.title')}}</title>

    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/scss.css') }}">
    <script src="{{ mix('/js/all.js') }}"></script>

    <!-- デフォルト分 -->
    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
{{--    <!-- Scripts -->--}}
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

    {{--datepicerリンク--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,700&amp;display=swap&amp;subset=japanese" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Serif+JP:700&amp;display=swap&amp;subset=japanese" >
    <link rel="manifest" href="images/favicon/manifest.json" crossorigin="use-credentials">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
</head>
@endsection

@section('bodyHeader')
    <nav class="navbar navbar-expand-md bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}" title="{{config('assets.site.title')}}">
                <img class="img-fluid col-3" src="{{ asset('/images/site/hashimu-icon.png') }}" alt="hashimu-icon">
                <span>
                <h4 class="font-weight-bold" style="display:inline;">{{config('assets.site.title')}}</h4>
                </span>
            </a>
        {{--                <h2 class="sr-only">{{config('assets.site.title')}}</h2>--}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                </button>
            <div class="navbar-collapse" id="navbar">
                <div class="hamburger-menu">
                    <input type="checkbox" id="menu-btn-check">
                    <label for="menu-btn-check" class="menu-btn"><span></span></label>
                    <!--ここからメニュー-->
                    <div class="menu-content">
                        <ul>
                            <li><a href="/site/how_to_use">使い方</a></li>
                            <li><a href="/event/single">1vs1決闘</a></li>
                            <li><a href="#"><span class="text-secondary">ポイントバトル決闘</span></a></li>
                            <li><a href="#"><span class="text-secondary">チーム決闘</span></a></li>
                            <li><a href="#"><span class="text-secondary">大会</span></a></li>
                            <li><a href="/rank">ランキング</a></li>
                            <li><a href="/post?post_category_id={{\App\Models\PostCategory::TEAM_WANTED}}">チームメンバー募集掲示板</a></li>
                            <li><a href="/post?post_category_id={{\App\Models\PostCategory::FREE}}">フリー掲示板</a></li>
                            @guest
                                <li><a href="{{ route('login') }}">ログイン</a></li>
                            @else
                                <li><a href="/team?user_id={{Auth::id()}}">マイチーム</a></li>
                                <li><a href="/user/{{Auth::id()}}">マイページ</a></li>
                                <li><a  href="" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">ログアウト</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endif
                        </ul>
                    </div>
                    <!--ここまでメニュー-->
                </div>
            </div>
        </div>
    </nav>
@endsection


