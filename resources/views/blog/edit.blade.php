@extends('layouts.common.common')

@include('layouts.common.header')
@include('layouts.common.google')

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
    <form method="POST" action="/blog/{{$blog->id}}">
      @csrf
      @method('PUT')

      @include('layouts.blog._form')

    </form>
  </div>

@endsection

@section('addJs')
  <script src="//cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>
@endsection

@include('layouts.common.footer')
