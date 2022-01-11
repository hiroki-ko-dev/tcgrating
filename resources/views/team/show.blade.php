@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="site-color text-white rounded p-3 mb-3">
        <h3>{{ __('チームページ') }}</h3>
    </div>

    <div class="row justify-content-center">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="text-center alert-danger rounded p-3 mb-3 col-md-7Z">
                {{ session('flash_message') }}
            </div>
        @endif
    </div>

    @if($team->teamUser->where('user_id',Auth::id())->first() && $team->teamUser->where('user_id',Auth::id())->first()->status == \App\Models\TeamUser::MASTER)
        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('リクエスト待ちユーザー') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <form method="POST" name="form" action="/team/user">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="team_id" value="{{$team->id}}">
                                    @foreach($team->teamUser as $teamUser)
                                        <div type="body">
                                            @if($teamUser->status === \APP\Models\TeamUser::REQUEST)
                                                <a href="/user/{{$teamUser->user->id}}">{{$teamUser->user->name}}</a>
                                                <input type="button" name="approval" value="承認" onClick="approvalCheck({{$teamUser->user->id}});">
                                                <input type="button" name="reject" value="却下" onClick="rejectCheck({{$teamUser->user->id}});">
                                            @endif
                                        </div>
                                    @endforeach
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 offset-md-4">
                <a class="btn btn-link text-center" href="/team/{{$team->id}}/edit">
                    {{ __('編集する') }}
                </a>
            </div>
            <div class="col-md-8 offset-md-4">
                <a class="btn btn-link text-center" href="/post/create?post_category_id=4&team_id={{$team->id}}">
                    {{ __('チームメンバー募集掲示板に投稿する') }}
                </a>
            </div>
        </div>
    @endif

    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('チーム名') }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div type="body">{{$team->name}}</div>
                        </div>
                    </div>
                </div>

                <div class="card-header">{{ __('プロフィール文') }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div type="body">{!! nl2br(e($team->body)) !!}</div>
                        </div>
                    </div>
                </div>

                <div class="card-header">{{ __('レート') }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div type="body">{{$team->rate}}</div>
                        </div>
                    </div>
                </div>

                <div class="card-header">{{ __('チーム募集ステータス') }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div type="body">
                                @if($team->recruit_status == \App\Models\Team::STATUS_RECRUIT)
                                    <form method="POST" action="/team/user">
                                        @csrf
                                        <input type="hidden" name="team_id" value="{{$team->id}}">
                                        <span class="col-md-2">
                                            募集中
                                        </span>
                                        @if(Auth::check() && !($team->teamUser->where('user_id',Auth::id())->first()))
                                            <span class="col-md-4">
                                                <button type="submit" class="btn btn-primary" name="join_request" value="1">
                                                    {{ __('参加希望を出す') }}
                                                </button>
                                            </span>
                                        @endif
                                    </form>
                                @else
                                    募集していない
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header">{{ __('チームメンバー') }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div type="body">
                                @foreach($team->teamUser as $teamUser)
                                    @if($teamUser->status == \App\Models\TeamUser::APPROVAL || $teamUser->status == \App\Models\TeamUser::MASTER)
                                        <div><a href="/user/{{$teamUser->user->id}}">{{$teamUser->user->name}}</a>
                                            @if($teamUser->status == \App\Models\TeamUser::MASTER)（チームマスター）@endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.post.post_and_comment')
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
