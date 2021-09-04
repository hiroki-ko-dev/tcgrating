@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="bg-site-black text-white rounded p-3 mb-3">
        <h3>{{ __('チーム一覧') }}</h3>
    </div>

    <div class="row justify-content-center">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="text-center alert-danger rounded p-3 mb-3 col-md-7">
                {{ session('flash_message') }}
            </div>
        @endif
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="col-md-8 offset-md-4">
                <a class="btn btn-link text-center" href="/team/create">
                    {{ __('新規チーム作成') }}
                </a>
            </div>

            <div class="card">
                <div class="card-header">{{ __('チーム一覧') }}</div>

                <div class="card-body">
                    @if(!empty($teams))
                        @foreach($teams as $team)
                            <div class="card-text border-bottom p-2">
                                <a href="/team/{{$team->id}}">{{$team->name}}</a> (レート：{{$team->rate}}）
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            {{$teams->links('pagination::bootstrap-4')}}
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
