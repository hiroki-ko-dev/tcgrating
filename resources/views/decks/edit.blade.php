@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのブログ記事一覧です。最新情報から歴代パックや値段相場までまとめています。"/>
@endsection

@section('addCss')
  @vite(['resources/scss/decks/deck-index.scss'])
@endsection

@section('content')
  <div class="container">

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
        {{ __('記事編集') }}
      </div>
    </div>
      @method('PUT')

      @include('layouts.decks._form')

  </div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
