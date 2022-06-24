@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのブログ記事一覧です。最新情報から歴代パックや値段相場までまとめています。"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/blog/show.css') }}">
@endsection

@section('twitterHeader')
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@pokekaInfo" />
  <meta name="twitter:title" content="ポケカ掲示板" />
  <meta name="twitter:description" content="ポケカのデッキ相談・ルール質問・雑談などを掲示板で話しましょう！" />
  <meta name="twitter:image" content="{{env('APP_URL')}}/images/post/twitter_thumb.png" />
@endsection

@section('content')
<div class="container">

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-12">
        <div class="text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
        </div>
      </div>
    @endif
  </div>

  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('記事') }}
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-sm-12">
      <div class="box">
        <h3 class="text-left">{{$blog->title}}</h3>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-sm-12">
      <div class="box">
        <div class="blog-body">
          <div type="body" class="text-left">{!! $blog->body !!}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-6">
      <div class="box">
        <div class="row justify-content-center mb-4 site-color text-white">
          前の記事
        </div>
        @if($preview)
          <a href="/blog/{{$preview->id}}">
            <div class="row justify-content-center mb-4">
            {{$preview->title}}
            </div>
            <div class="row justify-content-center mb-4">
              <img class="thumbnail" src="{{ $preview->thumbnail_image_url }}" alt="hashimu-icon">
            </div>
          </a>
        @else
          <div class="row justify-content-center mb-4">
            記事がありません
          </div>
        @endif
      </div>
    </div>
    <div class="col-6">
      <div class="box">
        <div class="row justify-content-center mb-4 site-color text-white"">
          次の記事
        </div>
        @if($next)
          <a href="/blog/{{$next->id}}">
            <div class="row justify-content-center mb-4">
              <a href="/blog/{{$next->id}}">{{$next->title}}</a>
            </div>
            <div class="row justify-content-center mb-4">
              <img class="thumbnail" src="{{ $next->thumbnail_image_url }}" alt="hashimu-icon">
            </div>
          </a>
        @else
          <div class="row justify-content-center mb-4">
            更新中
          </div>
        @endif
      </div>
    </div>
  </div>

  @include('layouts.common.line')

    <div class="row justify-content-center mb-4">
      <div class="col-sm-12">
        <div class="box">
          @if(Auth::check() && Auth::id() == 1)
            <button type=“button”  class="btn site-color text-white rounded-pill btn-outline-secondary text-center" onclick="location.href='/blog/{{$blog->id}}/edit'">編集する</button>
          @endif
            <button type=“button”  class="btn btn-secondary text-white rounded-pill btn-outline-secondary text-center" onclick="location.href='/blog'">記事一覧へ</button>
        </div>
      </div>
    </div>

</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
