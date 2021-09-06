@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="bg-site-black text-white rounded p-3 mb-3">
        <h2>{{ __('新規1vs1対戦編集') }}</h2>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="POST" action="/event/single/{{$event->id}}">
                    @csrf
                    @method('PUT')

                    <div class="card-header">{{ __('配信URL') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="stream_url" type="text" class="form-control w-100 @error('stream_url') is-invalid @enderror" name="stream_url" value="{{ old('stream_url',$event->eventUsers->where('user_id',Auth::id())->first()->stream_url) }}" required autocomplete="stream_url" autofocus>
                                @error('stream_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-5 mb-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('保存する') }}
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
@include('layouts.common.google')
@include('layouts.common.footer')
