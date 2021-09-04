@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="bg-site-black text-white rounded p-3 mb-3">
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

    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
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
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('ルームID') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-body">{{$duel->room_id}}
                                @if($duel->duelUser[0]->user_id == Auth::id())
                                    （<a href="/duel/single/{{$duel->id}}/edit">編集する</a>）
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.post.post_and_comment')

    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('決闘詳細') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="post-user"> {{$duel->duelUser[0]->user->name}} vs @if(isset($duel->duelUser[1])){{$duel->duelUser[1]->user->name}}@else対戦相手待ち@endif</div>
                            @if($duel->number_of_games < $duel->games_number)
                                <div class="body">対戦回数：{{$duel->number_of_games}}　※決闘終了です。お疲れ様でした</div>
                            @else
                                <div class="body">対戦回数：{{$duel->number_of_games}}　（現在{{ $duel->games_number }}試合目）※試合を開始してページ下部で結果を報告してください</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">対戦回数</th>
                                <th scope="col">{{$duel->duelUser[0]->user->name}}報告内容</th>
                                <th scope="col">{{$duel->duelUser[1]->user->name}}報告内容</th>
                            </tr>
                            </thead>
                            @for($i = 1; $i < $duel->number_of_games + 1; $i++)
                                <tr>
                                    <td>{{$i}}</td>
                                    @isset($duel->duelUser[0]->duelUserResult->where('games_number',$i)->first()->result)
                                        @switch($duel->duelUser[0]->duelUserResult->where('games_number',$i)->first()->result)
                                            @case(\App\Models\DuelUserResult::WIN)
                                            <td>{{ __('勝利') }}</td>
                                            @break
                                            @case(\App\Models\DuelUserResult::LOSE)
                                            <td>{{ __('敗北') }}</td>
                                            @break
                                            @case(\App\Models\DuelUserResult::DRAW)
                                            <td>{{ __('ドロー') }}</td>
                                            @break
                                            @default
                                            <td>{{ __('無効試合') }}</td>
                                        @endswitch
                                    @else
                                        <td>-</td>
                                    @endif
                                    @isset($duel->duelUser[1]->duelUserResult->where('games_number',$i)->first()->result)
                                        @switch($duel->duelUser[1]->duelUserResult->where('games_number',$i)->first()->result)
                                            @case(\App\Models\DuelUserResult::WIN)
                                            <td>{{ __('勝利') }}</td>
                                            @break
                                            @case(\App\Models\DuelUserResult::LOSE)
                                            <td>{{ __('敗北') }}</td>
                                            @break
                                            @case(\App\Models\DuelUserResult::DRAW)
                                            <td>{{ __('ドロー') }}</td>
                                            @break
                                            @default
                                            <td>{{ __('無効試合') }}</td>
                                        @endswitch
                                    @else
                                        <td>-</td>
                                    @endif
                                </tr>
                            @endfor

                        </table>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <a href="/event/single/{{$duel->eventDuel->event->id}}">受付ページに戻る</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ $duel->games_number }} {{ __('試合目　ー　対戦結果報告') }}
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            {{ __('※お互いの報告結果が違うと無効試合となります。注意してください') }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <form method="POST" action="/duel/single" onClick="return requestConfirm();">
                                @csrf
                                <input type="hidden" name="duel_id" value="{{$duel->id}}">
                                <span class="col-md-3 ">
                                    <input type="submit" class="btn btn-primary" name="win" value="　勝利　">
                                </span>
                                <span class="col-md-7">
                                    <input type="submit" class="btn btn-danger" name="lose" value="　敗北　">
                                </span>
                                <span class="col-md-7">
                                    <input type="submit" class="btn btn-secondary" name="draw" value="　ドロー">
                                </span>
                                <span class="col-md-10">
                                    <input type="submit" class="btn btn-secondary" name="invalid" value="無効試合">
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
