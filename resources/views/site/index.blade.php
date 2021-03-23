@extends('layouts.common.common')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img class="img-responsive" src="{{ asset('/images/site/top.jpg') }}" alt="hashimu-icon}">
            </div>
        </div>
    </div>

@endsection

@include('layouts.common.header')
@include('layouts.common.footer')
