@extends('layouts.common.common')

@include('layouts.common.header')
@include('layouts.common.google')

@section('addCss')
  @vite(['resources/scss/resumes/resumes-show.scss'])
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
    <input type="hidden" id="resumeJson" name="resumeJson" value="{{$resumeJson}}">
    <div id='target-component' >ポケカ履歴書</div>
  </div>

</div>

@endsection

@section('addJs')
  {{-- <script src="{{mix('/js/resume/resume.js')}}" defer></script> --}}
  @vite('resources/js/resume/Resume.jsx')
@endsection

@include('layouts.common.footer')
