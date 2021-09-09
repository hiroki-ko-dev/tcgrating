@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="bg-site-black text-white rounded p-3 mb-3">
              <div class="d-flex flex-row mb-3">
                <div>
                  <h5>{{ __('マイページ') }}</h5>
                </div>
                <div class="ml-auto">
                  @if($user->id === Auth::id())
                      <button class="btn rounded-pill btn-outline-light text-center"
                              onclick="location.href='/user/{{$user->id}}/edit'">
                        {{ __('編集する') }}
                      </button>
                  @endif
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
            @if($user->id === Auth::id())
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
                  @else
                    <div class="card-header">{{ __('Twitterアカウント') }}</div>
                    <div class="card-body">
                      <div class="col-md-5">
                        <div class="d-flex flex-row mb-3">
                          <a href="https://twitter.com/{{$user->twitter_nickname}}"><div type="body">＠{{$user->twitter_nickname}}</div></a>
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
                              @if(isset(Auth::user()->selected_game_id) && $event->game_id == Auth::user()->selected_game_id)
                                @if($event->status == \App\Models\Event::RECRUIT)
                                    <div type="body"><a href="/event/single/{{$event->id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(対戦相手受付中)</a></div>
                                @elseif($event->status == \App\Models\Event::READY)
                                    <div type="body"><a href="/event/single/{{$event->id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(マッチング済)</a></div>
                                @endif
                              @elseif(session('selected_game_id') && $user->gameUsers->where('game_id', session('selected_game_id'))->isNotEmpty() && $event->game_id == $user->gameUsers->where('game_id', session('selected_game_id'))->first()->game_id)
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
