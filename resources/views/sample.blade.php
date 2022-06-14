@extends('layouts.common.common')

@section('title','sample')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

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
