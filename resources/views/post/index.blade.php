@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="bg-links-blue text-white rounded p-3 mb-3">
        @if(\App\Models\PostCategory::FREE == $post_category_id)
            <h3>{{ __('フリー掲示板') }}</h3>
        @elseif(\App\Models\PostCategory::TEAM_WANTED == $post_category_id)
            <h3>{{ __('チームメンバー募集掲示板') }}</h3>
        @endif
    </div>

    <div class="row justify-content-center">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="text-center alert-danger rounded p-3 mb-3 col-md-7">
                {{ session('flash_message') }}
            </div>
        @endif
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- チーム募集掲示板はチームページから掲示板を作成させる -->
            @if($post_category_id <> \App\Models\PostCategory::TEAM_WANTED)
                <div class="col-md-8 offset-md-4">
                    <a class="btn btn-link text-center" href="post/create?post_category_id={{$post_category_id}}">
                        {{ __('新規スレッド作成') }}
                    </a>
                </div>
            @endif

            <div class="card">
                <div class="card-header">{{ __('スレッド一覧') }}</div>

                <div class="card-body">
                    @if(!empty($posts))
                        @foreach($posts as $post)
                            <div class="card-text border-bottom p-2">
                                <a href="/post/{{$post->id}}">{{$post->title}}</a>
                                [{{$post->post_comment_count}}]
                                @if(isset($post->team))＠{{$post->team->name}}@endif
                                <span class="post-user">[{{$post->created_at}}]</span>
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
