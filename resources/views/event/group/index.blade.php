@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      <div class="d-flex flex-row mb-3">
        <div>
          {{ __('1vs1対戦') }}
        </div>
        <div class="ml-auto">
          <btton class="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                 onclick="location.href='/event/instant/create'">
            {{ __('新規対戦作成') }}
          </btton>
        </div>
      </div>
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

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="box">
        @if(!empty($events))
          @foreach($events as $event)
            <div class="row justify-content-center border-bottom p-2">
              <div class="col-sm-12">
                  <div class="d-sm-flex flex-row flex-wrap text-left">
                    @if($event->status == \App\Enums\EventStatus::RECRUIT->value )
                      <div class="post-user mr-3 sm-mr-5">[{{ __('対戦受付中') }}]</div>
                    @elseif($event->status == \App\Enums\EventStatus::READY->value )
                      <div class="post-user text-warning mr-3 sm-mr-5">[{{ __('マッチング済') }}]</div>
                    @elseif($event->status == \App\Enums\EventStatus::FINISH->value )
                      <div class="text-secondary font-weight-bold mr-3 sm-mr-5">[{{ __('対戦完了') }}]</div>
                    @elseif($event->status == \App\Enums\EventStatus::CANCEL->value )
                      <div class="text-secondary font-weight-bold mr-3 sm-mr-5">[{{ __('対戦キャンセル') }}]</div>
                    @elseif($event->status == \App\Enums\EventStatus::INVALID->value )
                      <div class="text-secondary font-weight-bold mr-3 sm-mr-5">[{{ __('無効試合') }}]</div>
                    @endif
                    <div class="mr-3 sm-mr-5">
                      [対戦日時:{{$event->date}} {{$event->start_time}}]
                    </div>
                    <div>
                      <a href="/duel/instant/{{$event->eventDuels[0]->duel_id}}">{{$event->eventUsers[0]->user->name }} vs @isset($event->eventUsers[1]){{$event->eventUsers[1]->user->name}}@else（　　）@endisset</a>
                    </div>
                  </div>
                </div>
            </div>
          @endforeach
        @endif
            {{$events->links('pagination::bootstrap-4')}}
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
