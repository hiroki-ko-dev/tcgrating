@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if(!empty($posts))
                        @foreach($posts as $post)
                            {{$user->id}}
                        @endforeach
                    @endif
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.adsense')
@include('layouts.common.footer')
