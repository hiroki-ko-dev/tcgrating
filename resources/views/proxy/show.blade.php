@extends('layouts.common.common')

@section('title','プロキシ作成')

@section('description')
  <meta name="description" content="ポケモンカードのプロキシ作成を行うことができます。画像URLをセットして、印刷を行いましょう。"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/proxy/proxy.css') }}">
@endsection

@section('addJs')
  <script src="{{mix('/js/proxy/proxy.js')}}" defer></script>
@endsection

@section('content')
  {{--メタタグ--}}
  <meta name="description" content="ポケモンカードのプロキシ作成ページです。ポケカのプロキシ作成を行う方は画像URLを入力して印刷してください"/>
  <div class="container">
    <div class="row justify-content-center m-1 mb-3">
      <div class="col-12 page-header">
        {{ __('プロキシ作成') }}
      </div>
    </div>

    <div class="row justify-content-center pt-10 pb-3">
      <div class="col-12">
        <div class="box">
          <form action="/proxy/pdf" method="post">
            @csrf
            <div id="root"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
