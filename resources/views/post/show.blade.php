@extends('layouts.common.common')

@section('title','掲示板')

@section('description')
  <meta name="description" content="ポケモンカードの掲示板です。雑談・デッキ相談・ルール質問まで幅広い交流を行いましょう。"/>
@endsection

@section('addCss')
  @vite(['resources/scss/post/post-show.scss'])
@endsection

@section('addJs')
  @vite('resources/js/post/DeckPreview.tsx')
@endsection

@section('twitterHeader')
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@pokekaInfo" />
  <meta name="twitter:title" content="ポケカ掲示板" />
  <meta name="twitter:description" content="ポケカのデッキ相談・ルール質問・雑談などを掲示板で話しましょう！" />
  @if($post->imageUrl)
    <meta name="twitter:image" content="https://www.pokemon-card.com/deck/deckView.php/deckID/{{$post->imageUrl}}" />
  @else
    <meta name="twitter:image" content="{{env('APP_URL')}}/images/post/twitter_thumb.png" />
  @endif
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
      <!-- フラッシュメッセージ -->
      @if (session('flash_message'))
        <div class="text-center alert-danger rounded p-3 mb-3 col-md-10">
          {{ session('flash_message') }}
        </div>
      @endif
    </div>
    <section>
      @include('layouts.post.post_latest')
    </section>
    <section>
      @include('layouts.blog.latest')
    </section>
    <section>
      @include('layouts.common.line')
    </section>
    <section>
      @include('layouts.post.post_and_comment')
    </section>
    <section>
      @include('layouts.common.line')
    </section>
    <section>
      @include('layouts.post.post_latest')
    </section>
    <section>
      @include('layouts.blog.latest')
    </section>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
