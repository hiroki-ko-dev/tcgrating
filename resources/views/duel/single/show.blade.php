@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="bg-links-blue text-white rounded p-3 mb-3">
        <h2>{{ __('1vs1決闘(決闘ページ)') }}</h2>
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
                    {{ __('対戦開始時間') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-body">{{date('Y/m/d H:i', strtotime($duel->eventDuel->event->date.' '.$duel->eventDuel->event->time))}}</div>
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
                    {{ __('ルームID') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-body">{{$duel->room_id}}</div>
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
                    {{ __('決闘詳細') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-user"> ＠{{$duel->duelUser[0]->user->name}} vs ＠@if(isset($duel->duelUser[1])){{$duel->duelUser[1]->user->name}}@else対戦相手待ち@endif</div>
                            @if($duel->number_of_games < $duel->games_number)
                                <div class="body">対戦回数：{{$duel->number_of_games}}　※決闘終了です。お疲れ様でした</div>
                            @else
                                <div class="body">対戦回数：{{$duel->number_of_games}}　（現在{{ $duel->games_number }}試合目）※試合を開始してページ下部で結果を報告してください</div>
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
                    {{ __('対戦掲示板') }}
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
                        <input type="hidden" name="event_id" value="{{$duel->id}}">
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
                                <a href="/reload">　　返信を確認</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $duel->games_number }} {{ __('試合目　ー　対戦結果報告') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            {{ __('※お互いの報告結果が違うと無効試合となります。注意してください') }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <form method="POST" action="/duel">
                                @csrf
                                <input type="hidden" name="duel_id" value="{{$duel->id}}">
                                <span class="col-md-3 ">
                                    <button type="submit" class="btn btn-primary" name="win" value="1">
                                        {{ __('　勝利　') }}
                                    </button>
                                </span>
                                <span class="col-md-7">
                                    <button type="submit" class="btn btn-danger" name="lose" value="1">
                                        {{ __('　敗北　') }}
                                    </button>
                                </span>
                                <span class="col-md-7">
                                    <button type="submit" class="btn btn-secondary" name="draw" value="1">
                                        {{ __('　ドロー') }}
                                    </button>
                                </span>
                                <span class="col-md-10">
                                    <button type="submit" class="btn btn-secondary" name="invalid" value="1">
                                        {{ __('無効試合') }}
                                    </button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.adsense')
@include('layouts.common.footer')
