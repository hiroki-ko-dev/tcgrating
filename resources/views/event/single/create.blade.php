@extends('layouts.common.common')

@section('addJs')
  <script src="{{mix('/js/common/calendar.js')}}" defer></script>
  <script src="{{mix('/js/duel/duel.js')}}" defer></script>
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('新規1vs1対戦作成') }}
    </div>
  </div>
  <form method="POST" action="/event/single">
    @csrf
    <div class="row justify-content-center mb-4">
      <div class="col-12">
        <div class="box">
          <div class="box-header">{{ __('対戦開始日時') }}</div>
          <div class="form-group row">
            <div class="col-sm-6">
              <input type="text" id="datepicker" class="form-control w-100 @error('date') is-invalid @enderror" name="date" >{{ old('date') }}</input>
              @error('date')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="col-sm-6">
              <input type="time" id="start_time" class="form-control w-100 @error('start_time') is-invalid @enderror" name="start_time" >{{ old('start_time') }}</input>
              @error('start_time')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-sm-6 mb-4">
        <div class="box">
          <div class="box-header">{{ __('対戦回数') }}</div>
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
      </div>
      <div class="col-sm-6 mb-4">
        <div class="box">
          <div class="box-header">{{ __('対戦ゲーム') }}</div>
          <div class="card-body">
            @if(Auth::user()->selected_game_id == config('assets.site.game_ids.yugioh_duellinks'))
              <div class="font-weight-bold">{{ __('遊戯王デュエルリンクス') }}</div>
            @elseif(Auth::user()->selected_game_id == config('assets.site.game_ids.yugioh_ocg'))
              <div class="font-weight-bold">{{ __('遊戯王OCG リモート対戦') }}</div>
            @elseif(Auth::user()->selected_game_id == config('assets.site.game_ids.pokemon_card'))
              <div class="font-weight-bold">{{ __('ポケモンカード リモート対戦') }}</div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mb-4">
      <div class="col-12">
        <div class="box">
          @if(Auth::user()->selected_game_id == config('assets.site.game_ids.yugioh_duellinks'))
            <div class="box-header">{{ __('デュエルリンクス対戦ID') }}</div>
            <div class="d-flex flex-row mb-3">
              <div class="w-30">{{ __('ルームID') }}</div>
              <div class="w-70">
                <input id="room_id" type="number" placeholder="※後から編集できます" class="form-control w-100 @error('room_id') is-invalid @enderror" name="room_id" value="{{ old('room_id') }}" required autocomplete="room_id" autofocus>
                @error('room_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="d-flex flex-row mb-3">
              <div class="w-30">{{ __('観戦ID') }}</div>
              <div class="w-70">
                <input id="watching_id" type="number" placeholder="※後から編集できます" class="form-control w-100 @error('watching_id') is-invalid @enderror" name="watching_id" value="{{ old('watching_id') }}" autofocus>
                @error('watching_id')
                <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                @enderror
              </div>
            </div>
          @else
            <div class="box-header">{{ __('対戦ツール') }}</div>
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
                <input id="tool_code" type="text" placeholder="※後から編集できます" class="form-control w-100 @error('tool_code') is-invalid @enderror" name="tool_code" value="{{ old('tool_code') }}" autofocus>
                @error('tool_code')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="d-flex flex-row mb-3 text-secondary">
              {{ __('※ツールの招待URL、フレンドコード等を記載してください') }}
            </div>
            <div class="d-flex flex-row mb-3 text-secondary">
              {{ __('※書ききれない場合は詳細を一言メッセージに記載してください') }}
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="row justify-content-center mb-4">
      <div class="col-12">
        <div class="box">
        <div class="box-header">{{ __('一言メッセージ') }}</div>
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
      </div>
    </div>

    <div class="row justify-content-center  mb-0">
      <button type="submit" class="btn site-color text-white rounded-pill btn-outline-secondary text-center pl-4 pr-4">
        {{ __('新規作成') }}
      </button>
    </div>
  </form>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
