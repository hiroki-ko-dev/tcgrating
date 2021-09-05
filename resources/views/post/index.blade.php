@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="bg-site-black text-white rounded p-3 mb-3">
        <div class="d-flex flex-row mb-3">
          <div>
            @if(\App\Models\PostCategory::FREE == $post_category_id)
                <h3>{{ __('フリー掲示板') }}</h3>
            @elseif(\App\Models\PostCategory::TEAM_WANTED == $post_category_id)
                <h3>{{ __('チームメンバー募集掲示板') }}</h3>
            @endif
          </div>
          <div class="ml-auto">
            <!-- チーム募集掲示板はチームページから掲示板を作成させる -->
            @if($post_category_id <> \App\Models\PostCategory::TEAM_WANTED)
              <btton class="btn rounded-pill btn-outline-light btn-link text-center"
                     onclick="location.href='/post/create?post_category_id={{$post_category_id}}'">
                {{ __('新規スレッド作成') }}
              </btton>
            @endif
          </div>
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
            <div class="card">
                <div class="card-body">
                    @if(!empty($posts))
                        @foreach($posts as $post)
                          <div class="d-md-flex flex-row mb-3 border-bottom">
                            <div class="card-text" style="white-space: nowrap;">
                              <span class="post-user">[{{$post->created_at}}]</span>[{{$post->post_comment_count}}]
                            </div>
                            <div class="card-text">
                                <a href="/post/{{$post->id}}">{{$post->title}}</a>
                                @if(isset($post->team)){{$post->team->name}}@endif
                            </div>
                          </div>
                        @endforeach
                    @endif
                </div>
            </div>
            {{$posts->appends(['post_category_id' => $post_category_id])->links('pagination::bootstrap-4')}}
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
