<article>
  <div class="row justify-content-center mb-4">
    <div class="col-md-10 col-12">
      <div class="box text-left">
        <div class="sub-title">最新の記事</div>
        @if(!empty($blogsLatests))
          <section>
            <div class="mt-3">
              <div class="border-bottom"></div>
              <div>
                @foreach($blogsLatests as $blog)
                  <a href="/blogs/{{ $blog->id }}" class="text-decoration-none">
                    <div class="post-latest-row">
                      <div class="pt-1 pb-1">
                        <span class="text-danger">New</span>　{{$blog->title}}
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
