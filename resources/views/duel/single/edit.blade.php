@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="bg-links-blue text-white rounded p-3 mb-3">
        <h2>{{ __('1vs1決闘(決闘ページ)') }}</h2>
    </div>

    <div class="row justify-content-center">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="text-center alert-danger rounded p-3 mb-3 col-md-7Z">
                {{ session('flash_message') }}
            </div>
        @endif
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <form method="POST" action="/duel/single/{{$duel->id}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$duel->id}}">
                    <div class="card">

                        <div class="card-header">
                            {{ __('対戦開始時間') }}
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="post-body">{{date('Y/m/d H:i', strtotime($duel->eventDuel->event->date.' '.$duel->eventDuel->event->time))}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="card-header">{{ __('ルームID') }}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="room_id" type="number" placeholder="※編集できます。わからない場合は今は適当に入れてください。" class="form-control w-100 @error('room_id') is-invalid @enderror" name="room_id" value="{{ old('room_id',$duel->room_id) }}" required autocomplete="room_id" autofocus>
                                    @error('room_id')
                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-header">{{ __('観戦ID') }}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="watching_id" type="number" placeholder="※編集できます。わからない場合は入れないでください。" class="form-control w-100 @error('watching_id') is-invalid @enderror" name="watching_id" value="{{ old('watching_id',$duel->watching_id) }}" required autocomplete="watching_id" autofocus>
                                    @error('watching_id')
                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('保存') }}
                                </button>
                            </div>
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
