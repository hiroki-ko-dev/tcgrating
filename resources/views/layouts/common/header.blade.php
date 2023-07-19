@section('header')
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width,initial-scale=1, shrink-to-fit=no" name="viewport">

    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/scss.css') }}">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="   crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
{{--datepicerリンク--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

{{--    <script src="{{ mix('/js/common/_selected_game.js') }}"></script>--}}

{{--    ajaxでcsrfを使うための行--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,700&amp;display=swap&amp;subset=japanese" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Serif+JP:700&amp;display=swap&amp;subset=japanese" >

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

@endsection

@section('bodyHeader')
    <nav class="navbar navbar-expand-md header-color shadow-sm">
      <div class="header row align-items-center mt-4 mb-4">
        <div  class="col-5">
          <a href="{{ url('/') }}" title="{{config('assets.site.title')}}">
            <span class="text-white">TcgRating</span>
{{--            <img class="img-fluid" src="{{ asset('/images/site/logo.png') }}" alt="hashimu-icon">--}}
{{--                <div class="font-weight-bold text-white header-site-title">TCGレーティング</div>--}}
          </a>
        </div>
        <div  class="col-7">
          <form id="selected_game_form" method="post" action="/site/update_selected_game">
            @csrf
{{--                <div class="selected_game mr-2">--}}
{{--                  <select id="selected_game_id" name="selected_game_id" class="form-control">--}}
{{--                    @foreach(config('assets.site.games') as $key => $game)--}}
{{--                      <option value="{{$key}}"--}}
{{--                        @if(Auth::check())--}}
{{--                          @if(Auth::user()->selected_game_id == $key)--}}
{{--                            selected--}}
{{--                          @endif--}}
{{--                        @elseif(session('selected_game_id') == $key)--}}
{{--                          selected--}}
{{--                        @endif--}}
{{--                      >{{$game}}</option>--}}
{{--                    @endforeach--}}
{{--                  </select>--}}
{{--                </div>--}}
            <input type="hidden" name="selected_game_id" value="{{config('assets.site.game_ids.pokemon_card')}}">
          </form>
        </div>
      {{--                <h2 class="sr-only">{{config('assets.site.title')}}</h2>--}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="navbar-collapse" id="navbar">
          <div class="hamburger-menu">
            <input type="checkbox" id="menu-btn-check">
            <label for="menu-btn-check" class="menu-btn"><span></span></label>
            <!--ここからメニュー-->
            <div class="menu-content">
              <ul>
                <li><a href="/rank">ランキング</a></li>
                <li><a href="/post?post_category_id={{\App\Models\PostCategory::CATEGORY_FREE}}">掲示板</a></li>
                {{-- <li><a href="/product">商品</a></li> --}}
                {{--                  <li><a href="/post?post_category_id={{\App\Models\PostCategory::TEAM_WANTED}}">チームメンバー募集掲示板</a></li>--}}
                {{--                  <li><a href="/team">チーム検索</a></li>--}}
                {{--                    <li><a href="/team?user_id={{Auth::id()}}">マイチーム</a></li>--}}
                @guest
                  @if(session('selected_game_id') == 3)
                    <li><a href="/site/how_to_use/instant">使い方</a></li>
                    <li><a href="/event/instant">1vs1対戦</a></li>
                      <li><a href="/blog">記事</a></li>
                    <li><a href="/proxy">プロキシ作成</a></li>
{{--                    <li><a href="/item">商品購入</a></li>--}}
                  @else
                    <li><a href="/site/how_to_use/normal">使い方</a></li>
                    <li><a href="/event/single">1vs1対戦</a></li>
                  @endif
                    <li><a href="{{ route('login') }}">ログイン</a></li>
                @else
                  @if(Auth::user()->selected_game_id == 3)
                    <li><a href="/site/how_to_use/instant">使い方</a></li>
                    <li><a href="/event/instant">1vs1対戦</a></li>
                      <li><a href="/blog">記事</a></li>
                    <li><a href="/proxy">プロキシ作成</a></li>
{{--                    <li><a href="/item">商品購入</a></li>--}}
                    @if(Auth::user()->role == 1)
                      <li><a href="/event/group">グループ対戦</a></li>
                      <li><a href="/event/swiss">大会</a></li>
                      <li><a href="/user/{{Auth::id()}}">マイページ</a></li>
                      <li><a href="/item">商品購入</a></li>
                    @endif
                    <li><a href="/resume/{{Auth::id()}}">ポケカ履歴書</a></li>
                  @else
                    <li><a href="/site/how_to_use/normal">使い方</a></li>
                    <li><a href="/event/single">1vs1対戦</a></li>
                  @endif

                  <li><a  href="" onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">ログアウト</a></li>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                @endif
                @if(Auth::check() && Auth::user()->role == 1)
                  <li><a href="/admin">管理者用</a></li>
                  <li><a href="/opinion">意見</a></li>
                @endif
              </ul>
            </div>
            <!--ここまでメニュー-->
          </div>
        </div>
      </div>
  </nav>
@endsection


