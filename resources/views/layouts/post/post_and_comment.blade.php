
<div class="row justify-content-center mb-4">
  <div class="col-12">
    <div class="box text-left">
      <div class="box-header">
          @if($post->post_category_id == \App\Models\PostCategory::CATEGORY_TEAM_WANTED)
              <a href="\team\{{$post->team->id}}">{{$post->team->name}}</a>
              <br>　※参加リクエストはこちらのチーム名をクリック
          @else
              {{ __('掲示板') }}
          @endif
      </div>
      <div class="pb-2">
          <div class="form-group row">
            <div class="col-sm-12">
              <span class="bg-info rounded-pill text-white p-1">
                  {{\App\Models\Post::SUB_CATEGORY[$post->sub_category_id]}}
              </span>
              <h4 class="pl-1">
                {{$post->title}}
              </h4>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-12">
              <span class="post-user">1. [{{$post->created_at}}]</span>
              <a href="/post/comment/create?post_id={{$post->id}}">返信する</a>
            </div>
            <div class="row pl-3">
              <div class="col-md-12">
                <img src="{{$post->user->twitter_simple_image_url}}" class="rounded-circle">
                <a class="font-weight-bold" href="/user/{{$post->user_id}}">{{$post->user->name}}</a>
              </div>
            </div>
          </div>

        @if(!empty($post->image_url))
          <div class="form-group row mt-2">
            <div class="col-12">
            デッキコード：<a href="https://www.pokemon-card.com/deck/confirm.html/deckID/{{$post->image_url}}">{{$post->image_url}}</a>
            </div>
          </div>
          <div class="form-group row mt-2">
            <div class="col-md-12">
              <img class="img-fluid" src="https://www.pokemon-card.com/deck/deckView.php/deckID/{{$post->image_url}}" alt="{{$post->title}}">
            </div>
          </div>
        @endif

        <div class="form-group row">
            <div class="col-md-12">
                <div class="post-text">{!! nl2br(e($post->body)) !!}</div>
            </div>
        </div>

        @if($post->postComments->where('referral_id',0)->whereNotNull('referral_id')->count() > 0)
          <div class="row mt-2 pb-2">
            <div class="bg-pink p-1 ml-3 font-weight-bold text-redPurple">
              <a href="/post/comment/create?post_id={{$post->id}}" class="text-redPurple">{{$post->postComments->where('referral_id',0)->whereNotNull('referral_id')->count()}}件の返信</a>
            </div>
          </div>
        @endif

      </div>

      @if(!empty($comments))
          <div class="pb-5 mt-3">
              <div class="card-header">{{ __('コメント一覧') }}</div>
              <div>
                @if(empty($comments[0]))
                  <div class="post-text p-2">
                    現在コメントはありません
                  </div>
                @else
                  @foreach($comments as $comment)
                      <div class="pt-3">
                        <div>
                          <span class="post-user">{{$comment->number}}. [{{$comment->created_at}}]</span>
                          <a href="/post/comment/create?comment_id={{$comment->id}}">返信する</a>
                        </div>
                        <img src="{{$comment->user->twitter_simple_image_url}}" class="rounded-circle">
                        <span class="post-user"><a href="/user/{{$comment->user_id}}">{{$comment->user->name}}</a></span>
                      </div>
                      @if(!empty($comment->image_url))
                        <div class="form-group row mt-2">
                          <div class="col-12">
                            デッキコード：<a href="https://www.pokemon-card.com/deck/confirm.html/deckID/{{$comment->image_url}}">{{$comment->image_url}}</a>
                          </div>
                        </div>
                        <div class="form-group row mt-2">
                          <div class="col-md-12">
                            <img class="img-fluid" src="https://www.pokemon-card.com/deck/deckView.php/deckID/{{$comment->image_url}}" alt="{{$post->title}}">
                          </div>
                        </div>
                      @endif
                      @if(!is_null($comment->referral_id))
                        <div class="row mt-2">
                          <div class="bg-skyblue p-1 ml-3 font-weight-bold text-primary">
                            @if($comment->referral_id == 0)
                              <a href="/post/comment/create?post_id={{$post->id}}">>>1</a>
                            @else
                              <a href="/post/comment/create?comment_id={{$comment->referralComment->id}}">>>{{$comment->referralComment->number}}</a>
                            @endif
                          </div>
                        </div>
                      @endif
                      <div class="post-text pb-2">
                          {!! nl2br(e($comment->body)) !!}
                      </div>
                      @if($comment->replyComments->count() > 0)
                        <div class="row mt-2 pb-2">
                          <div class="bg-pink p-1 ml-3 font-weight-bold">
                            <a href="/post/comment/create?comment_id={{$comment->id}}" class="text-redPurple">{{$comment->replyComments->count()}}件の返信</a>
                          </div>
                        </div>
                      @endif
                    <div class="border-bottom"></div>
                @endforeach
                @endif
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
                  <textarea id="body" type="body" placeholder="コメント本文" class="form-control @error('body') is-invalid @enderror" name="body" style="height: 150px" value="{{ old('body') }}" required autocomplete="body"></textarea>
                  @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
            <div class="form-group row">
              <input id="image_url" type="text" placeholder="デッキコードを書く（省略可）" class="form-control w-100 @error('image_url') is-invalid @enderror" name="image_url" value="{{ old('image_url') }}" >
            </div>

            @if(Auth::check() && Auth::user()->role == \App\Models\User::ROLE_ADMIN)
              <div class="form-group row">
                <select name="user_id" class="form-control">
                  @foreach(config('assets.account.sakura') as $key => $name)
                    <option value="{{$key}}"
                            @if(old('user_id'))
                            selected
                      @endif
                    >{{$name}}</option>
                  @endforeach
                </select>
              </div>
            @endif
              <div class="form-group row mb-0">
                  <div class="col-md-6 offset-md-5">
                      <button type="submit" class="btn site-color rounded-pill btn-outline-secondary text-light pl-5 pr-5" onClick="return requestConfirm();">
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

