@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('1vs1対戦（受付ページ）') }}
    </div>
  </div>

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-md-12 text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
      </div>
    @endif
  </div>

  <div class="row justify-content-center row-eq-height mb-4">
    <div class="col-12">
      <div class="box">
        <div class="form-group row">
          <div class="col-md-12">
            <img src="{{$event->eventUsers[0]->user->twitter_simple_image_url}}" class="rounded-circle">
            <a href="/user/{{$event->eventUsers[0]->user_id}}">{{$event->eventUsers[0]->user->name}}</a>
            @if($event->eventDuels[0]->duel->duelUsers->where('user_id',$event->eventUsers[0]->user_id)->first()->duelUserResults->isNotEmpty())
              レート：{{$event->eventDuels[0]->duel->duelUsers->where('user_id',$event->eventUsers[0]->user_id)->first()->duelUserResults->sum('rating')}}
            @endif
          </div>
          <div class="col-md-12 m-1">vs</div>
          <div class="col-md-12">
            @isset($event->eventUsers[1])
              <img src="{{$event->eventUsers[1]->user->twitter_simple_image_url}}" class="rounded-circle">
              <a href="/user/{{$event->eventUsers[1]->user_id}}">{{$event->eventUsers[1]->user->name}}</a>
              @if($event->eventDuels[0]->duel->duelUsers->where('user_id',$event->eventUsers[1]->user_id)->first()->duelUserResults->isNotEmpty())
                レート：{{$event->eventDuels[0]->duel->duelUsers->where('user_id',$event->eventUsers[1]->user_id)->first()->duelUserResults->sum('rating')}}
              @endif
            @endisset
          </div>
          <div class="col-md-12">
            @if($event->user_id <> Auth::id() && $event->status == \APP\Models\Event::RECRUIT)
              <form method="POST" action="/event/user" onClick="return requestConfirm();">
                @csrf
                <input type="hidden" name="event_id" value="{{$event->id}}">
                <input type="hidden" name="duel_id" value="{{$event->eventDuels[0]->duel->id}}">
                <button type="submit" name="event_add_user" value="1" class="btn site-color text-white rounded-pill btn-outline-secondary text-center">
                  {{ __('対戦申込') }}
                </button>
              </form>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center row-eq-height">
    <div class="col-sm-6 mb-4">
      <div class="box">
        <div class="d-flex flex-row mb-3">
          <div class="w-30 font-weight-bold">状態</div>
            @if($event->status == \APP\Models\Event::RECRUIT )
              <span class="post-user w-70">{{ __('：対戦受付中') }}</span>
            @elseif($event->status == \APP\Models\Event::READY )
              <span class="post-user w-70">{{ __('マッチング済') }}</span>
            @elseif($event->status == \APP\Models\Event::FINISH )
              <span class="post-user w-70">{{ __('対戦完了') }}</span>
            @elseif($event->status == \APP\Models\Event::CANCEL )
              <span class="post-user w-70">{{ __('対戦キャンセル') }}</span>
            @elseif($event->status == \APP\Models\Event::INVALID )
              <span class="post-user w-70">{{ __('無効試合') }}</span>
            @endif
          </div>
        {{-- 対戦相手を募集している段階ではキャンセルができる --}}
        @if($event->status == \APP\Models\Event::RECRUIT && Auth::id() == $event->user_id)
          <form method="POST" action="/event/single/{{$event->id}}" onClick="return requestConfirm();">
            @csrf
            @method('PUT')
            {{--  なぜかputだとsubmitに値を持たせられないので判定用にhidden--}}
            <input type="hidden" name="event_cancel" value="1" >
            <button type="submit" class="btn btn-secondary rounded-pill pl-4 pr-4">
              {{ __('キャンセル') }}
            </button>
          </form>
        @endif
      </div>
    </div>
    <div class="col-sm-6 mb-4">
      <div class="box">
        <div class="d-flex flex-row mb-3">
          <div class="w-30 font-weight-bold">対戦回数</div>
          <div class="w-70">{{$event->eventDuels[0]->duel->number_of_games}}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center row-eq-height mb-4">
    <div class="col-sm-12">
      <div class="box">
        <div class="d-flex flex-row mb-3">
          <div class="w-30 font-weight-bold">対戦開始</div>
          <div class="w-70"><span class="post-user">{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}</span></div>
        </div>
        <div class="d-flex flex-row mb-3">
          <div class="small">※必ず対戦開始前に「<a href="/site/how_to_use">1vs1対戦の使い方</a>」動画を視聴してください</div>
        </div>
          @if($event->status <> \App\Models\Event::RECRUIT && $event->status <> \App\Models\Event::CANCEL )
          <div class="d-flex flex-row mb-3">
            <div class="small">※対戦開始日時になったら対戦ページへ移動してください</div>
          </div>
          <div class="d-flex justify-content-center mb-3">
            <button class="btn site-color rounded-pill btn-outline-secondary text-light" onclick="location.href='/duel/single/{{$event->eventDuels[0]->duel->id}}'">対戦ページへ移動</button>
          </div>
          @endif

          <div class="form-group row">
            <div class="col-md-12">
              <div type="body">{!! nl2br(e($event->body)) !!}</div>
            </div>
          </div>
            </div>
        </div>
      </div>

    <div class="row justify-content-center row-eq-height">
      <div class="col-md-6 mb-4">
        <div class="box text-left">
        <div class="box-header">
          {{ __('対戦方法') }}　
            @if($event->eventDuels[0]->duel->duelUsers[0]->user_id == Auth::id())
              （<a href="/duel/single/{{$event->eventDuels[0]->duel->id}}/edit">編集する</a>）
            @endif
        </div>
          @if($event->eventDuels[0]->duel->game_id == config('assets.site.game_ids.yugioh_duellinks'))
            @if(!is_null($event->eventDuels[0]->duel->duelUsers->where('user_id',Auth::id())->first()))
              <div class="d-flex flex-row mb-3">
                <div class="w-30">{{ __('ルームID') }}</div>
                <div class="w-70">{{$event->eventDuels[0]->duel->room_id}}</div>
              </div>
              <div class="d-flex flex-row mb-3 text-secondary">
                {{ __('※ルームIDは対戦プレイヤーにのみ表示されます')}}
              </div>
            @endif
            <div class="d-flex flex-row mb-3">
              <div class="w-30">{{ __('観戦ID') }}</div>
              <div class="w-70">{{$event->eventDuels[0]->duel->watching_id}}</div>
            </div>
          @else
            <div class="d-flex flex-row mb-3">
              <div class="w-30 font-weight-bold">{{ __('ツール') }}</div>
              <div class="w-70">{{config('assets.duel.tool')[$event->eventDuels[0]->duel->tool_id]}}</div>
            </div>
            @if(!is_null($event->eventDuels[0]->duel->duelUsers->where('user_id',Auth::id())->first()))
              <div class="d-flex flex-row mb-3">
                <div class="w-30 font-weight-bold">{{ __('対戦コード') }}</div>
                <div class="w-70">{{$event->eventDuels[0]->duel->tool_code}}</div>
              </div>
              <div class="d-flex flex-row mb-3 text-secondary">
                {{ __('※フレンドコード,ルームID、招待URL等')}}
              </div>
              <div class="d-flex flex-row mb-3 text-secondary">
                {{ __('※対戦コードは対戦プレイヤーにのみ表示されます')}}
              </div>
            @endif
          @endif
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="box text-left">
        <div class="box-header">
            {{ __('配信URL') }}
          @if($event->eventUsers->where('user_id',Auth::id())->isNotEmpty())
            （<a href="/event/single/{{$event->id}}/edit">編集する</a>）
          @endif
        </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <div class="post-body">
                        {{$event->eventUsers[0]->user->name}}視点：{{$event->eventUsers[0]->stream_url}}<br>
                        @isset($event->eventUsers[1])
                        {{$event->eventUsers[1]->user->name}}視点：{{$event->eventUsers[1]->stream_url}}<br>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

    @include('layouts.post.post_and_comment')
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
