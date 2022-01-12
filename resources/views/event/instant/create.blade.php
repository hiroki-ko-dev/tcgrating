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

    @include('layouts.common._twitter_auth')
    {{--    @include('layouts.event.create._tool')--}}
    @include('layouts.common.discord._join')
    @include('layouts.common.discord._name')
    @include('layouts.event.create._form')

  </form>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
