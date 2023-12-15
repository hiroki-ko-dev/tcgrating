@extends('layouts.common.common')

@section('title','掲示板')

@section('description')
  <meta name="description" content="ポケモンカードの掲示板です。雑談・デッキ相談・ルール質問まで幅広い交流を行いましょう。"/>
@endsection

@section('addCss')
  @vite(['resources/scss/post/post-show.scss'])
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center m-1 mb-3">
      <div class="col-12 page-header">
          返信をする
      </div>
    </div>

    <div class="box text-left w-100 mb-2">
      @if($referralPost)
        <div class="post">
          <div class="row mb-3">
            <div class="col-md-12 mb-1">
              <div class="font-weight-bold">{{$referralPost->title}}</div>
            </div>
          </div>
          <div class="row m-1">
              <div class="post-user">1. [{{$referralPost->createdAt}}]</div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12 mb-1">
              <img src="{{$referralPost->user->profileImagePath}}" class="rounded-circle small-profile" onerror="this.src='{{ asset('/images/icon/default-account.png') }}'">
              @if($referralPost->user->id)
                <span class="post-user"><a class="font-weight-bold" href="/resume/{{$referralPost->user->id}}">{{$referralPost->user->name}}</a></span>
              @else
                <span class="post-user">{{$referralPost->user->name}}</span>
              @endif
            </div>
          </div>

          @if(!empty($referralPost->imageUrl))
            <div class="form-group row mt-2">
              <div class="col-12">
                <span class="post-text">デッキコード：<a href="https://www.pokemon-card.com/deck/confirm.html/deckID/{{$referralPost->imageUrl}}">{{$referralPost->imageUrl}}</a></span>
              </div>
            </div>
            <div class="row m-1 mb-3">
                <img class="img-fluid" src="https://www.pokemon-card.com/deck/deckView.php/deckID/{{$referralPost->imageUrl}}" alt="{{$referralPost->title}}">
            </div>
          @endif

          <div class="row m-1 mb-3">
            <div class="post-text">{!! nl2br(e($referralPost->body)) !!}</div>
          </div>

          @if($referralPost->replyCommentCount > 0)
            <div class="row mt-2 pb-2">
              <div class="bg-pink p-1 ml-3 font-weight-bold text-redPurple">
                <a href="/post/comment/create?post_id={{$referralPost->id}}" class="text-redPurple">{{$referralPost->replyCommentCount}}件の返信</a>
              </div>
            </div>
          @endif

        </div>
      @else
        <div class="comment pt-2">
          <div class="row m-1">
            <div class="post-user">{{$referralComment->number}}. [{{$referralComment->createdAt}}]</div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12 mb-1">
              <img src="{{$referralComment->user->profileImagePath}}" class="rounded-circle small-profile" onerror="this.src='{{ asset('/images/icon/default-account.png') }}'">
              @if($referralComment->user->id)
                <span class="post-user"><a class="font-weight-bold" href="/resume/{{$referralComment->user->id}}">{{$referralComment->user->name}}</a></span>
              @else
                <span class="post-user">{{$referralComment->user->name}}</span>
              @endif
            </div>
          </div>

          @if(!empty($referralComment->imageUrl))
            <div class="form-group row mt-2">
              <div class="col-12">
                <span class="post-text">デッキコード：<a href="https://www.pokemon-card.com/deck/confirm.html/deckID/{{$referralComment->imageUrl}}">{{$referralComment->imageUrl}}</a></span>
              </div>
            </div>
            <div class="row m-1 mb-3">
              <img class="img-fluid" src="https://www.pokemon-card.com/deck/deckView.php/deckID/{{$referralComment->imageUrl}}" alt="ポケモンカードデッキコード">
            </div>
          @endif

          @if(!is_null($referralComment->referralComment))
            <div class="row">
              <div class="bg-skyblue p-1 ml-3 font-weight-bold text-primary">
                @if($referralComment->isReferralPost)
                  <a href="/post/comment/create?post_id={{$referralPost->id}}">>>1</a>
                @elseif($referralComment->referralComment)
                  <a href="/post/comment/create?comment_id={{$referralComment->referralComment->id}}">>>{{$referralComment->referralComment->number}}</a>
                @endif
              </div>
            </div>
          @endif
          <div class="row m-1 mb-3">
            <div class="post-text">{!! nl2br(e($referralComment->body)) !!}</div>
          </div>

          @if($referralComment->replyCommentCount > 0)
            <div class="row mt-2 pb-2">
              <div class="bg-pink p-1 ml-3 font-weight-bold">
                <a href="/post/comment/create?comment_id={{$referralComment->id}}" class="text-redPurple">{{$referralComment->replyCommentCount}}件の返信</a>
              </div>
            </div>
          @endif

        </div>
      @endif
    </div>

    @if($replyComments)
      <div class="box text-left w-100 mb-2">
        <div class="sub-title">他の返信一覧</div>
        @foreach($replyComments as $replyComment)
          <div class="comment border-top pt-2">
            <div class="row m-1">
              <span class="post-user">{{$replyComment->number}}. [{{$replyComment->createdAt}}]</span>
              <a href="/post/comment/create?comment_id={{$replyComment->id}}">返信する</a>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <img src="{{$replyComment->user->profileImagePath}}" class="rounded-circle small-profile" onerror="this.src='{{ asset('/images/icon/default-account.png') }}'">
                <span class="post-user"><a class="font-weight-bold" href="/resume/{{$replyComment->user->id}}">{{$replyComment->user->name}}</a></span>
              </div>
            </div>

            @if(!empty($replyComment->imageUrl))
              <div class="form-group row mt-2">
                <div class="col-12">
                  デッキコード：<a href="https://www.pokemon-card.com/deck/confirm.html/deckID/{{$replyComment->imageUrl}}">{{$replyComment->imageUrl}}</a>
                </div>
              </div>
              <div class="row m-1 mb-3">
                <img class="img-fluid" src="https://www.pokemon-card.com/deck/deckView.php/deckID/{{$replyComment->imageUrl}}" alt="ポケモンカードデッキ診断">
              </div>
            @endif

            <div class="row">
              <div class="bg-skyblue p-1 ml-3 font-weight-bold text-primary">
                @if($referralPost)
                  <a href="/post/comment/create?post_id={{$referralPost->id}}">>>1</a>
                @else
                  <a href="/post/comment/create?comment_id={{$referralComment->id}}">>>{{$referralComment->number}}</a>
                @endif
              </div>
            </div>
            <div class="row m-1 mb-3">
              <div class="post-text">{!! nl2br(e($replyComment->body)) !!}</div>
            </div>

            @if($replyComment->replyCommentCount > 0)
              <div class="row mt-2 pb-2">
                <div class="bg-pink p-1 ml-3 font-weight-bold">
                  <a href="/post/comment/create?comment_id={{$replyComment->id}}" class="text-redPurple">{{$replyComment->replyCommentCount}}件の返信</a>
                </div>
              </div>
            @endif
          </div>
        @endforeach
      </div>
    @endif

    <div class="box text-left w-100">
      <form method="POST" action="/post/comment">
        @csrf
        @if($referralPost)
          <input type="hidden" name="post_id" value="{{ $referralPost->id }}" >
          <div class="row">
            <div class="card-header p-2 w-100">{{$referralPost->user->name}}さんに返信する</div>
          </div>
          <div class="row p-1 pl-2">
            <input type="hidden" name="referral_id" value="0">
            <div class="font-weight-bold">>>1</div>
          </div>
        @else
          <input type="hidden" name="post_id" value="{{ $referralComment->postId }}" >
          <div class="row">
            <div class="card-header p-2 w-100">{{$referralComment->user->name}}さんに返信する</div>
          </div>
          <div class="row p-1 pl-2">
            <input type="hidden" name="referral_id" value="{{ $referralComment->id }}" >
            <div class="font-weight-bold">>>{{$referralComment->number}}</div>
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
          <div class="col-md-8 offset-md-2 text-center">
            <button class="btn bg-secondary text-white w-40 mr-2" onClick="history.back()">戻る</button>
            <button type="submit" class="btn site-color btn-outline-secondary text-light w-40" onClick="return requestConfirm();">
                {{ __('投稿') }}
            </button>
          </div>
        </div>
      </form>
    </div>

  </div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
