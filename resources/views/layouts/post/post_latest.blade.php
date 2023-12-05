<article>
  <div class="row justify-content-center mb-4">
    <div class="col-md-10 col-12">
      <div class="box text-left">
        <div class="sub-title">最新のスレッド一覧</div>
        @if(!empty($postLatests))
          <section>
            <div class="mt-3">
              <div class="border-bottom"></div>
              <div>
                @foreach($postLatests as $comment)
                  <a href="/post/comment/create?comment_id={{ $comment->id }}" class="text-decoration-none">
                    <div>
                      <div class="pt-1 pb-1">
                        <span class="text-danger">New</span>　{{$comment->title}}
                      </div>
                    </div>
                    <div class="border-bottom"></div>
                  </a>
                @endforeach
              </div>
            </div>
          </section>
        @endif
      </div>
    </div>
  </div>
</article>
