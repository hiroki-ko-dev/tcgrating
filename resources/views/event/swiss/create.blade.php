@extends('layouts.common.common')

@include('layouts.common.header')
@include('layouts.common.google')

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('団体戦イベント作成') }}
    </div>
  </div>
  <form method="POST" action="/event/swiss">
    @csrf

    @include('layouts.common._twitter_auth')
    @include('layouts.event.create._title')
    @include('layouts.event.create._image_url')
    @include('layouts.event.create._tool')
    @include('layouts.event.create._datetime')
    @include('layouts.event.create._number_of_games')
    @include('layouts.event.create._body')
    @include('layouts.event.create._form')

  </form>
</div>

@endsection

@section('addJs')
  <script src="{{mix('/js/common/calendar.js')}}" defer></script>
  <script src="{{mix('/js/duel/duel.js')}}" defer></script>
@endsection

@include('layouts.common.footer')
