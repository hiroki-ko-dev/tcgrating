@extends('layouts.common.common')

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/site/landing.css') }}">
@endsection

@section('content')

  <div class="container">

    <div class="box">
      <div class="row justify-content-center m-1 mb-3">
        <h2>Twitterログインをしてポケカ履歴書を作ろう！！</h2>
      </div>
      <div class="row justify-content-center m-1 mb-3">
        <div class="col-4">
        </div>
        <div class="col-4">
          <a href="/auth/twitter/login"><img class="img-fluid" src="{{ asset('/images/site/twitter/relation.png') }}" alt="hashimu-icon"></a>
        </div>
        <div class="col-4">
        </div>
      </div>
    </div>

    <div class="row justify-content-center m-1 mb-3">
      <div class="box">
        <div class="box-header text-left">{{ __('（見本）ポケカ履歴書') }}</div>
        <img class="img-fluid" src="{{ asset('/images/site/landing/resume.png') }}" alt="hashimu-icon">
      </div>
    </div>

  </div>

@endsection


@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
