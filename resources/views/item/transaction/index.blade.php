@extends('layouts.common.common')

@section('title','掲示板')

@section('description')
  <meta name="description" content="ポケモンカードの掲示板です。雑談・デッキ相談・ルール質問まで幅広い交流を行いましょう。"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/item/index.css') }}">
@endsection

@section('content')
<div class="container">

  <div class="row justify-content-center m-1 mb-3">
    <div class="col-sm-6 mb-2">
      <h5>{{ __('購入履歴一覧') }}</h5>
    </div>
    <div class="col-sm-6">
    </div>
  </div>

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-md-12">
        <div class="text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
        </div>
      </div>
    @endif
  </div>

  @foreach($transactions as $i => $transaction)
    <div class="box" onclick="location.href='/item/transaction/{{$transaction->id}}'">
      <div class="row pt-3 pl-2 pb-3 border-bottom text-left">
        <div class="col-sm-3">
          ID:{{ $transaction->id }}
        </div>
        <div class="col-sm-3">
          金額：￥{{ $transaction->price }}
        </div>
        <div class="col-sm-3">
          送料：￥{{ $transaction->postage }}
        </div>
        <div class="col-sm-3">
          ステータス：{{ $transaction->send_status }}
        </div>
      </div>
    </div>
  @endforeach

  {{$transactions->links('layouts.common.pagination.bootstrap-4')}}
</div>

@endsection

@section('addScript')
  <script src="/js/item/index.js"></script>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
