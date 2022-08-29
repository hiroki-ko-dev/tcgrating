@extends('layouts.common.common')

@section('title','掲示板')

@section('description')
  <meta name="description" content="ポケモンカードの掲示板です。雑談・デッキ相談・ルール質問まで幅広い交流を行いましょう。"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/item/transaction/index.css') }}">
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
    <div class="box mb-5">
      <div class="row head pl-2 pb-3 text-left">
        <div class="col-sm-2">
          ID:{{ $transaction->id }}
        </div>
        <div class="col-sm-4">
          注文日時：{{ $transaction->created_at }}
        </div>
        <div class="col-sm-3">
          {{ \App\Models\Transaction::SEND_STATUSES[$transaction->send_status] }}
        </div>
        <div class="col-sm-3">
          @if($transaction->send_status == \App\Models\Transaction::SEND_STATUS_BEFORE_SENDING)
            <form method="POST"  id="payment-form" action="/item/transaction/{{$transaction->id}}">
              @csrf
              @method('PUT')
              <input type="hidden" name="send_status" value="{{\App\Models\Transaction::SEND_STATUS_AFTER_SENDING}}">
              <button type="submit" class="btn bg-primary text-white" onClick="return requestConfirm();">送付完了</button>
            </form>
          @endif
        </div>
      </div>
      <div class="row content p-3 pl-2  text-left">
        <div class="col-sm-2">
          商品金額：￥{{ number_format($transaction->price) }}
        </div>
        <div class="col-sm-2">
          送料：￥{{ number_format($transaction->postage) }}
        </div>
        <div class="col-sm-2">
          合計額：￥{{ number_format($transaction->price + $transaction->postage) }}
        </div>
        <div class="col-sm-6">
          <a href="/item/transaction/{{$transaction->id}}">詳細を見る</a>
        </div>
      </div>
    </div>
  @endforeach

  {{$transactions->links('layouts.common.pagination.bootstrap-4')}}

  <div class="row justify-content-center">
    <button class="btn bg-secondary text-white w-50" onClick="history.back()">戻る</button>
  </div>

</div>

@endsection

@section('addScript')
  <script src="/js/item/index.js"></script>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
