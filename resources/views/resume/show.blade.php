@extends('layouts.common.common')

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/resume/resume.css') }}">
@endsection

@section('addJs')
  <script src="{{mix('/js/resume/resume.js')}}" defer></script>
@endsection

@section('content')
<div class="container">

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

  <div class="row justify-content-center">
    {{--    <div class="col-sm-6 mb-4">--}}
    {{--      @include('layouts.resume.show.mail')--}}
    {{--    </div>--}}
    @include('layouts.resume.show.twitter')
  </div>

  <div class="row justify-content-center">
    <input type="hidden" id="gameUserJson" name="userJson" value="{{$gameUserJson}}">
    <input type="hidden" id="rankJson" name="rankJson" value="{{$rankJson}}">
    <div id='target-component' >ポケカ履歴書</div>
  </div>

</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
