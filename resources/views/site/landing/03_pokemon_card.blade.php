@extends('layouts.common.common')

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/site/landing.css') }}">
@endsection

@section('content')

  <div class="landing-bg">
    <img class="img-fluid" src="{{ asset('/images/site/top/003_pokemon_card.jpg') }}" alt="hashimu-icon">
    <p>リモートポケカのレーティング対戦</p>
  </div>

  <div class="container">

    @include('layouts.common.line')

    <div class="row justify-content-center">
      <div class="col-12">
        <div class="box">
          <div class="font-weight-bold mb-2">リモートポケカで</div>
          <div class="font-weight-bold mb-2">こんなお困りごとはありませんか？</div>
          <div class="d-flex flex-row mb-3">
            <div class="w-50 rounded bg-secondary m-1 pb-2">
              <img class="img-fluid" src="{{ asset('/images/site/landing/1.png') }}" alt="hashimu-icon">
              <div class="text-white font-weight-bold">
                <div>対戦相手が</div>
                <div>見つからない</div>
              </div>
            </div>
            <div class="w-50 rounded bg-secondary m-1 pb-2">
              <img class="img-fluid" src="{{ asset('/images/site/landing/2.png') }}" alt="hashimu-icon">
              <div class="text-white font-weight-bold">
                <div>もっと強い相手と</div>
                <div>戦いたい</div>
              </div>
            </div>
          </div>
          <div class="font-weight-bold mb-2">この悩みを解決します！</div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="w-25">
        <img class="img-fluid" src="{{ asset('/images/site/landing/under_allow.png') }}" alt="hashimu-icon">
      </div>
    </div>

    <div class="row justify-content-center mb-2">
      <div class="col-12">
        <div class="box">
          <div class="text-white font-weight-bold rounded site-color p-2">リモートポケカの対戦相手がすぐ見つかる</div>
          <div class="d-flex flex-row mb-3">
            <div class="w-50 rounded mt-1 pb-2">
              <img class="img-fluid" src="{{ asset('/images/site/landing/matching.png') }}" alt="hashimu-icon">
            </div>
            <div class="w-50 m-2 text-left">
              <div class="mb-2">同じく対戦相手を探している人が大勢利用しています。</div>
              <div>ポケカプレイヤーが大勢利用しているから驚きのマッチング率！</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-12">
        <div class="box">
          <div class="text-white font-weight-bold rounded site-color p-2">レーティング機能で全国1位を目指せ！</div>
          <div class="d-flex flex-row mb-3">
            <div class="w-50 rounded mt-1 pb-2">
              <img class="img-fluid" src="{{ asset('/images/site/landing/ranking.png') }}" alt="hashimu-icon">
            </div>
            <div class="w-50 m-2 text-left">
              <div class="mb-2">勝敗によってレートが変動するので自分が全国何位か順位がわかる！</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="w-25">
        <img class="img-fluid" src="{{ asset('/images/site/landing/under_allow.png') }}" alt="hashimu-icon">
      </div>
    </div>


    <div class="row justify-content-center mb-4">
      <div class="col-md-12">
        <div class="box">
          <div class="row"><div class="col-12 text-danger font-weight-bold"><h5>まずはLINEオープンチャットに参加</h5></div></div>
          <div class="row"><div class="col-12">※話さず見ているだけでOK</div></div>
          <div class="row">
            <div class="col-sm-4"> </div>
            <div class="col-sm-4">
              <a href="https://line.me/ti/g2/Kt5eTJpAKQ9eV-De1_m7jeJA1XLIKaQFypvEZg?utm_source=invitation&utm_medium=link_copy&utm_campaign=default">
                <img class="img-fluid" src="{{ asset('/images/site/line.png') }}" alt="hashimu-icon"></a>
            </div>
            <div class="col-sm-4"> </div>
          </div>
          <div class="row"><div class="col-12">※様子を見てすぐに退出してもOK</div></div>
        </div>
      </div>
    </div>
  </div>

@endsection


@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')