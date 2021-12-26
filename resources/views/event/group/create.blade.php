@extends('layouts.common.common')

@section('addJs')
  <script src="{{mix('/js/common/calendar.js')}}" defer></script>
  <script src="{{mix('/js/duel/duel.js')}}" defer></script>
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('リモートポケカレーティング') }}
    </div>
  </div>
  <form method="POST" action="/event/instant">
    @csrf


    @include('layouts.event._twitter_auth')
    @include('layouts.event._tool')
    @include('layouts.event._date')

    <div class="row justify-content-center  mb-0">
      @if(Auth::check())
        <button type="submit" class="btn site-color text-white rounded-pill btn-outline-secondary text-center pl-4 pr-4">
          {{ __('団体戦を作成') }}
        </button>
      @else
        <div>
          <h5>Twitterログインしていないため対戦の作成ができません。</h5>
          <h5 class="font-weight-bold text-danger">「Twitterと連携」 からログインしくてださい。</h5>
        </div>
      @endif
    </div>
  </form>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
