@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="text-center alert-danger rounded p-3">
                {{ session('flash_message') }}
            </div>
        @endif
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="col-md-8 offset-md-4">
                <a class="btn btn-link text-center" href="post/create?post_category_id={{\App\Models\PostCategory::FREE}}">
                    {{ __('新規スレッド作成') }}
                </a>
            </div>

            <div class="card">
                <div class="card-header">{{ __('掲示板') }}</div>

                <div class="card-body">
                    @if(!empty($posts))
                        @foreach($posts as $post)
                            <div class="card-text border-bottom p-2">
                                <a href="/post/{{$post->id}}">{{$post->title}}</a>
                                <span class="post-user">[{{$post->created_at}}]</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            {{ $posts->appends(['sort' => 'votes'])->links() }}
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.adsense')
@include('layouts.common.footer')
