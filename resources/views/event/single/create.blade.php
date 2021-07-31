@extends('layouts.common.common')

@section('addJs')
  <script src="{{mix('/js/common/calendar.js')}}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="bg-links-blue text-white rounded p-3 mb-3">
        <h2>{{ __('新規1vs1対戦作成') }}</h2>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="POST" action="/event/single">
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

                    <div class="card-header">{{ __('対戦開始日時') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <input type="text" id="datepicker" class="form-control w-100 @error('date') is-invalid @enderror" name="date" >{{ old('date') }}</input>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <input type="time" id="start_time" class="form-control w-100 @error('start_time') is-invalid @enderror" name="start_time" >{{ old('start_time') }}</input>
                                @error('start_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-header">{{ __('対戦回数') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="number" id="number_of_games" class="form-control w-100 @error('number_of_games') is-invalid @enderror" name="number_of_games" value="{{ old('number_of_games') }}" required autocomplete="number_of_games" autofocus>
                                @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-header">{{ __('デュエルリンクス対戦ID') }}</div>
                    <div class="card-body">
                      <div class="d-flex flex-row mb-3">
                        <div class="w-30 font-weight-bold">{{ __('ルームID') }}</div>
                        <div class="w-70">
                          <input id="room_id" type="number" placeholder="※後から編集できます。わからない場合は今は適当に入れてください。" class="form-control w-100 @error('room_id') is-invalid @enderror" name="room_id" value="{{ old('room_id') }}" required autocomplete="room_id" autofocus>
                          @error('room_id')
                          <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                          @enderror
                        </div>
                      </div>
                      <div class="d-flex flex-row mb-3">
                        <div class="w-30 font-weight-bold">{{ __('観戦ID ※任意入力') }}</div>
                        <div class="w-70">
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
