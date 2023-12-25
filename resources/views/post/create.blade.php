@extends('layouts.common.common')

@section('title','掲示板')

@section('description')
  <meta name="description" content="ポケモンカードの掲示板です。雑談・デッキ相談・ルール質問まで幅広い交流を行いましょう。"/>
@endsection

@section('addJs')
  @vite('resources/js/post/DeckPreview.tsx')
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
        @if(\App\Models\PostCategory::CATEGORY_FREE == $post_category_id)
            {{ __('新規スレッド作成') }}
        @elseif(\App\Models\PostCategory::CATEGORY_TEAM_WANTED == $post_category_id)
            {{ __('チーム募集掲示板') }}
        @endif
    </div>
  </div>

  <div class="col-md-12">
    <div>
      <form method="POST" action="/posts">
        @csrf
        <input type="hidden" name="post_category_id" value="{{$post_category_id}}">
        <input type="hidden" name="team_id" value="{{$team_id}}">
        <div class="row pb-4">
          <input id="title" type="text" placeholder="タイトルを入力" class="form-control w-100 @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
          @error('title') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="row pb-4">
          <textarea id="body" type="body" placeholder="本文を書く" class="form-control @error('body') is-invalid @enderror" name="body" value="{{ old('body') }}" required autocomplete="body"
            style="height: 150px"></textarea>
          @error('body') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="row pb-4">
          <input id="image_url" type="text" placeholder="デッキ相談の場合はデッキコードを書く（省略可）" class="form-control w-100 @error('image_url') is-invalid @enderror" name="image_url" value="{{ old('image_url') }}" >

          @error('image_url')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

        <div class="form-group row">
          <input type="hidden" id="deckUrl" value="https://www.pokemon-card.com/deck/deckView.php/deckID/">
          <div id="target-component"></div>
        </div>

        <div class="row pb-4">
          <select name="sub_category_id" class="form-control mb-4">
            @foreach(\App\Models\Post::SUB_CATEGORY as $key => $subCategory)
              <option value="{{$key}}">カテゴリ：{{\App\Models\Post::SUB_CATEGORY[$key]}}</option>
            @endforeach
          </select>
        </div>

        @if(Auth::check() && Auth::user()->role == \App\Models\User::ROLE_ADMIN)
          <div class="form-group row">
            <select name="user_id" class="form-control">
              @foreach(config('assets.account.sakura') as $key => $name)
                <option value="{{$key}}"
                  @if(old('tool_id'))
                    selected
                  @endif
                >{{$name}}</option>
              @endforeach
            </select>
          </div>
        @endif

        <div class="row justify-content-center">
          <button class="btn bg-secondary text-white w-40 mr-2" onClick="history.back()">戻る</button>
          <button type="submit" class="btn site-color btn-outline-secondary text-light w-40" onClick="return requestConfirm();">
              {{ __('投稿') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
