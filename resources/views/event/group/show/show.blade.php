@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('団体戦') }}
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
  @include('layouts.event.show._image_url')
  @include('layouts.common._twitter_auth')
  @include('layouts.event.show._number_of_games')
  @include('layouts.event.show._datetime')
  @include('layouts.event.show._body')
  @include('layouts.event.show._status')
{{--  @if(!Auth::check() && Auth::id() <> $event->user_id)--}}
    @include('event.group.show._join_request')
{{--  @endif--}}

</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
