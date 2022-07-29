@extends('layouts.common.common')

@section('title','掲示板')

@section('description')
  <meta name="description" content="ポケカ(ポケモンカード)の掲示板です。雑談・デッキ相談・ルール質問まで幅広い交流を行いましょう。"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/post/index.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-sm-6 text-center page-header mb-2">
      @if(\App\Models\PostCategory::CATEGORY_FREE == $post_category_id)
        <h1>{{ __('ポケカ掲示板') }}</h1>
      @elseif(\App\Models\PostCategory::CATEGORY_TEAM_WANTED == $post_category_id)
          {{ __('チームメンバー募集掲示板') }}
      @endif
    </div>
    <div class="col-sm-6">
      <!-- チーム募集掲示板はチームページから掲示板を作成させる -->
      @if($post_category_id <> \App\Models\PostCategory::CATEGORY_TEAM_WANTED)
        <btton class="btn site-color text-white btn-outline-secondary text-center w-100"
               onclick="location.href='/post/create?post_category_id={{$post_category_id}}'">
          {{ __('+ 新スレッド作成') }}
        </btton>
      @endif
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

  <form method="GET" action="/post">
    <input type="hidden" name="post_category_id" value="{{\App\Models\PostCategory::CATEGORY_FREE}}">
    <div class="row justify-content-center">
      <fieldset>
        <input id="sub_category_null" class="radio-inline__input" type="radio" name="sub_category_id" value="0" @if(empty(request('sub_category_id'))) checked="checked" @endif/>
        <label class="radio-inline__label" for="sub_category_null">
          全て
        </label>
        @foreach(\App\Models\Post::SUB_CATEGORY as $key => $subCategory)
          <input id="item-{{$key}}" class="radio-inline__input" type="radio" name="sub_category_id" value="{{$key}}" @if($key == request('sub_category_id'))checked="checked"@endif/>
          <label class="radio-inline__label" for="item-{{$key}}">
            {{$subCategory}}
          </label>
        @endforeach
      </fieldset>
    </div>

    <div class="row justify-content-center m-1 mb-2">
      <div class="col-12">
        <input type="text" placeholder="検索ワードを入力" class="form-control" name="search" value="{{ request('search') }}" >
      </div>
    </div>
    <div class="row justify-content-end m-1 mb-3">
      <div class="col-sm-6">
        <button type="submit" class="w-100 btn btn-primary text-white btn-outline-secondary text-center">検索</button>
      </div>
    </div>
  </form>


  @if(!empty($posts))
    @foreach($posts as $post)
    <div class="card" onclick="location.href='/post/{{$post->id}}'">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card-body">
            <div class="card-text" style="white-space: nowrap;">
              <span class="post-user">[{{$post->created_at}}]</span>[{{$post->post_comments_count + 1}}]
              <span class="bg-info rounded-pill text-white p-1">
                {{\App\Models\Post::SUB_CATEGORY[$post->sub_category_id]}}
              </span>
            </div>
              <h2>
                {{$post->title}}
                @if(isset($post->team)){{$post->team->name}}@endif
              </h2>
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
