@extends('layouts.common.common')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
              @if(session('selected_game_id') == 3)
                <img class="img-fluid" src="{{ asset('/images/site/top/003_pokemon_card.jpg') }}" alt="hashimu-icon">
              @else
                <img class="img-fluid" src="{{ asset('/images/site/top/001_yugioh_duellinks.jpg') }}" alt="hashimu-icon">
              @endif
            </div>
        </div>
    </div>

@endsection


@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
