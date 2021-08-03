@section('header')
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width,initial-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{config('assets.site.title')}}</title>

    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/scss.css') }}">
    <script src="{{ mix('/js/all.js') }}"></script>
    <script src="{{ mix('/js/common/selected_game.js') }}"></script>

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

@endsection

@section('bodyHeader')
    <nav class="navbar navbar-expand-md bg-links-blue shadow-sm">
        <div class="container">
          <div class="d-sm-flex flex-row mb-3">
            <div>
              <a class="pr-3" href="{{ url('/') }}" title="{{config('assets.site.title')}}">
                  @if(session('selected_game_id') == 1)
                    <div class="font-weight-bold text-white header-site-title" style="display:inline;">遊戯王DUEL LINKSレーティング</div>
                  @elseif(session('selected_game_id') == 2)
                    <div class="font-weight-bold text-white header-site-title" style="display:inline;">遊戯王OCG リモート対戦マッチング</div>
                  @else
                    <div class="font-weight-bold text-white header-site-title" style="display:inline;">ポケモンカード リモート対戦マッチング</div>
                  @endif
              </a>
            </div>
            <div>
              <form id="selected_game_form" method="post" action="/site/update_selected_game">
                @csrf
                <div class="selected_game mr-2">
                  <span class=" text-white">Game Mode：</span>>
                  <select id="selected_game_id" name="selected_game_id" class="form-control">
                    @foreach(config('assets.site.games') as $key => $game)
                      <option value="{{$key}}"
                        @if(Auth::check())
                          @if(Auth::user()->selected_game_id == $key)
                            selected
                          @endif
                        @elseif(session('selected_game_id') == $key)
                          selected
                        @endif
                      >{{$game}}</option>
                    @endforeach
                  </select>
                </div>
              </form>
            </div>
          </div>
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
                            <li><a href="/rank">ランキング</a></li>
                            <li><a href="/post?post_category_id={{\App\Models\PostCategory::FREE}}">フリー掲示板</a></li>
                            <li><a href="/post?post_category_id={{\App\Models\PostCategory::TEAM_WANTED}}">チームメンバー募集掲示板</a></li>
                            <li><a href="/team">チーム検索</a></li>
                            <li><a href="/event/single">1vs1対戦</a></li>
{{--                            <li><a href="#"><span class="text-secondary">ポイントバトル決闘</span></a></li>--}}
{{--                            <li><a href="#"><span class="text-secondary">チーム決闘</span></a></li>--}}
{{--                            <li><a href="#"><span class="text-secondary">大会</span></a></li>--}}
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


