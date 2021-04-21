
<div class="row justify-content-center mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                @if($post->post_category_id == \App\Models\PostCategory::TEAM_WANTED)
                    <a href="\team\{{$post->team->id}}">{{$post->team->name}}</a>
                    <br>　※参加リクエストはこちらのチーム名をクリック
                @else
                    {{ __('掲示板') }}
                @endif
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="post-user">{{$post->title}}  <a href="/user/{{$post->user_id}}">＠{{$post->user->name}}</a>[{{$post->created_at}}]</div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <div type="body">{!! nl2br(e($post->body)) !!}</div>
                    </div>
                </div>
            </div>

            @if(!empty($comments))
                <div class="card  pb-2">
                    <div class="card-header">{{ __('コメント一覧') }}</div>
                    <div class="card-body">
                        @foreach($comments as $comment)
                            <div class="col-md-12">
                                <div class="post-user"><a href="/user/{{$comment->user_id}}">＠{{$comment->user->name}}</a> [{{$comment->created_at}}]</div>
                            </div>
                            <div class="card-text border-bottom p-2">
                                {!! nl2br(e($comment->body)) !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{$comments->links('pagination::bootstrap-4')}}
            <div class="card-header">
                {{ __('コメントを投稿する' )}}
            </div>
            <div class="card-body">
                <form method="POST" action="/post/comment">
                    @csrf
                    <input type="hidden" name="post_id" value="{{$post->id}}">
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
                            <a href="/reload">　　返信を確認</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

