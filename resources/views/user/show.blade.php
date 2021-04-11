@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="bg-links-blue text-white rounded p-3 mb-3">
        <h3>{{ __('マイページ') }}</h3>
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
            @if($user->id === Auth::id())
                <div class="col-md-8 offset-md-4">
                    <a class="btn btn-link text-center" href="/user/{{$user->id}}/edit">
                        {{ __('編集する') }}
                    </a>
                </div>

                <div class="card">
                    <div class="card-header">{{ __('メールアドレス') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div type="body">{{$user->email}}</div>
                            </div>
                        </div>
                    </div>
            @else
                <div class="card">
            @endif
                <div class="card-header">{{ __('名前') }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div type="body">{{$user->name}}</div>
                        </div>
                    </div>
                </div>

                <div class="card-header">{{ __('レート') }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div type="body">{{$user->rate}}</div>
                        </div>
                    </div>
                </div>

                <div class="card-header">{{ __('プロフィール文') }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div type="body">{!! nl2br(e($user->body)) !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.adsense')
@include('layouts.common.footer')
