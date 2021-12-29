@extends('layouts.common.common')

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/blog/blog.css') }}">
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
        <div class="d-flex flex-row mb-3">
          <div>
            {{ __('記事') }}
          </div>
          @if(Auth::check() && Auth::id() == 1)
            <div class="ml-auto">
              <btton class="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                     onclick="location.href='/blog/create'">
                {{ __('新規記事作成') }}
              </btton>
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
              <div class="row justify-content-center border-bottom p-2">
                <div class="col-sm-12">
                  <div class="d-flex flex-row text-left">
                    <div class="w-25 mr-2">
                      <img class="thumbnail" src="{{ $blog->thumbnail_image_url }}" alt="hashimu-icon">
                    </div>
                    <div class="w-75">
                      <div>
                        [作成日時:{{$blog->created_at}}]
                      </div>
                      <div class="text-break">
                        <h5>
                          <a href="/blog/{{$blog->id}}">{{$blog->title}}</a>
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
          {{$blogs->links('pagination::bootstrap-4')}}
        </div>
      </div>
    </div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
