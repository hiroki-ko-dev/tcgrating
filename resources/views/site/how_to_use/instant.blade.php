@extends('layouts.common.common')

@section('title','使い方')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

@section('content')
<div class="container">

{{--  対戦作成側--}}
<input id="acd-check1" class="acd-check" type="checkbox">
<label class="acd-label site-color mb-1" for="acd-check1">■対戦を作成する</label>
  <div class="acd-content mb-3">

      <div class="box mb-5">
        <div class="row justify-content-center mb-4">
          <div class="col-md-12">
            <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">①1vs1対戦の「新規作成」ボタンを押し画像のページからTwitterログインしてください</div>
            <img class="img-fluid" src="{{ asset('/images/site/how_to_use/instant/1.png') }}" alt="hashimu-icon">
          </div>
        </div>

        <div class="row justify-content-center mb-4">
          <div class="col-md-12">
              <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">②相手が来るまで待機または、対戦URLを「コピー」ボタンを押してLINEオープンチャットやdiscordに貼り付けてください</div>
          <img class="img-fluid" src="{{ asset('/images/site/how_to_use/instant/2.png') }}" alt="hashimu-icon">
          </div>
        </div>

        <div class="row justify-content-center mb-4">
          <div class="col-md-12">
            <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">③LINEオープンチャットに参加前の場合はぜひ以下ボタンからご参加ください。ここで対戦を呼びかけることでマッチング率が飛躍的にあがります</div>
            @include('layouts.common.line')
          </div>
        </div>

        <div class="row justify-content-center mb-4">
          <div class="col-md-12">
            <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">④選択した対戦ツールで対戦相手と連絡をとって対戦を開始してください。</div>
            <div class="row text-left mb-2 ml-2">※LINEオープンチャットや本サイトのdiscordサーバー「マッチング待ち合わせ用チャンネル」で連絡するとスムーズです</div>
          </div>
        </div>

        <div class="row justify-content-center mb-4">
          <div class="col-md-12">
            <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">⑤対戦で勝利したプレーヤーが勝利ボタンを押してください。※各試合終了ごとに押す</div>
            <img class="img-fluid" src="{{ asset('/images/site/how_to_use/instant/3.png') }}" alt="hashimu-icon">
          </div>
        </div>

        <div class="row justify-content-center mb-4">
          <div class="col-md-12">
            <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">⑥試合が終了したら最終試合の勝者が「対戦完了」ボタンを押してください</div>
          </div>
        </div>
       </div>
  </div>

  {{--  対戦作成側--}}
<input id="acd-check2" class="acd-check" type="checkbox">
<label class="acd-label site-color mb-1" for="acd-check2">■作成された対戦に申し込む</label>
<div class="acd-content mb-3">
  <div class="box">
    <div class="row justify-content-center mb-4">
      <div class="col-md-12">
        <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">①「1vs1対戦」の一覧から対戦受付中のページに入り、Twitterログインしてください</div>
        <img class="img-fluid" src="{{ asset('/images/site/how_to_use/instant/4.png') }}" alt="hashimu-icon">
      </div>
    </div>

    <div class="row justify-content-center mb-4">
      <div class="col-md-12">
        <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">②「対戦申込」ボタンを押してください</div>
        <img class="img-fluid" src="{{ asset('/images/site/how_to_use/instant/5.png') }}" alt="hashimu-icon">
      </div>
    </div>

    <div class="row justify-content-center mb-4">
      <div class="col-md-12">
        <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">③LINEオープンチャットに参加前の場合はぜひ以下ボタンからご参加ください。ここで対戦を呼びかけることでマッチング後の連絡がスムーズになります</div>
        @include('layouts.common.line')
      </div>
    </div>

    <div class="row justify-content-center mb-4">
      <div class="col-md-12">
        <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">④選択した対戦ツールで対戦相手と連絡をとって対戦を開始してください。</div>
        <div class="row text-left mb-2 ml-2">※LINEオープンチャットや本サイトのdiscordサーバー「マッチング待ち合わせ用チャンネル」で連絡するとスムーズです</div>
      </div>
    </div>

    <div class="row justify-content-center mb-4">
      <div class="col-md-12">
        <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">⑤対戦で勝利したプレーヤーが勝利ボタンを押してください。※各試合終了ごとに押す</div>
        <img class="img-fluid" src="{{ asset('/images/site/how_to_use/instant/3.png') }}" alt="hashimu-icon">
      </div>
    </div>

    <div class="row justify-content-center mb-4">
      <div class="col-md-12">
        <div class="row text-left mb-2 ml-2 font-weight-bold text-primary">⑥試合が終了したら最終試合の勝者が「対戦完了」ボタンを押してください</div>
      </div>
    </div>
  </div>
</div>


@endsection


@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
