@extends('layouts.common.common')

@section('title','TOP')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

@section('content')
  <div class="container">
    @if(session('selected_game_id') == 1)
      <div class="row">
        <div class="col-md-12">
          <img class="img-fluid" src="{{ asset('/images/site/top/001_yugioh_duellinks.jpg') }}" alt="hashimu-icon">
        </div>
      </div>
    @else
      <div class="row justify-content-center mb-2">
        <div class="col-12">
          <section>
            @include('layouts.post.post_latest')
          </section>
          
          <section>
            @include('layouts.blog.latest')
          </section>
        </div>
          <div class="box">
            <div class="row"><div class="col-12">LINEオープンチャット参加でマッチング率が飛躍的に上昇します!!</div></div>
            <div class="row">
              <div class="col-sm-4"> </div>
              <div class="col-sm-4">
                <a href="https://line.me/ti/g2/Kt5eTJpAKQ9eV-De1_m7jeJA1XLIKaQFypvEZg?utm_source=invitation&utm_medium=link_copy&utm_campaign=default">
                  <img class="img-fluid" src="{{ asset('/images/site/line.png') }}" alt="hashimu-icon"></a>
              </div>
              <div class="col-sm-4"> </div>
            </div>
            <div class="row"><div class="col-12">話さず見ているだけでOKなのでまずは参加しましょう!!</div></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <img class="img-fluid" src="{{ asset('/images/site/top/003_pokemon_card.jpg') }}" alt="hashimu-icon">
        </div>
      </div>
    @endif
  </div>

@endsection


@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
