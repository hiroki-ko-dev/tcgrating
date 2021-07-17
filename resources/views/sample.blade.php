@extends('layouts.common.common')

@section('addJs')
  <script src="{{mix('/js/app.js')}}"></script>
@endsection

@section('content')
  <div id="example">test</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
