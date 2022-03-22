@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      <div class="d-flex flex-row mb-3">
        <div>
          {{ __('マイページ') }}
        </div>
        <div class="ml-auto">
          @if($user->id === Auth::id())
              <button class="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                      onclick="location.href='/user/{{$user->id}}/edit'">
                {{ __('編集する') }}
              </button>
          @endif
        </div>
      </div>
    </div>
  </div>

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

  <div class="row justify-content-center">
    <div class="col-sm-6 mb-4">
      <div class="box">
        <img src="{{$user->twitter_image_url}}" class="img-rounded img-fluid"
             onerror="this.src='{{ asset('/images/icon/default-icon-mypage.png') }}'"
        >
      </div>
    </div>
    <div class="col-sm-6">
      <div class="row justify-content-center">
        <div class="col-12 mb-4">
          <div class="box text-left">
            <div class="box-header">{{ __('ユーザー名') }}</div>
            <div class="d-flex flex-row mb-3">
              <div class="body">{{$user->name}}</div>
            </div>
          </div>
        </div>
        <div class="col-12 mb-4">
          <div class="box text-left">
            <div class="box-header">{{ __('レート') }}</div>
            <div class="body">
              @if(isset(Auth::user()->selected_game_id) && !is_null($user->gameUsers->where('game_id', Auth::user()->selected_game_id)->first()))
                {{number_format($user->gameUsers->where('game_id', Auth::user()->selected_game_id)->first()->rate)}}
              @elseif(session('selected_game_id') && $user->gameUsers->where('game_id', session('selected_game_id'))->isNotEmpty())
                {{number_format($user->gameUsers->where('game_id', session('selected_game_id'))->first()->rate)}}
              @else
                0
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
{{--    <div class="col-sm-6 mb-4">--}}
{{--      <div class="box text-left">--}}
{{--        <div class="box-header">{{ __('メールアドレス') }}</div>--}}
{{--        @if($user->id === Auth::id())--}}
{{--          <div class="body">{{$user->email}}</div>--}}
{{--        @else--}}
{{--          <div class="body">{{ __('※本人にのみ表示されます') }}</div>--}}
{{--        @endif--}}
{{--      </div>--}}
{{--    </div>--}}

    @if($user->twitter_id == null)
      <div class="col-sm-6 mb-4">
        <div class="box text-left">
          @if($user->id === Auth::id())
            <div class="box-header">{{ __('Twitter連携') }}</div>
            <a href="/auth/twitter/login"><img class="img-fluid" src="{{ asset('/images/site/twitter/relation.png') }}" alt="hashimu-icon"></a>
          @else
            ※このユーザーはTwitter未連携です
          @endif
        </div>
      </div>
    @else
      @if(Auth::id() == 1)
        <div class="col-sm-6 mb-4">
          <div class="box text-left">
            <div class="box-header">{{ __('Twitterアカウント') }}</div>
            <a href="https://twitter.com/{{$user->twitter_nickname}}"><div type="body">＠{{$user->twitter_nickname}}</div></a>
          </div>
        </div>
      @endif
    @endif


  </div>

  <div class="row justify-content-center">
    <div class="col-12 mb-4">
      <div class="box text-left">
        <div class="box-header">{{ __('プロフィール文') }}</div>
        <div type="body">{!! nl2br(e($user->body)) !!}</div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-12 mb-4">
      <div class="box text-left">
        <div class="box-header">{{ __('参加中イベント') }}</div>
        @foreach($events as $event)
          @if($event->event_category_id == \App\Models\EventCategory::CATEGORY_SINGLE)
            @if(isset(Auth::user()->selected_game_id) && $event->game_id == Auth::user()->selected_game_id)
              @if($event->status == \App\Models\Event::STATUS_RECRUIT)
                <div type="body"><a href="/duel/instant/{{$event->eventDuels[0]->duel_id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(対戦相手受付中)</a></div>
              @elseif($event->status == \App\Models\Event::STATUS_READY)
                <div type="body"><a href="/duel/instant/{{$event->eventDuels[0]->duel_id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(マッチング済)</a></div>
              @endif
            @elseif(session('selected_game_id') && $user->gameUsers->where('game_id', session('selected_game_id'))->isNotEmpty() && $event->game_id == $user->gameUsers->where('game_id', session('selected_game_id'))->first()->game_id)
              @if($event->status == \App\Models\Event::STATUS_RECRUIT)
                <div type="body"><a href="/duel/instant/{{$event->eventDuels[0]->duel_id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(対戦相手受付中)</a></div>
              @elseif($event->status == \App\Models\Event::STATUS_READY)
                <div type="body"><a href="/duel/instant/{{$event->eventDuels[0]->duel_id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(マッチング済)</a></div>
              @endif
            @endif
          @endif
        @endforeach
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  window.ReactNativeWebView.postMessage({{Auth::id()}});
</script>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
