@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのブログ記事一覧です。最新情報から歴代パックや値段相場までまとめています。"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/item/show.css') }}">
@endsection

@section('twitterHeader')
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@pokekaInfo" />
  <meta name="twitter:title" content="ポケカ掲示板" />
  <meta name="twitter:description" content="ポケカのデッキ相談・ルール質問・雑談などを掲示板で話しましょう！" />
  <meta name="twitter:image" content="{!! $item->image_url !!}" />
@endsection

@section('content')
<div class="container">

  <div id="cart" class="cart text-center" onclick="location.href='/item/cart'">
    <div id="cart-image">
      <div id="cart-number" class="text-center">
        @if(Auth::check())
          {{ Auth::user()->carts->sum('quantity') }}
        @else
          @if(isset(session('carts')['quantity']))
            {{ array_sum(session('cart_number')) }}
          @else
            0
          @endif
        @endif
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-12">
        <div class="text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
        </div>
      </div>
    @endif
  </div>

  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('商品詳細') }}
    </div>
  </div>

  <div class="box mb-2">
    <div class="row justify-content-center mb-4">
      <div class="col-sm-12">
          <h3 class="text-left">{{$item->name}}</h3>
        </div>
    </div>

    <div class="row justify-content-center p-2">
      <div class="col-sm-6 p-1">
        <img class="img-fluid" src="{{ $item->image_url }}" alt="hashimu-icon">
      </div>
      <div class="col-sm-6 p-2">
        <div class="row justify-content-center mb-2">
          <div class="col-4 text-right">値段</div>
          <div class="col-8">{{number_format($item->price)}}円</div>
        </div>
        <div class="row justify-content-center visible_{{$item->id}} mb-2">
          <div class="col-4 text-right">在庫</div>
          <div class="col-8">{{$item->quantity}}個</div>
        </div>
        <div class="row justify-content-center visible_{{$item->id}} mb-2">
          <div class="col-4 text-right">購入</div>
          <div class="col-8">
            <select id="quantity_{{$item->id}}" name="quantity">
              @for($i=1; $i <= $item->quantity; $i++)
                <option value="{{$i}}" @if($i == old('quantity',1)) selected @endif>{{$i}}</option>
              @endfor
            </select>
            個
          </div>
        </div>
        <div class="row justify-content-center visible_{{$item->id}} p-1 mb-2">
          <div class="text-center">
            <button type=“submit” id="cart_{{$item->id}}" class="btn cart_btn site-color text-white btn-outline-secondary text-center">カートに追加する</button>
          </div>
        </div>
        <div class="after_visible_{{$item->id}}"></div>
        <div class="row justify-content-start p-3">
          <div type="body" class="blog-body text-left">{!! $item->body !!}</div>
        </div>
      </div>
    </div>

  </div>

  <div class="box">
    <div class="row justify-content-center mb-4">
      <div class="col-md-12">
        <button class="btn bg-secondary text-white w-50" onClick="history.back()">戻る</button>
      </div>
    </div>
    @if(Auth::check() && Auth::user()->role == \App\Models\User::ROLE_ADMIN)
      <div class="row justify-content-center pb-3">
        <div class="col-md-12">
          <button type="submit" class="btn bg-primary text-white w-50" onclick="location.href='/item/{{$item->id}}/stock/create'">在庫追加する</button>
        </div>
      </div>

      <div class="row justify-content-center pb-3">
        <div class="col-md-12">
          <button type="submit" class="btn bg-primary text-white w-50" onclick="location.href='/item/{{$item->id}}/edit'">編集する</button>
        </div>
      </div>

    @endif
  </div>


</div>

@endsection

@section('addScript')
  <script src="/js/item/index.js"></script>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
