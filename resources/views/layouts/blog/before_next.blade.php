
<nav>
  <div class="row justify-content-center mb-1">
    <div class="col-md-5 col-6 pr-1">
      <div class="box">
        <div class="row justify-content-center mb-4">
          前の記事
        </div>
        @if($preview)
          <a href="/blogs/{{$preview->id}}">
            <div class="row justify-content-center mb-4">
            {{$preview->title}}
            </div>
            <div class="row justify-content-center mb-4">
              <img class="thumbnail" src="{{ $preview->thumbnail_image_url }}" alt="hashimu-icon">
            </div>
          </a>
        @else
          <div class="row justify-content-center mb-4">
            記事がありません
          </div>
        @endif
      </div>
    </div>
    <div class="col-md-5 col-6 pl-1">
      <div class="box">
        <div class="row justify-content-center mb-4">
          次の記事
        </div>
        @if($next)
          <a href="/blogs/{{$next->id}}">
            <div class="row justify-content-center mb-4">
              <a href="/blogs/{{$next->id}}">{{$next->title}}</a>
            </div>
            <div class="row justify-content-center mb-4">
              <img class="thumbnail" src="{{ $next->thumbnail_image_url }}" alt="hashimu-icon">
            </div>
          </a>
        @else
          <div class="row justify-content-center mb-4">
            更新中
          </div>
        @endif
      </div>
    </div>
  </div>
</nav>