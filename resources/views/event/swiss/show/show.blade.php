@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-6">
      {{ __('大会(スイスドロー)') }}
    </div>
    <div class="col-6 w-100">
      <button type="button" class="btn site-color text-white btn-outline-secondary text-center w-100" onclick="location.href='/event/swiss/{{$event->id}}/edit'">編集する</button>
    </div>
  </div>

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-md-12 text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
      </div>
    @endif
  </div>

  @include('layouts.event.show._title')
  @include('layouts.event.show._rank')
  @include('layouts.event.show._image_url')
  @include('layouts.event.show._number_of_games')
  @include('layouts.event.show._max_member')
  @include('layouts.event.show._datetime')
  @include('layouts.event.show._body')
  @include('layouts.event.show._status')
  @include('layouts.common._twitter_auth')
  @include('layouts.event.show._organizer')
  @include('event.swiss.show._duels')
  @include('layouts.event.show._join_request')
  @include('layouts.event.show._join_list')
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
