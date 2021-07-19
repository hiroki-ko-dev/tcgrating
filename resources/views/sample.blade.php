@extends('layouts.common.common')

@section('addCss')
  <script src="{{mix('/css/sample/sample.css')}}" defer></script>
@endsection

@section('addJs')
  <script src="{{mix('/js/sample/sample.js')}}" defer></script>
@endsection

@section('content')
  <div id="root"></div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
