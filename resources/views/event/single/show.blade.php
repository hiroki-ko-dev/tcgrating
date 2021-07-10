@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-links-blue text-white rounded p-3 mb-3">
                <h5>{{ __('新規1vs1決闘（受付ページ）') }}</h5>
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

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $event->title }}
                </div>
                <div class="card-body">
                    <div class="d-flex flex-row mb-3">
                      <div class="w-30 font-weight-bold">主催</div>
                      <div class="w-70">：<a href="/user/{{$event->eventUser[0]->user_id}}">{{$event->eventUser[0]->user->name}}</a></div>
                    </div>
                    <div class="d-flex flex-row mb-3">
                        <div class="w-30 font-weight-bold">決闘回数</div>
                        <div class="w-70">：{{$event->eventDuel[0]->duel->number_of_games}}</div>
                    </div>
                    <div class="d-flex flex-row mb-3">
                      <div class="w-30 font-weight-bold">状態</div>
                    @if($event->status == \APP\Models\Event::RECRUIT )
                        <span class="post-user w-30">{{ __('：対戦受付中') }}</span>
                      </div>
                      <div class="w-50">
                          @if(Auth::id() == $event->user_id)
                              <form method="POST" action="/event/single/{{$event->id}}" onClick="return requestConfirm();">
                                  @csrf
                                  @method('PUT')
                                  <button type="submit" name="event_cancel" class="btn btn-secondary w-40" >
                                      {{ __('キャンセルする') }}
                                  </button>
                              </form>
                          @endif
                      </div>
                    @elseif($event->status == \APP\Models\Event::READY )
                        <span class="post-user">{{ __('：マッチング済') }}</span>
                      </div>
                    @elseif($event->status == \APP\Models\Event::FINISH )
                        <span class="post-user">{{ __('：対戦完了') }}</span>
                      </div>
                    @elseif($event->status == \APP\Models\Event::CANCEL )
                        <span class="post-user">{{ __('：対戦キャンセル') }}</span>
                      </div>
                    @elseif($event->status == \APP\Models\Event::INVALID )
                        <span class="post-user">{{ __('：無効試合') }}</span>
                      </div>
                    @endif
                    <div class="d-flex flex-row mb-3">
                        <div class="small">※必ず対戦開始前に「<a href="/site/how_to_use">1vs1決闘の使い方</a>」動画を視聴してください</div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div type="body">{!! nl2br(e($event->body)) !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('プレイヤー') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="body">
                                <a href="/user/{{$event->eventUser[0]->user_id}}">{{$event->eventUser[0]->user->name}}</a>
                                @if($event->eventDuel[0]->duel->duelUser->where('user_id',$event->eventUser[0]->user_id)->first()->duelUserResult->isNotEmpty())
                                    　レート：{{$event->eventDuel[0]->duel->duelUser->where('user_id',$event->eventUser[0]->user_id)->first()->duelUserResult->sum('rating')}}
                                @endif
                                <br>
                                vs<br>
                                @isset($event->eventUser[1])
                                <a href="/user/{{$event->eventUser[1]->user_id}}">{{$event->eventUser[1]->user->name}}</a>
                                    @if($event->eventDuel[0]->duel->duelUser->where('user_id',$event->eventUser[1]->user_id)->first()->duelUserResult->isNotEmpty())
                                        　レート：{{$event->eventDuel[0]->duel->duelUser->where('user_id',$event->eventUser[1]->user_id)->first()->duelUserResult->sum('rating')}}
                                    @endif
                                @endisset
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-5">
                            @if($event->user_id <> Auth::id() && $event->status == \APP\Models\Event::RECRUIT)
                                <form method="POST" action="/event/user" onClick="return requestConfirm();">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{$event->id}}">
                                    <input type="hidden" name="duel_id" value="{{$event->eventDuel[0]->duel->id}}">
                                    <button type="submit" name="event_add_user" value="1" class="btn btn-primary">
                                        {{ __('対戦申込') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('対戦開始時間') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-user">{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}</div> ※対戦開始日時になったら決闘ページへ移動してください
                            @if($event->status <> \App\Models\Event::RECRUIT)
                                <div class="col-md-6 offset-md-5">
                                    <button class="btn btn-primary" onclick="location.href='/duel/single/{{$event->eventDuel[0]->duel->id}}'">決闘ページへ移動</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('観戦ID') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-body">{{$event->eventDuel[0]->duel->watching_id}}
                                @if($event->eventDuel[0]->duel->duelUser[0]->user_id == Auth::id())
                                    （<a href="/duel/single/{{$event->eventDuel[0]->duel->id}}/edit">編集する</a>）
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('配信URL') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-body">
                                {{$event->eventUser[0]->user->name}}視点：{{$event->eventUser[0]->stream_url}}<br>
                                @isset($event->eventUser[1])
                                {{$event->eventUser[1]->user->name}}視点：{{$event->eventUser[1]->stream_url}}<br>
                                @endisset
                                @if($event->eventUser->where('user_id',Auth::id())->isNotEmpty())
                                    （<a href="/event/single/{{$event->id}}/edit">編集する</a>）
                                @endif
                            </div>
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
