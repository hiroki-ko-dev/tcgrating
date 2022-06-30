@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのブログ記事一覧です。最新情報から歴代パックや値段相場までまとめています。"/>
@endsection

@section('addCss')
  {{--  <link rel="stylesheet" href="{{ mix('/css/cart/index.css') }}">--}}
@endsection

@section('content')
  <div class="container">

    <div class="row justify-content-center m-1 mb-3">
      <div class="col-12">
        <div class="text-center mb-3">
          <h1 class="font-weight-bold">
            {{ __('購入完了画面') }}
          </h1>
        </div>
      </div>
    </div>

    <div class="row justify-content-center m-1 mb-3">
      <div class="col-12">
        <div class="mb-3">
          <h5 class="mb-3">{{ __('購入が完了しました。') }}</h5>
          <h5 class="mb-3">{{ __('購入内容の詳細については、確認のため自動送信メールでご連絡させて頂いております。') }}</h5>
        </div>
      </div>
    </div>

  </div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
