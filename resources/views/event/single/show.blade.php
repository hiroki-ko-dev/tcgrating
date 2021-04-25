@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="bg-links-blue text-white rounded p-3 mb-3">
        <h2>{{ __('新規1vs1決闘（受付ページ）') }}</h2>
    </div>

    <div class="row justify-content-center">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="text-center alert-danger rounded p-3 mb-3 col-md-7Z">
                {{ session('flash_message') }}
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
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-user">主催：<a href="/user/{{$event->eventUser[0]->user_id}}">＠{{$event->eventUser[0]->user->name}}</a></div>
                            <div class="body">決闘回数：{{$event->eventDuel[0]->duel->number_of_games}}</div>
                        </div>
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
                    {{ __('試合ステータス') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="body">
                                @if($event->status == \APP\Models\Event::RECRUIT )
                                    <div class="post-user">{{ __('対戦受付中') }}</div>
                                @elseif($event->status == \APP\Models\Event::READY )
                                    <div class="post-user">{{ __('マッチング済') }}</div>
                                @elseif($event->status == \APP\Models\Event::FINISH )
                                    <div class="post-user">{{ __('対戦完了') }}</div>
                                @elseif($event->status == \APP\Models\Event::CANCEL )
                                    <div class="post-user">{{ __('対戦キャンセル') }}</div>
                                @elseif($event->status == \APP\Models\Event::INVALID )
                                    <div class="post-user">{{ __('無効試合') }}</div>
                                @endif
                                <br><br><div class="small">※必ず対戦開始前に「<a href="/site/how_to_use">1vs1決闘の使い方</a>」動画を視聴してください</div>
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
                    {{ __('プレイヤー') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="body">
                                <a href="/user/{{$event->eventUser[0]->user_id}}">＠{{$event->eventUser[0]->user->name}}</a>
                                @isset($event->eventDuel[0]->duel->duelUser->where('user_id',$event->eventUser[0]->user_id)->first()->duelUserResult)
                                    　レート：{{$event->eventDuel[0]->duel->duelUser->where('user_id',$event->eventUser[0]->user_id)->first()->duelUserResult->sum('rating')}}
                                @endisset
                                <br>
                                vs<br>
                                @isset($event->eventUser[1])
                                <a href="/user/{{$event->eventUser[1]->user_id}}">＠{{$event->eventUser[1]->user->name}}</a>
                                    @if(isset($event->eventDuel[0]->duel->duelUser->where('user_id',$event->eventUser[1]->user_id)->first()->duelUserResult))
                                        　レート：{{$event->eventDuel[0]->duel->duelUser->where('user_id',$event->eventUser[1]->user_id)->first()->duelUserResult->sum('rating')}}
                                    @endif
                                @endisset
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-5">
                            @if($event->user_id <> Auth::id() && $event->status == \APP\Models\Event::RECRUIT)
                                <form method="POST" action="/event/user">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{$event->id}}">
                                    <input type="hidden" name="duel_id" value="{{$event->eventDuel[0]->duel->id}}">
                                    <button type="submit" class="btn btn-primary">
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
                            <div class="post-user">{{date('Y/m/d H:i', strtotime($event->date.' '.$event->time))}}</div> ※対戦開始日時になったら決闘ページへ移動してください
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
                    {{ __('対戦前掲示板') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-user">{{$post->title}} [{{$post->created_at}}]</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div type="body">{!! nl2br(e($post->body)) !!}</div>
                        </div>
                    </div>
                </div>

            @if(!empty($comments))
                <div class="card  pb-2">
                    <div class="card-header">{{ __('コメント一覧') }}</div>
                    <div class="card-body">
                        @foreach($comments as $comment)
                            <div class="col-md-12">
                                <div class="post-user">＠{{$comment->user->name}} [{{$comment->created_at}}]</div>
                            </div>
                            <div class="card-text border-bottom p-2">
                                {!! nl2br(e($comment->body)) !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

                {{$comments->links('pagination::bootstrap-4')}}
                <div class="card-header">
                    {{ __('コメントを投稿する' )}}
                </div>
                <div class="card-body">
                    <form method="POST" action="/post/comment">
                        @csrf
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input type="hidden" name="event_id" value="{{$event->id}}">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea id="body" type="body" class="form-control @error('body') is-invalid @enderror" name="body" value="{{ old('body') }}" required autocomplete="body"></textarea>

                                @error('body')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('投稿') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
