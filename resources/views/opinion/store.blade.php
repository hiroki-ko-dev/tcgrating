@extends('layouts.common.common')

@section('title','掲示板')

@section('description')
  <meta name="description" content="ポケモンカードの掲示板です。雑談・デッキ相談・ルール質問まで幅広い交流を行いましょう。"/>
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
        {{ __('意見送信') }}
    </div>
  </div>

  <div class="col-md-12">
      <div class="box w-100">
        送信が完了しました！
      </div>
  </div>
</div>

@endsection


@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
