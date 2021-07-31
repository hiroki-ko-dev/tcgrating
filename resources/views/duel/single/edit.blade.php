@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="bg-links-blue text-white rounded p-3 mb-3">
        <h2>{{ __('1vs1対戦(対戦ページ)') }}</h2>
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
                                    <div class="post-body">{{date('Y/m/d H:i', strtotime($duel->eventDuel->event->date.' '.$duel->eventDuel->event->start_time))}}</div>
                                </div>
                            </div>
                        </div>

                      <div class="card-header">{{ __('対戦ゲーム') }}</div>
                      <div class="card-body">
                        @if($duel->game_id == config('assets.site.game_ids.yugioh_duellinks'))
                          <div class="font-weight-bold">{{ __('遊戯王デュエルリンクス') }}</div>
                        @elseif($duel->game_id == config('assets.site.game_ids.yugioh_ocg'))
                          <div class="font-weight-bold">{{ __('遊戯王OCG リモート対戦') }}</div>
                        @elseif($duel->game_id == config('assets.site.game_ids.pokemon_card'))
                          <div class="font-weight-bold">{{ __('ポケモンカード リモート対戦') }}</div>
                        @endif
                      </div>

                      @if($duel->game_id == config('assets.site.game_ids.yugioh_duellinks'))
                        <div class="card-header">{{ __('ルームID') }}</div>
                        <div class="card-body">
                          <div class="form-group row">
                            <div class="col-md-12">
                              <input id="room_id" type="number" class="form-control w-100 @error('room_id') is-invalid @enderror" name="room_id" value="{{ old('room_id',$duel->room_id) }}" required autocomplete="room_id" autofocus>
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
                                    <input id="watching_id" type="number" class="form-control w-100 @error('watching_id') is-invalid @enderror" name="watching_id" value="{{ old('watching_id',$duel->watching_id) }}" >
                                    @error('watching_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                      @else
                        <div class="card-header">{{ __('対戦ツール') }}</div>
                        <div class="card-body">
                          <div class="d-flex flex-row mb-3">
                            <div class="w-30">{{ __('ツール名') }}</div>
                            <div class="w-70">
                              <select id="tool_id" name="tool_id" class="form-control">
                                @foreach(config('assets.duel.tool') as $key => $tool)
                                  <option value="{{$key}}"
                                          @if(old('tool_id') == $key)
                                          selected
                                    @endif
                                  >{{$tool}}</option>
                                @endforeach
                              </select>
                              @error('tool_id')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="d-flex flex-row mb-3">
                            <div class="w-30">{{ __('対戦コード') }}</div>
                            <div class="w-70">
                              <input id="tool_code" type="text" placeholder="※後から編集できます" class="form-control w-100 @error('tool_code') is-invalid @enderror" name="tool_code" value="{{ old('tool_code', $duel->tool_code) }}" autofocus>
                              @error('tool_code')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                        </div>
                      @endif


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
