@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/event/index.css') }}">
@endsection

@section('content')

<div class="container">
  <div class="row justify-content-center ml-1 mb-3">
    <div class="col-6">
          {{ __('1vs1対戦') }}
    </div>
    <div class="col-6">
      <btton class="btn site-color text-white btn-outline-secondary text-center w-100"
             onclick="location.href='/event/instant/create'">
        {{ __('+ 新規対戦作成') }}
      </btton>
    </div>
  </div>

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-md-12">
        <div class="text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
        </div>
      </div>
    @endif
  </div>

  @if(!empty($events))
    @foreach($events as $event)
    <div class="box mb-3" onclick="location.href='/duel/instant/{{$event->eventDuels[0]->duel_id}}'">
      <span class="mouseover">クリックで詳細へ</span>
      <div class="row bg-light p-2">
        <div class="col-4 m-0 p-0 text-left">
          @if($event->status == \APP\Models\Event::STATUS_RECRUIT )
            <div class="post-user text-danger justify-content-start">[{{ __('対戦受付中') }}]</div>
          @elseif($event->status == \APP\Models\Event::STATUS_READY )
            <div class="post-user text-warning justify-content-start">[{{ __('マッチング済') }}]</div>
          @elseif($event->status == \APP\Models\Event::STATUS_FINISH )
            <div class="text-secondary font-weight-bold justify-content-start">[{{ __('対戦完了') }}]</div>
          @elseif($event->status == \APP\Models\Event::STATUS_CANCEL )
            <div class="text-secondary font-weight-bold justify-content-start">[{{ __('キャンセル') }}]</div>
          @elseif($event->status == \APP\Models\Event::STATUS_INVALID )
            <div class="text-secondary font-weight-bold justify-content-start">[{{ __('無効試合') }}]</div>
          @endif
        </div>
          <div class="col-8 m-0 p-0 text-right">
            [対戦日：{{date('Y-m-d H:i', strtotime($event->date . ' ' . $event->start_time))}}]
            </div>
      </div>
      <div class="row justify-content-center pb-2 align-items-center">
        <div class="col-sm-5 col-12 mobile-left">
          <img src="{{$event->eventUsers[0]->user->twitter_simple_image_url}}"
               class="rounded-circle"
               onerror="this.src='{{ asset('/images/icon/default-account.png') }}'"
          >
          {{$event->eventUsers[0]->user->name }}
        </div>
        <div class="col-sm-2 col-12 vs">
          vs
        </div>
        <div class="col-sm-5 col-12 mobile-right">
          @isset($event->eventUsers[1])
            {{$event->eventUsers[1]->user->name }}
            <img src="{{$event->eventUsers[1]->user->twitter_simple_image_url}}"
                 class="rounded-circle"
                 onerror="this.src='{{ asset('/images/icon/default-account.png') }}'"
            >
          @else
            （募集中）
          @endisset
        </div>
      </div>
    </div>
    @endforeach
  @endif
    {{$events->links('layouts.common.pagination.bootstrap-4')}}
  </div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
