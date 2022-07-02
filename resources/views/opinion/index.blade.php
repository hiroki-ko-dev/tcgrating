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
      要望一覧
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

  @if(!empty($opinions))
    @foreach($opinions as $opinion)
    <div class="card" onclick="location.href='/opinion/{{$opinion->id}}'">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card-body">
            <div class="card-text" style="white-space: nowrap;">
              <span class="post-user">[{{$opinion->created_at}}]</span>
              <span class="bg-info rounded-pill text-white p-1">
                {{\App\Models\Opinion::TYPES[$opinion->type]}}
              </span>
            </div>
            <div class="card-text">
              {{$opinion->user->name}}
            </div>
          </div>
        </div>
      </div>
    </div>

    @endforeach
  @endif
  {{$opinions->links('layouts.common.pagination.bootstrap-4')}}
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
