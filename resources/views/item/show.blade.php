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
  <meta name="twitter:image" content="{!! $item->image_url !!}" />
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
      {{ __('商品詳細') }}
    </div>
  </div>

  <div class="row justify-content-center border-bottom p-2">
    <div class="col-sm-12">
      <img class="thumbnail" src="{{ $item->image_url }}" alt="hashimu-icon">
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-sm-12">
      <div class="box">
        <h3 class="text-left">{{$item->name}}</h3>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-sm-12">
      <div class="box">
        <div class="blog-body">
          <div type="body" class="text-left">{!! $item->body !!}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-sm-12">
      <div class="box">
        <div class="text-left">{{$item->price}}円</div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-sm-12">
      <div class="box">
        <div class="text-left">{{$item->amount}}個</div>
      </div>
    </div>
  </div>


  <div class="row justify-content-center mb-4">
    <div class="col-sm-12">
      <div class="box">
          <button type=“button”  class="btn site-color text-white rounded-pill btn-outline-secondary text-center" onclick="location.href='/item/{{$item->id}}/edit'">カートに追加する</button>
      </div>
    </div>
  </div>
</div>


@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
