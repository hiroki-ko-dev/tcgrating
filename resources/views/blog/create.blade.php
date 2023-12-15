@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのブログ記事一覧です。最新情報から歴代パックや値段相場までまとめています。"/>
@endsection

@section('addCss')
  @vite(['resources/scss/blog/blog-show.scss'])
@endsection

@section('addJs')
{{--  <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>--}}
<script src="//cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>
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
        {{ __('記事作成') }}
      </div>
    </div>
    <form method="POST" action="/blog">
      @csrf
      @include('layouts.blog._form')
    </form>
  </div>
@endsection

@section('addScript')
  @include('layouts.common._ckeditor')
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
