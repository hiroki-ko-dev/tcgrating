@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $post->title }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-user">{{$post->title}} [{{$post->created_at}}]</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div id="body" type="body">{{$post->body}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            @if(!empty($comments))
                <div class="card">
                    <div class="card-header">{{ __('掲示板') }}</div>
                    <div class="card-body">
                        @foreach($comments as $comment)
                            <div class="card-text border-bottom p-2">
                                <a href="/post/{{$comment->id}}">{{$comment->body}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{ $comments->appends(['sort' => 'votes'])->links() }}
            @endif
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('コメントを投稿する' )}}
                </div>
                <div class="card-body">
                    <form method="POST" action="/post/comment">
                        @csrf
                        <div class="form-group row">

                            <div class="col-md-12">
                                <textarea id="body" type="body" class="form-control @error('body') is-invalid @enderror" name="body" value="{{ old('body') }}" required autocomplete="body"></textarea>

                                @error('body')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('投稿') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.adsense')
@include('layouts.common.footer')
