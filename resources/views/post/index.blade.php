@extends('layouts.common.common')

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/post/index.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      <div class="d-flex flex-row mb-3">
        <div>
          @if(\App\Models\PostCategory::CATEGORY_FREE == $post_category_id)
              {{ __('フリー掲示板') }}
          @elseif(\App\Models\PostCategory::CATEGORY_TEAM_WANTED == $post_category_id)
              {{ __('チームメンバー募集掲示板') }}
          @endif
        </div>
        <div class="ml-auto">
          <!-- チーム募集掲示板はチームページから掲示板を作成させる -->
          @if($post_category_id <> \App\Models\PostCategory::CATEGORY_TEAM_WANTED)
            <btton class="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                   onclick="location.href='/post/create?post_category_id={{$post_category_id}}'">
              {{ __('新スレッド作成') }}
            </btton>
          @endif
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

  @if(!empty($posts))
    @foreach($posts as $post)
    <div class="card">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card-body">
            <div class="card-text" style="white-space: nowrap;">
              <span class="post-user">[{{$post->created_at}}]</span>[{{$post->post_comments_count}}]
            </div>
            <div class="card-text">
                <a href="/post/{{$post->id}}">{{$post->title}}</a>
                @if(isset($post->team)){{$post->team->name}}@endif
            </div>
          </div>
        </div>
      </div>
    </div>

    @endforeach
  @endif
  {{$posts->appends(['post_category_id' => $post_category_id])->links('pagination::bootstrap-4')}}
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
