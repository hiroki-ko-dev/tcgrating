@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(\App\Models\PostCategory::FREE == $post_category_id)
                    {{ __('自由掲示板') }}
                    @endif
                </div>

                <div class="card-body">
                    <form method="POST" action="/post">
                        @csrf
                        <input type="hidden" name="post_category_id" value="{{$post_category_id}}">

                        <div class="form-group row">
                            <label for="title" class="col-md-0 col-form-label text-md-right">{{ __('件名') }}</label>

                            <div class="col-md-11">
                                <input id="title" type="text" class="form-control w-100 @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-0 col-form-label text-md-right">{{ __('内容') }}</label>

                            <div class="col-md-11">
                                <textarea id="body" type="body" class="form-control @error('body') is-invalid @enderror" name="body" value="{{ old('body') }}" required autocomplete="body"></textarea>

                                @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.adsense')
@include('layouts.common.footer')