@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

@section('content')
<div class="container">

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-12">
        <div class="text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
        </div>
      </div>
    @endif
  </div>

  <div class="row justify-content-center mb-3">
    <div class="col-12 page-header">
      第{{$duels[0]->match_number}}試合
    </div>
  </div>

  @foreach($duels as $duel)
    <div class="row justify-content-center row-eq-height">
      <div class="col-12">
        <div class="site-color text-white text-center p-2">対戦卓：　大会対戦{{$duel->room_id}}（
          @if($duel->status == \App\Models\Duel::STATUS_READY)
            対戦中
          @elseif($duel->status == \App\Models\Duel::STATUS_FINISH)
            対戦完了
          @else
            キャンセル
          @endif
        ）
        </div>
      </div>
    </div>
    <div class="row justify-content-center row-eq-height mb-4">
      <div class="col-12">
        <div class="box">
          <div class="form-group row">
            <div class="col-md-12">
              @if(Auth::check() && $duel->status == \App\Models\Duel::STATUS_READY)
                @if(Auth::check() && (Auth::user()->can('eventRole',$duel->eventDuel->event->id) || Auth::id() == $duel->duelUsers[0]->user_id))
                  <div class="mb-2">
                    <form method="POST" action="/duel/swiss/{{$duel->id}}" onClick="return requestConfirm();">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="user_id" value="{{$duel->duelUsers[0]->user_id}}">
                      <span class="col-md-3 ">
                        <input type="submit" class="btn btn-primary text-light" name="win" value="　勝利　">
                      </span>
                      <span class="col-md-7">
                        <input type="submit" class="btn btn-secondary text-light" name="draw" value="　ドロー">
                      </span>
                    </form>
                  </div>
                @endif
              @endif
              <img src="{{$duel->duelUsers[0]->user->twitter_simple_image_url}}" class="rounded-circle"
                   onerror="this.src='{{ asset('/images/icon/default-account.png') }}'">
              <a href="/resume/{{$duel->duelUsers[0]->user_id}}">{{$duel->duelUsers[0]->user->name}}</a>
                大会レート：{{$duel->eventDuel->event->eventUsers->where('user_id',$duel->duelUsers[0]->user_id)->first()->event_rate}}
            </div>
            @if(isset($duel->duelUsers[1]))
              <div class="col-md-12 m-1 vs">vs</div>
              <div class="col-md-12">
                <img src="{{$duel->duelUsers[1]->user->twitter_simple_image_url}}" class="rounded-circle"
                     onerror="this.src='{{ asset('/images/icon/default-account.png') }}'">
                <a href="/resume/{{$duel->duelUsers[1]->user_id}}">{{$duel->duelUsers[1]->user->name}}</a>
                  大会レート：{{$duel->eventDuel->event->eventUsers->where('user_id',$duel->duelUsers[1]->user_id)->first()->event_rate}}

                @if(Auth::check() && $duel->status == \App\Models\Duel::STATUS_READY)
                  @if(Auth::check() && (Auth::user()->can('eventRole',$duel->eventDuel->event->id) || Auth::id() == $duel->duelUsers[1]->user_id))
                    <div class="mt-2">
                      <form method="POST" action="/duel/swiss/{{$duel->id}}" onClick="return requestConfirm();">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" value="{{$duel->duelUsers[1]->user_id}}">
                        <span class="col-md-3 ">
                          <input type="submit" class="btn btn-primary text-light" name="win" value="　勝利　">
                        </span>
                        <span class="col-md-7">
                          <input type="submit" class="btn btn-secondary text-light" name="draw" value="　ドロー">
                        </span>
                      </form>
                    </div>
                  @endif
                @endif
              </div>
            @else
              <div class="col-md-12">不戦勝</div>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="box">
        <div class="box-header text-left">{{ __('公式対戦ルール') }}</div>
        <div class="text-left">{{ __('レギュレーション：スタンダード') }}</div>
        <div class="text-left">{{ __('回線不調時は？：回線不調側を敗北としてください。どちらか判断できない時はドローです') }}</div>
      </div>
    </div>
  </div>
</div>

@endsection



@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
