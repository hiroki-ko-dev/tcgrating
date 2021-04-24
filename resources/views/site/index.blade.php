@extends('layouts.common.common')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img class="img-fluid" src="{{ asset('/images/site/top.jpg') }}" alt="hashimu-icon">
            </div>
        </div>
    </div>

@endsection


@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
