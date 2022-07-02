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
  <div id="cart" class="cart text-center" onclick="location.href='/item/cart'">
    <div id="cart-image">
      <div id="cart-number" class="text-center">{{Auth::user()->carts->sum('quantity')}}</div>
    </div>
  </div>

  <div class="row justify-content-center m-1 mb-3">
    <div class="col-sm-6 mb-2">
      <h5>{{ __('商品一覧') }}</h5>
    </div>
    <div class="col-sm-6">
      <!-- チーム募集掲示板はチームページから掲示板を作成させる -->
      @if(Auth::user()->role == \App\Models\User::ROLE_ADMIN)
        <btton class="btn site-color text-white btn-outline-secondary text-center w-100"
               onclick="location.href='/item/create'">
          {{ __('+ 商品の追加') }}
        </btton>
      @endif
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

  @if(!empty($items))
    <div class="row">
    @foreach($items as $i => $item)
      <input type="hidden" id="item_id_{{$item->id}}" name="item_id" value="{{$item->id}}">
      <div class="col-sm-3 col-6 p-1">
        <div class="box">
          <div class="site-color text-white p-1">
            <span class="item-name">{{$item->name}}</span>
          </div>
          <div class="p-1">
            ¥{{number_format($item->price)}}円
          </div>
          <div class="p-1">
            <div>在庫数：{{$item->quantity}}個</div>
          </div>
          <div class="p-1 after_visible_{{$item->id}}">
            <div class="visible_{{$item->id}}">
              <select id="quantity_{{$item->id}}" name="quantity">
                @for($i=1; $i <= $item->quantity; $i++)
                  <option value="{{$i}}" @if($i == old('quantity')) selected @endif>{{$i}}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="p-1">
            <button id="cart_{{$item->id}}" class="btn bg-primary text-white cart_btn visible_{{$item->id}}">カートに追加</button>
          </div>
          <div class="item-image">
            <img class="img-fluid" src="{{$item->image_url}}" width="" alt="{{$item->name}}">
          </div>
      </div>
    </div>
    @endforeach
    </div>
  @endif

{{--  <div class="content">--}}
{{--    <form action="/item/charge" method="POST">--}}
{{--      @csrf--}}
{{--      <script--}}
{{--        src="https://checkout.stripe.com/checkout.js" class="stripe-button"--}}
{{--        data-key="{{ config('assets.common.stripe.pk_key') }}"--}}
{{--        data-amount="10000"--}}
{{--        data-name="Stripe Demo"--}}
{{--        data-label="決済をする"--}}
{{--        data-description="Online course about integrating Stripe"--}}
{{--        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"--}}
{{--        data-locale="auto"--}}
{{--        data-currency="JPY">--}}
{{--      </script>--}}
{{--    </form>--}}
{{--  </div>--}}

  {{$items->links('layouts.common.pagination.bootstrap-4')}}
</div>

@endsection

@section('addScript')
  <script src="/js/item/index.js"></script>
@endsection



@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
