@extends('layouts.common.common')

@section('title','掲示板')

@section('description')
  <meta name="description" content="ポケモンカードの掲示板です。雑談・デッキ相談・ルール質問まで幅広い交流を行いましょう。"/>
@endsection

@section('addCss')
<link rel="stylesheet" href="{{ mix('/css/post/show.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
        返信をする
    </div>
  </div>

  <div class="box text-left w-100 mb-2">
    @if($postComment->id == 0)
    <div class="post">
      <div class="row mb-3">
        <div class="col-md-12 mb-1">
          <div class="font-weight-bold">{{$postComment->post->title}}</div>
        </div>
      </div>
      <div class="row m-1">
          <div class="post-user">1. [{{$postComment->post->created_at}}]</div>
      </div>
      <div class="row mb-3">
        <div class="col-md-12 mb-1">
          <img src="{{$postComment->post->user->twitter_simple_image_url}}" class="rounded-circle">
          <a class="font-weight-bold" href="/user/{{$postComment->post->user_id}}">{{$postComment->post->user->name}}</a>
        </div>
      </div>

      @if(!empty($postComment->post->image_url))
        <div class="form-group row mt-2">
          <div class="col-12">
            デッキコード：<a href="https://www.pokemon-card.com/deck/confirm.html/deckID/{{$postComment->image_url}}">{{$postComment->image_url}}</a>
          </div>
        </div>
        <div class="row m-1 mb-3">
            <img class="img-fluid" src="https://www.pokemon-card.com/deck/deckView.php/deckID/{{$postComment->post->image_url}}" alt="{{$postComment->post->title}}">
        </div>
      @endif

      <div class="row m-1 mb-3">
        <div class="post-text">{!! nl2br(e($postComment->post->body)) !!}</div>
      </div>

      @if($postComment->post->postComments->where('referral_id',0)->whereNotNull('referral_id')->count() > 0)
        <div class="row mt-2 pb-2">
          <div class="bg-pink p-1 ml-3 font-weight-bold text-redPurple">
            <a href="/post/comment/create?post_id={{$postComment->post->id}}" class="text-redPurple">{{$postComment->post->postComments->where('referral_id',0)->whereNotNull('referral_id')->count()}}件の返信</a>
          </div>
        </div>
      @endif

    </div>
    @else
      <div class="comment pt-2">
        <div class="row m-1">
          <div class="post-user">{{$postComment->number}}. [{{$postComment->created_at}}]</div>
        </div>
        <div class="row mb-3">
          <div class="col-md-12 mb-1">
            <img src="{{$postComment->user->twitter_simple_image_url}}" class="rounded-circle">
            <a class="font-weight-bold" href="/user/{{$postComment->user_id}}">{{$postComment->user->name}}</a>
          </div>
        </div>

        @if(!empty($postComment->image_url))
          <div class="form-group row mt-2">
            <div class="col-12">
              デッキコード：{{$postComment->image_url}}
            </div>
          </div>
          <div class="row m-1 mb-3">
            <img class="img-fluid" src="https://www.pokemon-card.com/deck/deckView.php/deckID/{{$postComment->image_url}}" alt="{{$postComment->post->title}}">
          </div>
        @endif

        @if(!is_null($postComment->referral_id))
          <div class="row">
            <div class="bg-skyblue p-1 ml-3 font-weight-bold text-primary">
              @if($postComment->referral_id === 0)
                <a href="/post/comment/create?post_id={{$postComment->post->id}}">>>1</a>
              @elseif($postComment->referral_id > 0)
                <a href="/post/comment/create?comment_id={{$postComment->referralComment->id}}">>>{{$postComment->referralComment->number}}</a>
              @endif
            </div>
          </div>
        @endif
        <div class="row m-1 mb-3">
          <div class="post-text">{!! nl2br(e($postComment->body)) !!}</div>
        </div>

        @if($postComment->replyComments->count() > 0)
          <div class="row mt-2 pb-2">
            <div class="bg-pink p-1 ml-3 font-weight-bold">
              <a href="/post/comment/create?comment_id={{$postComment->id}}" class="text-redPurple">{{$postComment->replyComments->count()}}件の返信</a>
            </div>
          </div>
        @endif

      </div>
    @endif
  </div>

  <div class="box text-left w-100">
    <form method="POST" action="/post/comment">
      @csrf
      <input type="hidden" name="post_id" value="{{ $postComment->post->id }}" >
      @if($postComment->id == 0)
        <div class="row">
          <div class="card-header p-2 w-100">{{$postComment->post->user->name}}さんに返信する</div>
        </div>
        <div class="row p-1 pl-2">
          <input type="hidden" name="referral_id" value="0">
          <div class="font-weight-bold">>>1</div>
        </div>
      @else
        <div class="row">
          <div class="card-header p-2 w-100">{{$postComment->user->name}}さんに返信する</div>
        </div>
        <div class="row p-1 pl-2">
          <input type="hidden" name="referral_id" value="{{ $postComment->id }}" >
          <div class="font-weight-bold">>>{{$postComment->number}}</div>
        </div>
      @endif
      <div class="row pb-4">
          <textarea id="body" type="body" placeholder="返信文を書く" class="form-control @error('body') is-invalid @enderror" name="body" value="{{ old('body') }}" required autocomplete="body"
          style="height: 150px"></textarea>
          @error('body') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
      </div>
      <div class="row pb-4">
          <input id="image_url" type="text" placeholder="デッキコードを書く（省略可）" class="form-control w-100 @error('image_url') is-invalid @enderror" name="image_url" value="{{ old('image_url') }}" >

          @error('image_url')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
      </div>
      @if(Auth::check() && Auth::user()->role == \App\Models\User::ROLE_ADMIN)
        <div class="form-group row">
          <select name="user_id" class="form-control">
            @foreach(config('assets.account.sakura') as $key => $name)
              <option value="{{$key}}"
                      @if(old('user_id'))
                      selected
                @endif
              >{{$name}}</option>
            @endforeach
          </select>
        </div>
      @endif

      <div class="row justify-content-center">
        <div class="col-12">
          <button type="submit" class="btn btn-dark w-100" onClick="return requestConfirm();">
            {{ __('返信する') }}
          </button>
        </div>
        <div class="col-12 pt-3 text-center">
          <button type="button" class="btn btn-secondary w-100" onClick="history.back()">戻る</button>
        </div>
      </div>
    </form>
  </div>

  <div class="box text-left w-100 mb-2">
  @foreach($postComment->replyComments as $replyComment)
      <div class="comment border-top pt-2">
        <div class="row m-1">
          <span class="post-user">{{$replyComment->number}}. [{{$replyComment->created_at}}]</span>
          <a href="/post/comment/create?comment_id={{$replyComment->id}}">返信する</a>
        </div>
        <div class="row mb-3">
          <div class="col-md-12">
            <img src="{{$replyComment->user->twitter_simple_image_url}}" class="rounded-circle">
            <a class="font-weight-bold" href="/user/{{$replyComment->user_id}}">{{$replyComment->user->name}}</a>
          </div>
        </div>

        @if(!empty($replyComment->image_url))
          <div class="form-group row mt-2">
            <div class="col-12">
              デッキコード：<a href="https://www.pokemon-card.com/deck/confirm.html/deckID/{{$replyComment->image_url}}">{{$replyComment->image_url}}</a>
            </div>
          </div>
          <div class="row m-1 mb-3">
            <img class="img-fluid" src="https://www.pokemon-card.com/deck/deckView.php/deckID/{{$replyComment->image_url}}" alt="{{$replyComment->post->title}}">
          </div>
        @endif

        <div class="row">
          <div class="bg-skyblue p-1 ml-3 font-weight-bold text-primary">
            @if($replyComment->referral_id == 0)
              <a href="/post/comment/create?post_id={{$replyComment->post->id}}">>>1</a>
            @else
              <a href="/post/comment/create?comment_id={{$replyComment->referralComment->id}}">>>{{$replyComment->referralComment->number}}</a>
            @endif
          </div>
        </div>
        <div class="row m-1 mb-3">
          <div class="post-text">{!! nl2br(e($replyComment->body)) !!}</div>
        </div>

        @if($replyComment->replyComments->count() > 0)
          <div class="row mt-2 pb-2">
            <div class="bg-pink p-1 ml-3 font-weight-bold">
              <a href="/post/comment/create?comment_id={{$replyComment->id}}" class="text-redPurple">{{$replyComment->replyComments->count()}}件の返信</a>
            </div>
          </div>
        @endif
      </div>
  @endforeach
  </div>

</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
