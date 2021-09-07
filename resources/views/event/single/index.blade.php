@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="site-color text-white rounded p-3 mb-3">
        <div class="d-flex flex-row mb-3">
          <div>
            <h5>{{ __('1vs1対戦') }}</h5>
          </div>
          <div class="ml-auto">
            <btton class="btn rounded-pill btn-outline-light text-center"
                   onclick="location.href='/event/single/create'">
              {{ __('新規決闘作成') }}
            </btton>
          </div>
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

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body pl-1 pr-1">
                    @if(!empty($events))
                        @foreach($events as $event)
                          <div class="card-text border-bottom p-2">
                            <span class="d-flex flex-row flex-wrap">
                              <span>
                                @if($event->status == \APP\Models\Event::RECRUIT )
                                  <span class="post-user mr-3 sm-mr-5">[{{ __('対戦受付中') }}]</span>
                                @elseif($event->status == \APP\Models\Event::READY )
                                  <span class="post-user text-warning mr-3 sm-mr-5">[{{ __('マッチング済') }}]</span>
                                @elseif($event->status == \APP\Models\Event::FINISH )
                                  <span class="text-secondary font-weight-bold mr-3 sm-mr-5">[{{ __('対戦完了') }}]</span>
                                @elseif($event->status == \APP\Models\Event::CANCEL )
                                  <span class="text-secondary font-weight-bold mr-3 sm-mr-5">[{{ __('対戦キャンセル') }}]</span>
                                @elseif($event->status == \APP\Models\Event::INVALID )
                                  <span class="text-secondary font-weight-bold mr-3 sm-mr-5">[{{ __('無効試合') }}]</span>
                                @endif
                              </span>
                              <span class="mr-3 sm-mr-5">
                                [対戦日時:{{$event->date}} {{$event->start_time}}]
                              </span>
                              <span>
                                <a href="/event/single/{{$event->id}}">{{$event->eventUsers[0]->user->name }} vs @isset($event->eventUsers[1]){{$event->eventUsers[1]->user->name}}@else（　　）@endisset</a>
                              </span>
                            </span>
                          </div>
                        @endforeach
                    @endif
                </div>
            </div>
            {{$events->links('pagination::bootstrap-4')}}
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
