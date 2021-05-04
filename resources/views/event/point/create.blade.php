@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="bg-links-blue text-white rounded p-3 mb-3">
        <h2>{{ __('新規ポイントバトル決闘作成') }}</h2>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="POST" action="/event/point">
                    @csrf

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

                    <div class="card-header">{{ __('対戦日時') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-2">{{ __('開催日') }}</div>
                            <div class="col-md-3">
                                <input type="text" id="datepicker" class="form-control w-100 @error('date') is-invalid @enderror" name="date" >{{ old('date') }}</input>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">{{ __('開始時間') }}</div>
                            <div class="col-md-3">
                                <input type="time" id="start_time" class="form-control w-100 @error('start_time') is-invalid @enderror" name="start_time" >{{ old('start_time') }}</input>
                                @error('start_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">{{ __('終了日時') }}</div>
                            <div class="col-md-3">
                                <input type="time" id="end_time" class="form-control w-100 @error('end_time') is-invalid @enderror" name="end_time" >{{ old('end_time') }}</input>
                                @error('end_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-header">{{ __('募集人数') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="number" id="max_member" class="form-control w-100 @error('max_member') is-invalid @enderror" name="max_member" >{{ old('max_member') }}</input>
                                @error('max_member')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-header">{{ __('ルームID') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="room_id" type="number" placeholder="※後から編集できます。わからない場合は今は適当に入れてください。" class="form-control w-100 @error('room_id') is-invalid @enderror" name="room_id" value="{{ old('room_id') }}" required autocomplete="room_id" autofocus>
                                @error('room_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-header">{{ __('観戦ID ※任意入力') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="watching_id" type="number" placeholder="※後から編集できます。わからない場合は入れないでください。" class="form-control w-100 @error('watching_id') is-invalid @enderror" name="watching_id" value="{{ old('watching_id') }}" autofocus>

                                @error('watching_id')
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
                                {{ __('新規作成') }}
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
