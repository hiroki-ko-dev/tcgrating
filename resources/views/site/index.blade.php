@extends('layouts.common.common')

@section('content')
    <div class="container">
      @if(session('selected_game_id') == 3)
        <div class="row mb-2">
          <div class="col-md-12">
            <div class="box">
              <div>LINEオープンチャット参加でマッチング率が飛躍的に上昇します!!</div>
              <div><a href="https://line.me/ti/g2/Kt5eTJpAKQ9eV-De1_m7jeJA1XLIKaQFypvEZg?utm_source=invitation&utm_medium=link_copy&utm_campaign=default">
                  <img class="img-fluid" src="{{ asset('/images/site/line.png') }}" alt="hashimu-icon"></a>
              </div>
              <div>何も話さず見ているだけも可ですのでぜひご参加ください!!</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <img class="img-fluid" src="{{ asset('/images/site/top/003_pokemon_card.jpg') }}" alt="hashimu-icon">
          </div>
        </div>
      @else
        <div class="row">
          <div class="col-md-12">
            <img class="img-fluid" src="{{ asset('/images/site/top/001_yugioh_duellinks.jpg') }}" alt="hashimu-icon">
          </div>
        </div>
      @endif

    </div>

@endsection


@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
