@extends('layouts.common.common')

@section('title','ポケモンカード | リモートポケカ')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/site/landing.css') }}">
@endsection

@section('addJs')
  <script src="https://unpkg.com/scrollreveal"></script>
@endsection

@section('content')


  <div class="container">

    <div class="landing-bg scrollReveal">
      <img class="img-fluid" src="{{ asset('/images/site/top/003_pokemon_card.jpg') }}" alt="hashimu-icon">
      <div class="title">
        <div>リモートポケカの</div><div>レーティング対戦</div>
      </div>
    </div>

    <div class="scrollReveal">
      @include('layouts.common.line')
    </div>

{{--    @include('layouts.common.application')--}}

    <div class="row justify-content-center scrollReveal">
      <div class="col-12">
        <div class="box">
          <div class="font-weight-bold mb-2">リモートポケカで</div>
          <div class="font-weight-bold mb-2">こんなお困りごとはありませんか？</div>
          <div class="d-flex flex-row mb-3">
            <div class="w-50 rounded bg-secondary m-1 pb-2">
              <img class="img-fluid" src="{{ asset('/images/site/landing/1.png') }}" alt="hashimu-icon">
              <div class="pictureFont text-white font-weight-bold">
                <div>対戦相手が</div>
                <div>見つからない</div>
              </div>
            </div>
            <div class="w-50 rounded bg-secondary m-1 pb-2">
              <img class="img-fluid" src="{{ asset('/images/site/landing/2.png') }}" alt="hashimu-icon">
              <div class="pictureFont text-white font-weight-bold">
                <div>もっと強い相手と</div>
                <div>戦いたい</div>
              </div>
            </div>
          </div>
          <div class="font-weight-bold mb-2">この悩みを解決します！</div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center scrollReveal">
      <img class="img-fluid" src="{{ asset('/images/site/landing/under_allow.png') }}" alt="hashimu-icon">
    </div>

    <div class="row justify-content-center mb-2 scrollReveal">
      <div class="col-12">
        <div class="box">
          <div class="text-white font-weight-bold rounded site-color p-3">リモートポケカの相手がすぐ見つかる</div>
          <div class="d-flex flex-row">
            <div class="w-50 rounded mt-1">
              <img class="img-fluid" src="{{ asset('/images/site/landing/matching.png') }}" alt="hashimu-icon">
            </div>
            <div class="d-flex align-items-center">
              <div class="text-left">
                <div class="mb-2">同じく対戦相手を探している人が大勢利用しています。</div>
                <div>ポケカプレイヤーが大勢利用しているから驚きのマッチング率！</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center scrollReveal">
      <div class="col-12">
        <div class="box">
          <div class="text-white font-weight-bold rounded site-color p-3">レーティング機能で全国1位を目指せ！</div>
          <div class="d-flex flex-row">
            <div class="w-50 rounded mt-1">
              <img class="img-fluid" src="{{ asset('/images/site/landing/ranking.png') }}" alt="hashimu-icon">
            </div>
            <div class="d-flex align-items-center">
              <div class="m-2 text-left">
                <div class="mb-2">勝敗によってレートが変動するので自分が全国何位か順位がわかる！</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center scrollReveal">
      <img class="img-fluid" src="{{ asset('/images/site/landing/under_allow.png') }}" alt="hashimu-icon">
    </div>


    {{--    <div class="pc row justify-content-center mb-4">--}}
    {{--      <div class="col-md-12">--}}
    {{--        <div class="box">--}}
    {{--          <div class="row"><div class="col-12 text-danger font-weight-bold"><h5>まずはLINEオープンチャットに参加</h5></div></div>--}}
    {{--          <div class="row"><div class="col-12">※話さず見ているだけでOK</div></div>--}}
    {{--          <div class="row">--}}
    {{--            <div class="col-sm-4"> </div>--}}
    {{--            <div class="col-sm-4">--}}
    {{--              <a href="https://line.me/ti/g2/Kt5eTJpAKQ9eV-De1_m7jeJA1XLIKaQFypvEZg?utm_source=invitation&utm_medium=link_copy&utm_campaign=default">--}}
    {{--                <img class="img-fluid" src="{{ asset('/images/site/line.png') }}" alt="hashimu-icon"></a>--}}
    {{--            </div>--}}
    {{--            <div class="col-sm-4"> </div>--}}
    {{--          </div>--}}
    {{--          <div class="row"><div class="col-12">※様子を見てすぐに退出してもOK</div></div>--}}
    {{--        </div>--}}
    {{--      </div>--}}
    {{--    </div>--}}

    <div class="scrollReveal">
          @include('layouts.common.line')
    </div>

{{--    @include('layouts.common.application')--}}

  </div>
@endsection

@section('addScript')
  <script>
    ScrollReveal().reveal('.scrollReveal' ,{
      delay: 600
    });
  </script>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
