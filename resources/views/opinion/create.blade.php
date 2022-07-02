@extends('layouts.common.common')

@section('title','掲示板')

@section('description')
  <meta name="description" content="ポケモンカードの掲示板です。雑談・デッキ相談・ルール質問まで幅広い交流を行いましょう。"/>
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
        {{ __('意見送信') }}
    </div>
  </div>

  <div class="col-md-12">
      <div class="box w-100">
          <form method="POST" action="/opinion">
              @csrf

            @include('layouts.common._twitter_auth')

            <div class="row pb-4">
              <select id="type" name="type" class="type form-control mb-4">
                @foreach(\App\Models\Opinion::TYPES as $key => $type)
                  <option value="{{$key}}">カテゴリ：{{\App\Models\Opinion::TYPES[$key]}}</option>
                @endforeach
              </select>
            </div>

            <div class="row pb-4">
                <textarea id="body" type="body" placeholder="内容を書く" class="form-control @error('body') is-invalid @enderror" name="body" value="{{ old('body') }}" required autocomplete="body"
                style="height: 150px"></textarea>
                @error('body') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="row pb-4">
              <input id="title" type="text" placeholder="[任意入力]LINEオプチャでの相手の名前" class="report form-control w-100 @error('line_name') is-invalid @enderror" name="line_name" value="{{ old('line_name') }}">
              @error('line_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="row pb-4">
              <input id="twitter_name" type="text" placeholder="[任意入力]レーティングサイトでの相手の名前を入力" class="report form-control w-100 @error('twitter_name') is-invalid @enderror" name="twitter_name" value="{{ old('twitter_name') }}">
              @error('twitter_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="row pb-4">
              <input id="discord_name" type="text" placeholder="[任意入力]Discordでの相手の名前" class="report form-control w-100 @error('discord_name') is-invalid @enderror" name="discord_name" value="{{ old('discord_name') }}">
              @error('discord_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong></span> @enderror
            </div>

              <div class="row justify-content-center">
                @if(Auth::check())
                  <button type="submit" class="btn btn btn-dark rounded-pill pl-5 pr-5">
                      {{ __('送信する') }}
                  </button>
                @else
                  意見送信にはTwitterログインが必要です
                @endif
              </div>

          </form>
        </div>
    </div>
</div>

@endsection

@section('addScript')
  <script>
    // 購入数の変更
    $(document).ready(function(){
      visible();
    });

    $('#type').on('change', function() {
      visible();
    });

    function visible() {
      if ($('#type').val() == 0) {
        $('.report').hide();

      } else {
        $('.report').show();
      }
    }
  </script>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
