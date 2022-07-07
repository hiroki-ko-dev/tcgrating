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

    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="box">
          <div class="card-text border-bottom p-2">
            <table id="cart_table" class="table">
              <thead>
              <tr>
                <th scope="col" class="w-10">商品画像</th>
                <th scope="col" class="w-30">商品名</th>
                <th scope="col" class="w-10 text-left">販売価格</th>
                <th scope="col" class="w-10">数量</th>
                <th scope="col" class="w-10">小計</th>
              </tr>
              </thead>
              <tbody>
              @foreach($carts as $i => $cart)
                <tr>
                  <td scope="col" class="align-middle">
                    <img class="img-fluid" src="{{ $cart->item->image_url }}" alt="hashimu-icon">
                  </td>
                  <td scope="col" class="align-middle">
                    {{ $cart->item->name }}
                  </td>
                  <td scope="col" class="priceCol price align-middle">
                    {{ $cart->item->price }}
                  </td>
                  <td scope="col" class="quantityCol align-middle">
                    {{$cart->quantity}}
                  </td>
                  <td scope="col" class="subtotalCol subtotal align-middle">
                    {{ $cart->item->price * $cart->quantity }}
                  </td>
                </tr>
              @endforeach
              <tr>
                <td colspan="4" class="text-right">合計金額：</td>
                <td id="total_price">{{$totalPrice}}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="box mb-3">
      <div class="row justify-content-center">
        <h5>クレジットカード情報</h5>
      </div>

      <section class="payment">
        <div id="creditcard">

          <div class="row justify-content-center p-1">
            <div class="col-sm-6">
              <span id="card-number" class="form-control">
                      <!-- Stripe Card Element -->
              </span>
            </div>
          </div>

          <div class="row justify-content-center p-1">
            <div class="col-sm-6">
                  <span id="card-exp" class="form-control">
                    <!-- Stripe Card Expiry Element -->
                  </span>
            </div>
          </div>

          <div class="row justify-content-center p-1">
            <div class="col-sm-6">
                  <span id="card-cvc" class="form-control">
                  <!-- Stripe CVC Element -->
                  </span>
            </div>
          </div>
        </div>
      </section>
    </div>

    <form method="POST"  id="payment-form" action="/item/transaction">
      @csrf

      <div class="box mb-3">
      <div class="row justify-content-center pb-3">
        <div class="col-md-12">
          <button type="submit" id="payment-form" class="btn bg-primary text-white w-50">購入を決定する</button>
        </div>
      </div>


      <div class="row justify-content-center">
        <div class="col-md-12">
          <button class="btn bg-secondary text-white w-50" onclick="location.href='/item/cart/customer'">戻る</button>
        </div>
      </div>
    </div>
    </form>

  </div>
@endsection

@section('addScript')
  <script src="https://js.stripe.com/v3/"></script>
  <script type="text/javascript">
    'use strict';

    const key = @json(config('assets.common.stripe.pk_key'));

    // Create a Stripe client
    var stripe = Stripe(key);

    // Create an instance of Elements
    var elements = stripe.elements();

    // Try to match bootstrap styling
    var style = {
      base: {
        'lineHeight': '1.35',
        'width': '100%',
        'fontSize': '1.11rem',
        'color': '#495057',
        'fontFamily': 'apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif'
      }
    };

    // Card number
    var card = elements.create('cardNumber', {
      'placeholder': 'カード番号',
      'style': style
    });
    card.mount('#card-number');

    // CVC
    var cvc = elements.create('cardCvc', {
      'placeholder': 'セキュリティコード： XXX',
      'style': style
    });
    cvc.mount('#card-cvc');

    // Card expiry
    var exp = elements.create('cardExpiry', {
      'placeholder': '有効期限： MM / YY',
      'style': style
    });
    exp.mount('#card-exp');

    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
      event.preventDefault();
      if(confirm('購入を確定してよろしいですか？')) {
        stripe.createToken(card).then(function (result) {
          if (result.error) {
            // エラー表示.
            var errorElement = document.getElementById('card-errors');
            console.log(result.error.message);
          } else {
            // トークンをサーバに送信
            stripeTokenHandler(result.token);
          }
        });
      }
    });

    function stripeTokenHandler(token) {
      // tokenをフォームへ包含し送信
      var form = document.getElementById('payment-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripe_token');
      hiddenInput.setAttribute('value', token.id);
      form.appendChild(hiddenInput);

      // Submit します
      form.submit();
    }

  </script>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
