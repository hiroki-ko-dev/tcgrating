@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('マイページ') }}
    </div>
  </div>

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-12">
        <div class="text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
        </div>
      </div>
    @endif
  </div>

  <form method="POST" action="/user/{{$user->id}}">
    @csrf
    @method('PUT')

    <input type="hidden" name="id" value="{{$user->id}}">

    <div class="row justify-content-center">
      @include('layouts.user.edit.email')
      @include('layouts.user.edit.name')
      @include('layouts.user.edit.gender')
      @include('layouts.user.edit.experience')
      @include('layouts.user.edit.area')
      @include('layouts.user.edit.preference')
      @include('layouts.user.edit.regulation')
      @include('layouts.user.edit.play_style')
    </div>

    <div class="row justify-content-center">
      @include('layouts.user.edit.body')
    </div>

    <div class="form-group row mb-3">
      <div class="col-md-6 offset-md-5">
        <button type="submit" class="btn site-color text-white rounded-pill btn-outline-secondary text-center pl-5 pr-5">
          {{ __('保存') }}
        </button>
      </div>
    </div>
  </form>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
