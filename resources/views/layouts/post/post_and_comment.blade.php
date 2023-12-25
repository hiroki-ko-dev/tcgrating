
<article>
  <div class="row justify-content-center mb-4">
    <div class="col-md-10 col-12">
      <div class="box text-left">

        <section>
          <div class="pb-1">
            <div class="pt-2 pb-2 d-flex align-items-center">
              <span class="text-nowrap post-tag p-1">
                {{$post->subCategoryName}}
              </span>
                <h1 class="text-wrap post-title p-2">{{$post->title}}</h1>
            </div>
            <nav>
              <div class="form-group row">
                <div class="col-md-12">
                  <span class="post-user">1. [{{$post->createdAt}}]</span>
                  <a href="/posts/comment/create?post_id={{$post->id}}">返信する</a>
                </div>
                <div class="row pt-3 pl-3 pr-3">
                  <div class="col-md-12">
                    <img src="{{$post->user->profileImagePath}}" class="rounded-circle small-profile" onerror="this.src='{{ asset('/images/icon/default-account.png') }}'">
                    <span class="post-user">
                      @if($post->user->id)
                        <a class="font-weight-bold" href="/resume/{{$post->user->id}}">{{$post->user->name}}</a>
                      @else
                        {{$post->user->name}}
                      @endif
                    </span>
                  </div>
                </div>
              </div>
            </nav>
            @if(!empty($post->imageUrl))
              <div class="form-group row mt-2">
                <div class="col-12">
                  <span class="post-text">デッキコード：<a href="https://www.pokemon-card.com/deck/confirm.html/deckID/{{$post->imageUrl}}">{{$post->imageUrl}}</a></span>
                </div>
              </div>
              <div class="form-group row mt-2">
                <div class="col-md-12">
                  <img class="img-fluid" src="https://www.pokemon-card.com/deck/deckView.php/deckID/{{$post->imageUrl}}" alt="{{$post->title}}">
                </div>
              </div>
            @endif
            <div class="form-group row">
                <div class="col-md-12">
                    <div class="post-text">{!! nl2br(e($post->body)) !!}</div>
                </div>
            </div>
            @if($post->replyCommentCount > 0)
              <nav>
                <div class="row mt-2 pb-2">
                  <div class="bg-pink p-1 ml-3 font-weight-bold text-redPurple">
                    <a href="/posts/comment/create?post_id={{$post->id}}" class="text-redPurple">{{$post->replyCommentCount}}件の返信</a>
                  </div>
                </div>
              </nav>
            @endif
          </div>
        </section>

        @if(!empty($post->comments))
          <section>
            <div class="pb-5 mt-3">
              <div class="border-bottom"></div>
              <div>
                @if(empty($post->comments))
                  <div class="post-text text-secondary p-2">
                    現在コメントはありません
                  </div>
                @else
                  @foreach($post->comments as $comment)
                    <div class="pt-3 pb-2">
                      <div class="pt-1 pb-2">
                        <span class="post-user">{{$comment->number}}. [{{$comment->createdAt}}]</span>
                        <a href="/posts/comment/create?comment_id={{$comment->id}}">返信する</a>
                      </div>
                      <img src="{{$comment->user->profileImagePath}}" class="rounded-circle small-profile" onerror="this.src='{{ asset('/images/icon/default-account.png') }}'">
                      <span class="post-user">
                        @if($comment->user->id)
                          <a href="/resume/{{$comment->userId}}">{{$comment->user->name}}</a>
                        @else
                          {{$comment->user->name}}
                        @endif                     
                      </span>
                    </div>
                    @if(!empty($comment->imageUrl))
                      <div class="form-group row mt-2">
                        <div class="col-12">
                          <span class="post-text">デッキコード：<a href="https://www.pokemon-card.com/deck/confirm.html/deckID/{{$comment->imageUrl}}">{{$comment->imageUrl}}</a>
                        </div>
                      </div>
                      <div class="form-group row mt-2">
                        <div class="col-md-12">
                          <img class="img-fluid" src="https://www.pokemon-card.com/deck/deckView.php/deckID/{{$comment->imageUrl}}" alt="{{$post->title}}">
                        </div>
                      </div>
                    @endif
                    @if($comment->isReferralPost || $comment->referralComment )
                      <div class="row mt-2">
                        <div class="bg-skyblue p-1 ml-3 font-weight-bold text-primary">
                          @if($comment->isReferralPost)
                            <a href="/posts/comment/create?post_id={{$comment->postId}}">>>1</a>
                          @else
                            <a href="/posts/comment/create?comment_id={{$comment->referralComment->id}}">>>{{$comment->referralComment->number}}</a>
                          @endif
                        </div>
                      </div>
                    @endif
                    <div class="post-text pb-4">
                        {!! nl2br(e($comment->body)) !!}
                    </div>
                    @if($comment->replyCommentCount)
                      <div class="row mt-2 pb-2">
                        <div class="bg-pink p-1 ml-3 font-weight-bold">
                          <a href="/posts/comment/create?comment_id={{$comment->id}}" class="text-redPurple">{{$comment->replyCommentCount}}件の返信</a>
                        </div>
                      </div>
                    @endif
                    <div class="border-bottom"></div>
                  @endforeach
                @endif
              </div>
            </div>
          </section>
        @endif
        <div class="d-flex justify-content-center mb-4">
          {{$post->comments->links('pagination::bootstrap-4')}}
        </div>
        <div class="sub-title">コメントを投稿する</div>
        <div class="card-body">
          <form method="POST" action="/posts/comment">
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
            <div class="form-group row">
              <input type="hidden" id="deckUrl" value="https://www.pokemon-card.com/deck/deckView.php/deckID/">
              <div id="target-component"></div>
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
              <div class="col-md-8 offset-md-2 text-center">
                <button class="btn bg-secondary text-white w-40 mr-2" onClick="history.back()">戻る</button>
                <button type="submit" class="btn site-color btn-outline-secondary text-light w-40" onClick="return requestConfirm();">
                    {{ __('投稿') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</article>
