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
                    {{ __('決闘詳細') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-user"> ＠{{$duel->duelUser[0]->user->name}} vs ＠{{$duel->duelUser[0]->user->name}}</div>
                            <div class="body">対戦回数：{{$duel->number_of_games}}</div>
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
                                <a href="/reload">　　更新</a>
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
                    {{ __('対戦結果報告') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <span class="col-md-3 ">
                                <button type="submit" class="btn btn-primary" name="win">
                                    {{ __('　勝利　') }}
                                </button>
                            </span>
                            <span class="col-md-7">
                                <button type="submit" class="btn btn-primary" name="lose">
                                    {{ __('　敗北　') }}
                                </button>
                            </span>
                            <span class="col-md-10">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('無効試合') }}
                                </button>
                            </span>
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
