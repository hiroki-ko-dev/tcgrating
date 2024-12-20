@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください。またランキング機能もあるので、全国一位を目指しましょう！"/>
@endsection

@section('twitterHeader')
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@remotoPokeka" />
  <meta name="twitter:title" content="リモートポケカ対戦マッチング" />
  <meta name="twitter:description" content="リモートポケカのマッチングサイトです。対戦相手がすぐ見つかります。またランキング機能もあるので、全国一位を目指しましょう！" />
  <meta name="twitter:image" content="{{env('APP_URL')}}/images/duel/twitter_thumb.png" />
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/duel/show.css') }}">
@endsection


@section('content')
<div class="container">

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-12">
        <div class="text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
        </div>
      </div>
    @endif
  </div>

  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('1vs1対戦(対戦ページ)') }}
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="box">
        @if(!Auth::check())
          <div class="font-weight-bold text-left">{{ __('対戦申込にはTwitterログインをしてください') }}</div>
          <div class="col-sm-4">
            <a href="/auth/twitter/login"><img class="img-fluid" src="{{ asset('/images/site/twitter/relation.png') }}" alt="hashimu-icon"></a>
          </div>
        @else
          @if($duel->eventDuel->event->status == \App\Enums\EventStatus::RECRUIT->value)
            {{--対戦相手募集中の場合--}}
            @if(Auth::id() == $duel->user_id)
              {{--対戦作成者の場合--}}
              <div class="box-header text-left"><span class="text-danger">対戦相手に以下のURLを共有してください。</span></div>
              <div class="row mb-4">
                <div class="col-sm-8">
                  <div class="font-weight-bold text-left mr-3">{{env('APP_URL')}}/duel/instant/{{$duel->id}}</div>
                </div>
                <div class="col-sm-4">
                  <button id="copy" class="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                          name="copy" value="{{env('APP_URL')}}/duel/instant/{{$duel->id}}" onclick="copyUrl()">URLをコピー</button>
                </div>
              </div>
              <div class="text-left mr-3">（LINEオープンチャット等に貼り付けしてください)</div>
            @else
              {{--非対戦作成者の場合--}}
              <form method="POST" action="/event/instant/user">
                @csrf
                <input type="hidden" name="event_id" value="{{$duel->eventDuel->event->id}}">
                <input type="hidden" name="duel_id" value="{{$duel->id}}">

                <div class="box-header text-left">{{ __('対戦申込') }}</div>

                {{--discord_name入力箇所--}}
                <div class="row mb-2">
                  <div class="w-30">{{ __('Discordでの名前') }}</div>
                  <div class="w-70">
                  @if(Auth::user()->gameUsers->where('game_id', Auth::user()->selected_game_id)->first())
                    <input type="text" placeholder="#と数字まで入れる" class="form-control w-100 @error('discord_name') is-invalid @enderror" name="discord_name" value="{{ old('discord_name', Auth::user()->gameUsers->where('game_id', Auth::user()->selected_game_id)->first()->discord_name) }}" required>
                  @else
                    <input type="text" placeholder="#と数字まで入れる" class="form-control w-100 @error('discord_name') is-invalid @enderror" name="discord_name" value="{{ old('discord_name') }}" required>
                  @endif
                  @error('discord_name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                  </div>
                </div>

                <button type="submit" name="event_add_user" value="1" class="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                        onClick="return requestConfirm();">
                  {{ __('対戦申込') }}
                </button>
                <div class="font-weight-bold text-danger">{{ __('「対戦申込」を押してください') }}</div>
              </form>
            @endif
          @elseif($duel->eventDuel->event->status == \App\Enums\EventStatus::READY->value)
            {{--対戦相手募集が完了している場合--}}
            @if($duel->duelUsers->where('user_id',Auth::id())->isNotEmpty() || (Auth::check() && Auth::id() ==1))
              {{--対戦者同士の場合--}}
              <div class="row justify-content-center mb-4">
                <div class="col-md-12">
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-md-12 font-weight-bold">
                        {{ __('discord指定チャンネルで対戦開始') }}
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <form method="POST" action="/duel/instant" onClick="return requestConfirm();">
                          @csrf
                          <input type="hidden" name="duel_id" value="{{$duel->id}}">
                          <div class="d-flex flex-row justify-content-center">
                            <input type="submit" class="btn result-button btn-primary m-1" name="win" value="　勝利　">
                            <input type="submit" class="btn result-button btn-secondary m-1" name="draw" value="　ドロー">
                          </div>
                          <div class="col-md-12 mt-3">
                            <span class="font-weight-bold text-danger">{{ __('勝者') }}</span>
                            <span>{{ __('が「勝利」ボタンを押してください') }}</span>
                          </div>
                          <div class="col-md-12 mb-3">
                            {{ __('※ドロー時は対戦作成側が押す') }}
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @else
              <div class="row justify-content-center mb-4">
                <div class="col-md-12">
                  {{ __('すでに対戦マッチング済です') }}
                </div>
              </div>
            @endif
          @elseif($duel->eventDuel->event->status == \App\Enums\EventStatus::CANCEL->value)
            <div class="row justify-content-center mb-4">
              <div class="col-md-12">
                {{ __('対戦がキャンセルされました') }}
              </div>
            </div>
          @else
            <div class="row justify-content-center mb-4">
              <div class="col-md-12">
                {{ __('対戦が終了しました') }}
              </div>
            </div>
          @endif
        @endif
      </div>
    </div>
  </div>

  <div class="row justify-content-center row-eq-height mb-4">
    <div class="col-12">
      <div class="box">
        <div class="form-group row">
          <div class="col-md-12">
            <img src="{{$duel->duelUsers[0]->user->twitter_simple_image_url}}"
                 class="rounded-circle"
                 onerror="this.src='{{ asset('/images/icon/default-account.png') }}'"
            >
            <a href="/resume/{{$duel->duelUsers[0]->user_id}}">{{$duel->duelUsers[0]->user->name}}</a>
            @if($duel->duelUsers->where('user_id',$duel->duelUsers[0]->user_id)->first()->duelUserResults->isNotEmpty())
              レート：{{$duel->duelUsers->where('user_id',$duel->duelUsers[0]->user_id)->first()->duelUserResults->sum('rating')}}
            @endif
          </div>
          <div class="col-md-12 m-1 vs">vs</div>
          <div class="col-md-12">
            @isset($duel->duelUsers[1])
              <img src="{{$duel->duelUsers[1]->user->twitter_simple_image_url}}"
                   class="rounded-circle"
                   onerror="this.src='{{ asset('/images/icon/default-account.png') }}'"
              >
              <a href="/resume/{{$duel->duelUsers[1]->user_id}}">{{$duel->duelUsers[1]->user->name}}</a>
              @if($duel->duelUsers->where('user_id',$duel->duelUsers[1]->user_id)->first()->duelUserResults->isNotEmpty())
                レート：{{$duel->duelUsers->where('user_id',$duel->duelUsers[1]->user_id)->first()->duelUserResults->sum('rating')}}
              @endif
            @else
              @if(Auth::id() == $duel->user_id)
                <button type=“button” onclick="location.href='/reload'" class="btn site-color text-white rounded-pill btn-outline-secondary text-center">
                  {{ __('ページ更新') }}
                </button>
                <div>{{ __('相手が対戦申込したらページ更新してください') }}</div>
              @endif
            @endisset
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="text-left p-1 font-weight-bold">{{ __('対戦情報') }}</div>
  <div class="box pl-0 mb-4">
    <div class="row mb-4">
      <div class="col-6 text-left">
        <div class="pl-4 mb-1">対戦場所</div>
      </div>
      <div class="col-6">
        <h5 class="font-weight-bold text-danger">レート対戦{{$duel->room_id}}</h5>
        ※Discordチャンネル
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-6 text-left">
        <div class="pl-4 mb-1">レギュレーション</div>
      </div>
      <div class="col-6">
        <h5 class="font-weight-bold">
          {{\App\Enums\EventRegulationType::from($duel->eventDuel->event->regulation_type)->description()}}
        </h5>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-8 text-left">
        <div class="pl-4 mb-1">プロキシ(カラーコピー)</div>
      </div>
      <div class="col-4">
        <h5 class="font-weight-bold">
            {{\App\Enums\EventCardType::from($duel->eventDuel->event->card_type)->description()}}
        </h5>
      </div>
    </div>

  </div>

  @if($duel->eventDuel->event->status == \App\Enums\EventStatus::RECRUIT->value &&
    Auth::check() && (Auth::id() == $duel->user_id || Auth::id() == 1))
    <div class="row justify-content-center mb-4">
      <div class="col-12">
        <div class="box">
          <form method="POST" action="/duel/instant/{{$duel->id}}" onClick="return requestConfirm();">
            @csrf
            @method('PUT')
            {{--  なぜかputだとsubmitに値を持たせられないので判定用にhidden--}}
            <input type="hidden" name="event_cancel" value="1" >
            <button type="submit" class="btn btn-secondary rounded-pill pl-4 pr-4">
              {{ __('対戦をキャンセル') }}
            </button>
          </form>
        </div>
      </div>
    </div>
  @endif

  @include('layouts.common.discord._join')

  @if($duel->game_id == config('assets.site.game_ids.pokemon_card') && $duel->eventDuel->event->status == \App\Enums\EventStatus::RECRUIT->value)
    <div class="row justify-content-center mb-2">
      <div class="col-md-12">
        <div class="box">
          <div class="row"><div class="col-12">LINEオープンチャット参加でマッチング率が飛躍的に上昇します!!</div></div>
          <div class="row">
            <div class="col-sm-4"> </div>
            <div class="col-sm-4">
              <a href="https://line.me/ti/g2/Kt5eTJpAKQ9eV-De1_m7jeJA1XLIKaQFypvEZg?utm_source=invitation&utm_medium=link_copy&utm_campaign=default">
              <img class="img-fluid" src="{{ asset('/images/site/line.png') }}" alt="hashimu-icon"></a>
            </div>
            <div class="col-sm-4"> </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <div class="text-left p-1">{{ __('公式対戦ルール') }}</div>
  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="box">
        <div class="text-left">{{ __('回線不調時は不調側が敗北です。どちらか判断できない時はドロー') }}</div>
      </div>
    </div>
  </div>
</div>

<script>
  function copyUrl() {
    const element = document.createElement('input');
    element.value = location.href;
    document.body.appendChild(element);
    element.select();
    document.execCommand('copy');
    document.body.removeChild(element);
  }
</script>

@endsection



@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
