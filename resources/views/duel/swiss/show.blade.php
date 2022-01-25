@extends('layouts.common.common')

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

  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      第{{$duels[0]->match_number}}試合
    </div>
  </div>

  @foreach($duels as $duel)
    <div class="row justify-content-center row-eq-height mb-4">
      <div class="col-12">
        <div class="site-color text-white text-center">大会対戦{{$duel->room_id}}（
          @if($duel->status == \App\Models\Duel::STATUS_READY)
            対戦中
          @elseif($duel->status == \App\Models\Duel::STATUS_FINISH)
            対戦完了
          @else
            キャンセル
          @endif
        ）
        </div>
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
                        <input type="submit" class="btn btn-primary rounded-pill btn-outline-dark text-light" name="win" value="　勝利　">
                      </span>
                      <span class="col-md-7">
                        <input type="submit" class="btn btn-secondary rounded-pill btn-outline-dark text-light" name="draw" value="　ドロー">
                      </span>
                    </form>
                  </div>
                @endif
              @endif
              <img src="{{$duel->duelUsers[0]->user->twitter_simple_image_url}}" class="rounded-circle">
              <a href="/user/{{$duel->duelUsers[0]->user_id}}">{{$duel->duelUsers[0]->user->name}}</a>
                大会レート：{{$duel->eventDuel->event->eventUsers->where('user_id',$duel->duelUsers[0]->user_id)->first()->event_rate}}
            </div>
            <div class="col-md-12 m-1 pt-2 pb-2"><img src="/images/duel/vs.jpg"></div>
            <div class="col-md-12">
              <img src="{{$duel->duelUsers[1]->user->twitter_simple_image_url}}" class="rounded-circle">
              <a href="/user/{{$duel->duelUsers[1]->user_id}}">{{$duel->duelUsers[1]->user->name}}</a>
                大会レート：{{$duel->eventDuel->event->eventUsers->where('user_id',$duel->duelUsers[1]->user_id)->first()->event_rate}}

              @if(Auth::check() && $duel->status == \App\Models\Duel::STATUS_READY)
                @if(Auth::check() && (Auth::user()->can('eventRole',$duel->eventDuel->event->id) || Auth::id() == $duel->duelUsers[1]->user_id))
                  <div class="mt-2">
                    <form method="POST" action="/duel/swiss/{{$duel->id}}" onClick="return requestConfirm();">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="user_id" value="{{$duel->duelUsers[1]->user_id}}">
                      <span class="col-md-3 ">
                        <input type="submit" class="btn btn-primary rounded-pill btn-outline-dark text-light" name="win" value="　勝利　">
                      </span>
                      <span class="col-md-7">
                        <input type="submit" class="btn btn-secondary rounded-pill btn-outline-dark text-light" name="draw" value="　ドロー">
                      </span>
                    </form>
                  </div>
                @endif
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="box">
        <div class="box-header text-left">{{ __('公式対戦ルール') }}</div>
        <div class="text-left">{{ __('対戦回数：両者で回数を決定してください') }}</div>
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
