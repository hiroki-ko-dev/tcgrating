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
  <form method="POST" action="/event/group">
    @csrf

    @include('layouts.event._twitter_auth')
    @include('layouts.event._title')
    @include('layouts.event._image_url')
    @include('layouts.event._tool')
    @include('layouts.event._datetime')
    @include('layouts.event._number_of_games')
    @include('layouts.event._body')
    @include('layouts.event._form')

  </form>
</div>

@endsection

@section('addJs')
  <script src="{{mix('/js/common/calendar.js')}}" defer></script>
  <script src="{{mix('/js/duel/duel.js')}}" defer></script>
@endsection

@include('layouts.common.footer')
