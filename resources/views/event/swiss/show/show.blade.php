@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('大会(スイスドロー)') }}
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
  @include('layouts.event.show._max_member')
  @include('layouts.event.show._datetime')
  @include('layouts.event.show._body')
  @include('layouts.event.show._status')
  @include('layouts.event.show._join_request')
  @include('event.swiss.show._duels')
  @include('layouts.event.show._organizer')
  @include('layouts.event.show._join_list')
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
