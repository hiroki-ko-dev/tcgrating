@extends('layout.common.common')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img src="{{ asset('/images/site/top.png') }}" alt="hashimu-icon}">
            </div>
        </div>
    </div>

@endsection

@include('layout.common.header')
@include('layout.common.footer')
