@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('1vs1対戦(対戦ページ)') }}
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
            @endisset
          </div>
        </div>
      </div>
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
              <div class="d-flex flex-row mb-3">
                <div class="font-weight-bold text-left mr-3">{{env('APP_URL')}}/duel/instant/{{$duel->id}}</div>
                <button id="copy" class="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                      name="copy" value="{{env('APP_URL')}}/duel/instant/{{$duel->id}}" onclick="copyUrl()">コピー</button>
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
              </form>
            @endif
          @else
            {{--対戦相手募集が完了している場合--}}
            @if($duel->duelUsers->where('user_id',Auth::id())->isNotEmpty())
              {{--対戦者同士の場合--}}
              <div class="row justify-content-center mb-4">
                <div class="col-md-12">
                  <div class="box">
                    <div class="card-body">
                      <div class="form-group row">
                        <div class="col-md-12">
                          {{ __('※勝者がボタンを押してください。ドローの場合はどちらが押しても良いです') }}
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
          @endif
        @endif
      </div>
    </div>
  </div>

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

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="box">
        <div class="box-header text-left">{{ __('公式対戦ルール') }}</div>
        <div class="font-weight-bold text-left">{{ __('対戦回数：1回勝負') }}</div>
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
