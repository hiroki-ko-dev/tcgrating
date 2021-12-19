@extends('layouts.common.common')

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
          {{--ログインしている場合--}}
          <div class="font-weight-bold text-left">{{ __('対戦申込にはTwitterログインをしてください') }}</div>
          <div class="col-sm-4">
            <a href="/auth/twitter/login"><img class="img-fluid" src="{{ asset('/images/site/twitter/relation.png') }}" alt="hashimu-icon"></a>
          </div>
        @else
          {{--ログインしていない場合--}}
          @if($duel->eventDuel->event->status == \App\Models\Event::RECRUIT)
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
              <form method="POST" action="/event/instant/user" onClick="return requestConfirm();">
                @csrf
                <input type="hidden" name="event_id" value="{{$duel->eventDuel->event->id}}">
                <input type="hidden" name="duel_id" value="{{$duel->id}}">
                <div class="box-header text-left">{{ __('対戦申込') }}</div>
                <button type="submit" name="event_add_user" value="1" class="btn site-color text-white rounded-pill btn-outline-secondary text-center">
                  {{ __('対戦申込') }}
                </button>
                <div class="font-weight-bold text-danger">{{ __('「対戦申込」を押してください') }}</div>
              </form>
            @endif
          @elseif($duel->eventDuel->event->status == \App\Models\Event::READY)
            {{--対戦相手募集が完了している場合--}}
            @if($duel->duelUsers->where('user_id',Auth::id())->isNotEmpty() || (Auth::check() && Auth::id() ==1))
              {{--対戦者同士の場合--}}
              <div class="row justify-content-center mb-4">
                <div class="col-md-12">
                  <div class="box">
                    <div class="card-body">
                      <div class="form-group row">
                        <div class="col-md-12 font-weight-bold">
                          {{ __('対戦ツールから連絡をとり、対戦を行ってください') }}
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-12">
                          <form method="POST" action="/duel/instant" onClick="return requestConfirm();">
                            @csrf
                            <input type="hidden" name="duel_id" value="{{$duel->id}}">
                            <span class="col-md-3 ">
                              <input type="submit" class="btn btn-primary rounded-pill btn-outline-dark text-light" name="win" value="　勝利　">
                            </span>
                            <span class="col-md-7">
                              <input type="submit" class="btn btn-secondary rounded-pill btn-outline-dark text-light" name="draw" value="　ドロー">
                            </span>
                            <div class="col-md-12 mt-3">
                              <span class="font-weight-bold text-danger">{{ __('1試合ごと') }}</span>
                              <span>{{ __('に') }}</span>
                              <span class="font-weight-bold text-danger">{{ __('勝者') }}</span>
                              <span>{{ __('が「勝利」ボタンを押してください') }}</span>
                            </div>
                            <div class="col-md-12 mb-3">
                              {{ __('※ドローの場合はどちらが押しても良い') }}
                            </div>
                            <span class="col-md-7">
                              <input type="submit" class="btn site-color text-white rounded-pill btn-outline-secondary text-center" name="finish" value="対戦完了">
                            </span>
                            <div class="col-md-12 mt-3">
                              <span class="font-weight-bold text-danger">{{ __('最終試合') }}</span>
                              <span>{{ __('の') }}</span>
                              <span class="font-weight-bold text-danger">{{ __('勝者') }}</span>
                              <span>{{ __('が「対戦完了」を押してください') }}</span>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @else
              <div class="row justify-content-center mb-4">
                <div class="col-md-12">
                  <div class="box">
                    {{ __('すでに対戦マッチング済です') }}
                  </div>
                </div>
              </div>
            @endif
          @elseif($duel->eventDuel->event->status == \App\Models\Event::CANCEL)
            <div class="row justify-content-center mb-4">
              <div class="col-md-12">
                <div class="box">
                  {{ __('対戦がキャンセルされました') }}
                </div>
              </div>
            </div>
          @else
            <div class="row justify-content-center mb-4">
              <div class="col-md-12">
                <div class="box">
                  {{ __('対戦が終了しました') }}
                </div>
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
            <img src="{{$duel->duelUsers[0]->user->twitter_simple_image_url}}" class="rounded-circle">
            <a href="/user/{{$duel->duelUsers[0]->user_id}}">{{$duel->duelUsers[0]->user->name}}</a>
            @if($duel->duelUsers->where('user_id',$duel->duelUsers[0]->user_id)->first()->duelUserResults->isNotEmpty())
              レート：{{$duel->duelUsers->where('user_id',$duel->duelUsers[0]->user_id)->first()->duelUserResults->sum('rating')}}
            @endif
          </div>
          <div class="col-md-12 m-1">vs</div>
          <div class="col-md-12">
            @isset($duel->duelUsers[1])
              <img src="{{$duel->duelUsers[1]->user->twitter_simple_image_url}}" class="rounded-circle">
              <a href="/user/{{$duel->duelUsers[1]->user_id}}">{{$duel->duelUsers[1]->user->name}}</a>
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

  @if($duel->eventDuel->event->status == \App\Models\Event::RECRUIT &&
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

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="box">
        <div class="box-header text-left">{{ __('対戦ツール') }}</div>
          <div class="d-flex flex-row mb-3">
            <div class="w-30 font-weight-bold">{{ __('対戦ツール') }}</div>
            <div class="w-70 post-body">{{config('assets.duel.tool')[$duel->tool_id]}}</div>
          </div>
          <div class="d-flex flex-row mb-3">
            <div class="w-30 font-weight-bold">{{ __('対戦コード') }}</div>
            <div class="w-70 post-body">{{$duel->tool_code}}</div>
          </div>
      </div>
    </div>
  </div>

  @if($duel->game_id == config('assets.site.game_ids.pokemon_card') && $duel->eventDuel->event->status == \App\Models\Event::RECRUIT)
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
          <div class="row"><div class="col-12">対戦URLをオープンチャットに貼り付けて対戦を呼びかけてみましょう!!</div></div>
        </div>
      </div>
    </div>
  @endif

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="box">
        <div class="box-header text-left">{{ __('公式対戦ルール') }}</div>
        <div class="font-weight-bold text-left">{{ __('対戦回数：両者で回数を決定してください') }}</div>
        <div class="font-weight-bold text-left">{{ __('レギュレーション：スタンダード') }}</div>
        <div class="font-weight-bold text-left">{{ __('回線不調時は？：回線不調側を敗北としてください。どちらか判断できない時はドローです') }}</div>
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
