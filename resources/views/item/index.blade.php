@extends('layouts.common.common')

@section('title','掲示板')

@section('description')
  <meta name="description" content="ポケモンカードの掲示板です。雑談・デッキ相談・ルール質問まで幅広い交流を行いましょう。"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/post/index.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-sm-6 text-center page-header mb-2">
      <h2>{{ __('商品一覧') }}</h2>
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
    @foreach($items as $item)
    <div class="card" onclick="location.href='/item/{{$item->id}}'">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card-body">
            <div class="card-text">
              {{$item->description}}
            </div>
          </div>
        </div>
      </div>
    </div>

    @endforeach
  @endif

  <div class="content">
    <form action="/item/charge" method="POST">
      @csrf
      <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="{{ config('assets.common.stripe.pk_key') }}"
        data-amount="10000"
        data-name="Stripe Demo"
        data-label="決済をする"
        data-description="Online course about integrating Stripe"
        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
        data-locale="auto"
        data-currency="JPY">
      </script>
    </form>
  </div>

  {{$items->links('layouts.common.pagination.bootstrap-4')}}
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
