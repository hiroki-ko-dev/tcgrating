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
    @foreach($items as $i => $item)
      <input type="hidden" id="item_id_{{$item->id}}" name="item_id" value="{{$item->id}}">
      <div class="row justify-content-center">
        <div class="col-3">
          <div class="box">
            <div>
              {{$item->name}}
            </div>
            <div>
              {{$item->body}}
            </div>
            <div>
              {{$item->price}}円
            </div>
            <div>
              <img class="img-fluid" src="{{$item->image_url}}" alt="{{$item->name}}">
            </div>
            <div>
              <div>{{Form::select('amount', range(1, $item->amount), array('id' => 'amount_' . $item->id))}}個</div>
            </div>
            <div>
              <button id="cart_{{$item->id}}" class="cart">カートに追加する</button>
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

@section('addScript')
<script>
  // 税率変更ボタンクリック処理
  $('.cart').on('click', function() {
    if(confirm('カートに追加しますか？。')){
      var item_id = $(this).attr('id').split('_')[1];
      $('#' + id).prop('disabled', true);
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: "{{ url('/admin/invoice/organizer/summary/tax/change') }}" + '/' + id,
        dataType: "json",
        data: {
          item_id: 100,
          amount: "テストタイトル",
        },
      })
        // Ajaxリクエストが成功した場合
        .done(function(data) {
          alert("カートに入れました。");

          var price_id = '#price_' + id;
          $(price_id).first().text("¥" + data);
          $('#' + id).prop('disabled', true);
          $('#' + id).removeClass('change');
          $('#' + id).addClass('finish');
          $('#' + id).val('完了');
        })
        // Ajaxリクエストが失敗した場合
        .fail(function(data) {
          alert("税率変更処理に失敗しました。");
          $('#' + id).prop('disabled', false);
        });
    }else{
    }
  });



</script>
@endsection



@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
