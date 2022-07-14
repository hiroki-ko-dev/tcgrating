@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのブログ記事一覧です。最新情報から歴代パックや値段相場までまとめています。"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/item/cart/index.css') }}">
@endsection

@section('content')
  <div class="container">

    <div class="row justify-content-center m-1 mb-3">
      <div class="col-12 page-header">
        <div class="d-flex flex-row mb-3">
          <div>
            {{ __('カート一覧') }}
          </div>
        </div>
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


    <div class="box mb-3">
      <div class="text-right">合計金額：¥<span id="total_price">{{$transaction->price}}</span></div>
      <div class="text-right">取引日時：<span id="total_price">{{$transaction->created_at}}</span></div>
    </div>

    <div id="cart_table" class="box mb-3">
      @foreach($transaction->transactionItems as $i => $item)
        <div class="row justify-content-center pt-3 pb-3 border-bottom">
          <div class="image">
            <div class="imgCol align-middle">
              <img class="img-fluid" src="{{ $item->item->image_url }}" alt="hashimu-icon">
            </div>
          </div>
          <div class="string">
            <div class="block nameCol align-middle">
              <a href="/item/{{$item->id}}">
                {{ $item->name }}
              </a>
            </div>
            <div class="block priceCol align-middle">
              単価：￥<span class="price">{{ $item->price }}</span>
            </div>
            <div class="block quantityCol align-middle">
              個数：{{$item->quantity}}
            </div>
            <div class="block subtotalCol align-middle">
              小計：￥<span class="subtotal">{{ $item->price * $item->quantity }}</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="box">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <button class="btn bg-secondary text-white w-50" onClick="history.back()">戻る</button>
        </div>
      </div>
    </div>

  </div>
@endsection


@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
