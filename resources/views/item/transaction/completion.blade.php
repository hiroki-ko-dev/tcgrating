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
      <div class="col-12 page-header">
        <div class="d-flex flex-row mb-3">
          <div>
            {{ __('購入完了画面') }}
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center m-1 mb-3">
      <div class="col-12">
        <div class="d-flex flex-row mb-3">
          <div>
            {{ __('購入が完了しました') }}
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
