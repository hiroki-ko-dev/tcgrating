@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

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

    @include('layouts.common._twitter_auth')
    @include('layouts.event.create._title')
    @include('layouts.event.create._image_url')
    @include('layouts.event.create._tool')
    @include('layouts.event.create._datetime')
    @include('layouts.event.create._max_member')
    @include('layouts.event.create._number_of_match')
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
