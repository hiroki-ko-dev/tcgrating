@extends('layout.common.common')

@section('content')
    <div class="container border">
        <div class="row pt-10 pb-5">
            <div class="col-md-2">
            </div>
            <div class="col-md-2">
                <img class="img-responsive" src="{{ asset('/images/site/hashimu-icon.png') }}" alt="hashimu-icon}">
            </div>
            <div class="col-md-6">
                名前：ハシム<br>
                職業：真紅眼流師範<br>
                <a class="navbar-brand" href="https://www.youtube.com/hashimugame"> Go To YouTube Channel</a><br>
            </div>
        </div>
    </div>
@endsection

@include('layout.common.header')
@include('layout.common.footer')
