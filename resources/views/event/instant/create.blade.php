@extends('layouts.common.common')

@section('addJs')
  <script src="{{mix('/js/common/calendar.js')}}" defer></script>
  <script src="{{mix('/js/duel/duel.js')}}" defer></script>
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('リモートポケカレーティング') }}
    </div>
  </div>
  <form method="POST" action="/event/instant/store">
    @csrf

    <div class="row justify-content-center mb-4">
      <div class="col-12">
        <div class="box">
          <div class="box-header text-left">{{ __('レーティングサイト使用方法') }}</div>
          <div class="font-weight-bold text-left">{{ __('① Twitterログイン') }}</div>
          <div class="font-weight-bold text-left">{{ __('② 対戦相手にURLを共有') }}</div>
          <div class="font-weight-bold text-left">{{ __('③ 対戦結果報告(勝者のみ)') }}</div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mb-4">
      <div class="col-12">
        <div class="box">
          <div class="box-header text-left">{{ __('① Twitterログイン') }}</div>
          @if(Auth::check())
            <div class="font-weight-bold text-left">{{ __('Twitterログイン済です。') }}</div>
          @else
            <div class="font-weight-bold text-left">{{ __('Twitterログインできていません。以下ボタンからログインしてください') }}</div>
            <a href="/auth/twitter/login"><img class="img-fluid" src="{{ asset('/images/site/twitter/relation.png') }}" alt="hashimu-icon"></a>
          @endif
        </div>
      </div>
    </div>

    <div class="row justify-content-center mb-4">
      <div class="col-12">
        <div class="box">
            <div class="box-header text-left">{{ __('対戦ツール') }}</div>
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
              {{ __('※なんでもよければデフォルトのこのサイト専用Discordサーバーがオススメ') }}
            </div>
            <div class="d-flex flex-row mb-3 text-secondary">
              {{ __('※ツールの招待URL、フレンドコード等を記載してください') }}
            </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center  mb-0">
      @if(Auth::check())
        <button type="submit" class="btn site-color text-white rounded-pill btn-outline-secondary text-center pl-4 pr-4">
          {{ __('対戦を作成') }}
        </button>
      @else
        <div>
          <h5>Twitterログインしていないため対戦の作成ができません。</h5>
          <h5 class="font-weight-bold text-danger">「① Twitterログイン」 からログインしくてださい。</h5>
        </div>
      @endif
    </div>
  </form>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
