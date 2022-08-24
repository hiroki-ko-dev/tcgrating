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

    <div id="cart_table" class="box">
      @foreach($carts as $i => $cart)
        <div class="row justify-content-center pt-3 pb-3 border-bottom">
          <div class="image">
            <div class="imgCol align-middle">
              <img class="img-fluid" src="{{ $cart->item->image_url }}" alt="hashimu-icon">
            </div>
          </div>
          <div class="string">
            <div class="block nameCol align-middle">
              <a href="/item/{{$cart->item->id}}">
                {{ $cart->item->name }}
              </a>
            </div>
            <div class="block priceCol align-middle mb-2">
              単価：￥<span class="price">{{ $cart->item->price }}</span>(税込)
            </div>
            <div class="block quantityCol align-middle mb-2">
              個数：
              <select id="quantity_{{$cart->id}}" name="quantity" class="quantity" data-id="{{$cart->id}}">
                @for($i=1; $i <= $cart->item->quantity; $i++)
                  <option value="{{$i}}" @if($i == old('quantity',$cart->quantity)) selected @endif>{{$i}}</option>
                @endfor
              </select>
            </div>
            <div class="block subtotalCol align-middle mb-2">
              小計：￥<span class="subtotal">{{ $cart->item->price * $cart->quantity }}</span>(税込)
            </div>
            <div class="block deleteCol align-middle mb-2">
              <button class="delete btn bg-secondary text-white" data-id="{{$cart->id}}">削除</button>
            </div>
          </div>
        </div>
      @endforeach
      <div class="p-2">
        <div class="text-right">合計金額：¥<span id="total_price">0</span>(税込)</div>
      </div>
    </div>

    @if($carts->isNotEmpty())
      <div class="box">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="box">
              <button class="btn bg-primary text-white w-50" onclick="location.href='/item/transaction/customer'">レジに進む</button>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="box">
              <button class="btn bg-secondary text-white w-50" onClick="history.back()">戻る</button>
            </div>
          </div>
        </div>
      </div>
    @endif

  </div>
@endsection

@section('addScript')
  <script src="/js/item/cart/index.js"></script>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
