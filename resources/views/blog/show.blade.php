@extends('layouts.common.common')

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
      {{ __('記事') }}
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-sm-12">
      <div class="box">
        <h3 class="text-left">{{$blog->title}}</h3>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-sm-12">
      <div class="box">
        <div type="body" class="text-left">{!! $blog->body !!}</div>
      </div>
    </div>
  </div>

    <div class="row justify-content-center mb-4">
      <div class="col-sm-12">
        <div class="box">
          @if(Auth::check() && Auth::id() == 1)
            <button type=“button”  class="btn site-color text-white rounded-pill btn-outline-secondary text-center" onclick="location.href='/blog/{{$blog->id}}/edit'">編集する</button>
          @endif
            <button type=“button”  class="btn btn-secondary text-white rounded-pill btn-outline-secondary text-center" onclick="location.href='/blog'">記事一覧へ</button>
        </div>
      </div>
    </div>

</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
