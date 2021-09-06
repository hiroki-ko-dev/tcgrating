@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="bg-site-black text-white rounded p-3 mb-3">
        <h2>{{ __('ポイントバトル決闘') }}</h2>
    </div>

    <div class="row justify-content-center">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="text-center alert-danger rounded p-3 mb-3 col-md-7">
                {{ session('flash_message') }}
            </div>
        @endif
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="col-md-8 offset-md-4">
                <a class="btn btn-link text-center" href="/event/point/create">
                    {{ __('新規決闘作成') }}
                </a>
            </div>

            <div class="card">
                <div class="card-header">{{ __('ポイントバトル決闘一覧') }}</div>

                <div class="card-body">
                    @if(!empty($events))
                        @foreach($events as $event)
                            <div class="card-text border-bottom p-2">
                                <a href="/event/single/{{$event->id}}">vs {{$event->eventUsers[0]->user->name }}</a>

                                @if($event->status == \APP\Models\Event::RECRUIT )
                                        <span class="post-user">[対戦日時:{{$event->date}} {{$event->start_time}}][{{ __('対戦受付中') }}]</span>
                                    @elseif($event->status == \APP\Models\Event::READY )
                                        <span class="post-user">[対戦日時:{{$event->date}} {{$event->start_time}}][{{ __('マッチング済') }}]</span>
                                    @elseif($event->status == \APP\Models\Event::FINISH )
                                        <span class="text-secondary font-weight-bold">[対戦日時:{{$event->date}} {{$event->start_time}}][{{ __('対戦完了') }}]</span>
                                    @elseif($event->status == \APP\Models\Event::CANCEL )
                                        <span class="text-secondary font-weight-bold">[対戦日時:{{$event->date}} {{$event->start_time}}][{{ __('対戦キャンセル') }}]</span>
                                    @elseif($event->status == \APP\Models\Event::INVALID )
                                        <span class="text-secondary font-weight-bold">[対戦日時:{{$event->date}} {{$event->start_time}}][{{ __('無効試合') }}]</span>
                                    @endif
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
