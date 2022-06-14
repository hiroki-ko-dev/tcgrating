@extends('layouts.common.common')

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/event/index.css') }}">
@endsection

@section('content')

<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      <div class="d-flex flex-row mb-3">
        <div>
          {{ __('商品一覧') }}
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
        <form action="">
          <table class="search table">
            <tr>
              <td class="heading">検索ワード</td>
              <td colspan="3"><input type="text" name="word" value="{{ request('word') }}"/></td>
              <td>
                <button type="submit" style="width: 120px;">検索</button>
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>

  @if(isset($product) && request('word'))
    <table class="table">
      <thead>
      <tr>
        <th width="5%" scope="col">id</th>
        <th width="60%" scope="col">名前</th>
        <th width="10%" scope="col">値段</th>
        <th width="10%" scope="col">取扱店</th>
        <th width="15%" scope="col">画像</th>
      </tr>
      </thead>
      <tbody>
        @foreach($product['id'] as $i => $array)
          <tr>
            <td scope="col" class="align-middle">{{$product['id'][$i]}}</td>
            <td scope="col" class="align-middle"><a href="{{$product['url'][$i] . $product['id'][$i]}}">{{$product['name'][$i]}}</td>
            <td scope="col" class="align-middle">{{$product['price'][$i]}}</td>
            <td scope="col" class="align-middle">{{$product['store'][$i]}}</td>
            <td scope="col" class="align-middle"><img src="{{$product['image'][$i]}}"></td>
          </tr>
        @endforeach
        </tbody>
      </table>
  @endif

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
