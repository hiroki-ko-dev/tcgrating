@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-links-blue text-white rounded p-3 mb-3">
                <h5>{{ __('マイページ') }}</h5>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="col-md-8">
                <div class="text-center alert-danger rounded p-3 mb-3">
                    {{ session('flash_message') }}
                </div>
            </div>
        @endif
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($user->id === Auth::id())
                <div class="col-md-8 offset-md-4">
                    <a class="btn btn-link text-center" href="/user/{{$user->id}}/edit">
                        {{ __('編集する') }}
                    </a>
                </div>

                <div class="card">
                    <div class="card-header">{{ __('メールアドレス') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div type="body">{{$user->email}}</div>
                            </div>
                        </div>
                    </div>
                  @if($user->twitter_id == null)
                    <div class="card-header">{{ __('Twitter連携') }}</div>
                    <div class="card-body">
                      <div class="col-md-5">
                        <div class="d-flex flex-row mb-3">
                          <a href="/auth/twitter/login"><img class="img-fluid" src="{{ asset('/images/site/twitter/relation.png') }}" alt="hashimu-icon"></a>
                        </div>
                      </div>
                    </div>
                  @endif
            @else
                <div class="card">
            @endif

                <div class="card-header">{{ __('基本情報') }}</div>
                <div class="card-body">
                    <div class="d-flex flex-row mb-3">
                        <div class="w-30 font-weight-bold">{{ __('ユーザー名') }}</div>
                        <div class="w-70">{{$user->name}}</div>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="w-30 font-weight-bold">{{ __('レート') }}</div>
                        <div class="w-70">
                          @if(!is_null($user->gameUsers->where('game_id', Auth::user()->selected_game_id)->first()))
                            {{number_format($user->gameUsers->where('game_id', Auth::user()->selected_game_id)->first()->rate)}}
                          @else
                            0
                          @endif
                        </div>
                    </div>
                </div>

                <div class="card-header">{{ __('プロフィール文') }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div type="body">{!! nl2br(e($user->body)) !!}</div>
                        </div>
                    </div>
                </div>

                <div class="card-header">{{ __('参加中イベント') }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            @foreach($events as $event)
                              @if($event->game_id == Auth::user()->selected_game_id)
                                @if($event->status == \App\Models\Event::RECRUIT)
                                    <div type="body"><a href="/event/single/{{$event->id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(対戦相手受付中)</a></div>
                                @elseif($event->status == \App\Models\Event::READY)
                                    <div type="body"><a href="/event/single/{{$event->id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(マッチング済)</a></div>
                                @endif
                              @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
