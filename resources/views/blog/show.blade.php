@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのブログ記事一覧です。最新情報から歴代パックや値段相場までまとめています。"/>
@endsection

@section('addCss')
  @vite(['resources/scss/blog/blog-show.scss'])
@endsection

@section('twitterHeader')
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@pokekaInfo" />
  <meta name="twitter:title" content="ポケカ掲示板" />
  <meta name="twitter:description" content="ポケカのデッキ相談・ルール質問・雑談などを掲示板で話しましょう！" />
  <meta name="twitter:image" content="{!! $blog->thumbnail_image_url !!}" />
@endsection

@section('content')
<div class="container">

  <section>
    <div class="row justify-content-center">
      <!-- フラッシュメッセージ -->
      @if (session('flash_message'))
        <div class="col-12">
          <div class="text-center alert-danger rounded p-3 mb-3">
            {{ session('flash_message') }}
          </div>
        </div>
      @endif
    </div>
  </section>

  @include('layouts.post.post_latest')

  <article>
    <section>
      <div class="row justify-content-center mb-2">
        <div class="col-md-10 col-12">
          <div class="box">
            <h1 class="blog-title p-1 mb-4">{{$blog->title}}</h1>
            <div class="border-bottom mb-4"></div>
            <div class="blog-body">
              @if($blog->affiliate_url)
                <div><a href="{{$blog->affiliate_url}}">商品購入ページはこちら</a></div>
                <br>
              @endif
              <div type="body" class="blog-text">{!! $blog->body !!}</div>
            </div>
          </div>
        </div>
      </div>
    </section>

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

    <section>
      @include('layouts.common.line')
    </section>

    <nav>
      <div class="row justify-content-center mb-4 mt-1">
        <div class="col-md-10 col-12">
          <div class="box">
            <form method="POST" action="{{route('blogs.destroy',['blog' => $blog->id])}}">
              <div class="btn-group w-100" role="group">
                @if(Auth::check() && Auth::id() == 1)
                  <button type="button" class="btn site-color btn-outline-secondary text-light w-20 m-1" onclick="location.href='/blogs/{{$blog->id}}/edit'">
                    {{ __('編集する') }}
                  </button>
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn site-color btn-outline-secondary text-light w-20 m-1" onClick="return requestConfirm();">
                    {{ __('削除する') }}
                  </button>
                @endif
                <button type="button" class="btn site-color btn-outline-secondary text-light w-20 m-1" onclick="location.href='/blogs'">
                  {{ __('一覧へ戻る') }}
                </button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </nav>
    

  </article>
  @include('layouts.post.post_latest')
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
