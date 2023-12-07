@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのブログ記事一覧です。最新情報から歴代パックや値段相場までまとめています。"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/blog/index.css') }}">
@endsection

@section('content')
  <div class="container">

    <div class="row justify-content-center m-1 mb-3">
      <div class="col-12 page-header">
        <div class="d-flex flex-row">
          <div class="col-6">
            {{ __('記事') }}
          </div>
          @if(Auth::check() && Auth::id() == 1)
            <div class="col-6">
              <button class="btn site-color text-white btn-outline-secondary text-center w-100"
                onclick="location.href='/blog/create'">
                {{ __('+ 新規作成') }}
              </button>
            </div>
          @endif
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

    <div class="row justify-content-center mb-4">
      <div class="col-12">
        <div class="box">
          @if(!empty($blogs))
            @foreach($blogs as $blog)
              <div class="row justify-content-center border-bottom">
                <div class="col-sm-12">
                  <div class="d-flex flex-row text-left">
                    <div class="thumbnail-w mr-2">
                      <img class="thumbnail" src="{{ $blog->thumbnail_image_url }}" alt="hashimu-icon">
                    </div>
                    <div class="string-w">
                      <div class="blog-date mb-2 mt-2">
                        [作成日時:{{$blog->created_at}}]
                      </div>
                      <div class="text-break d-flex align-items-center">
                        <span class="blog-title"><a href="/blog/{{$blog->id}}">{{$blog->title}}</a></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center mb-4">
      {{$blogs->links('pagination::bootstrap-4')}}
    </div>
  </div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
