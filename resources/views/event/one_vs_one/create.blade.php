@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1>{{ __('新規チーム作成') }}</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="POST" action="/event/one_vs_one">
                    @csrf

                    <div class="card-header">{{ __('タイトル') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="title" type="text" class="form-control w-100 @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-header">{{ __('一言メッセージ') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea id="body" class="form-control w-100 @error('body') is-invalid @enderror" name="body" >{{ old('body') }}</textarea>
                                @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-5">
                            <button type="submit" class="btn btn-primary">
                                {{ __('投稿') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.adsense')
@include('layouts.common.footer')
