@extends('layouts.common.common')

@section('title','掲示板')

@section('description')
  <meta name="description" content="ポケモンカードの掲示板です。雑談・デッキ相談・ルール質問まで幅広い交流を行いましょう。"/>
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('商品追加') }}
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

  <div class="col-md-12">
      <div class="box w-100">
          <form method="POST" action="/item">
              @csrf

            @include('layouts.item._form', ['item' => new \App\Models\Item()])
          </form>
        </div>
    </div>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
