@extends('layouts.common.common')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <label for="email">{{ __('Email') }}</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />

                                @if ($errors->has('email'))
                                    <span class="mt-2 text-danger">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <div class="flex items-center justify-end mt-4">
                                    <button class="btn btn-primary">
                                        {{ __('Email Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
