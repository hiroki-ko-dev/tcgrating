@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="col-md-8 offset-md-4">
                <a class="btn btn-link" href="post/create?category_id=0">
                    {{ __('新規スレッド作成') }}
                </a>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if(!empty($posts))
                        @foreach($posts as $post)
                            {{$user->id}}
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.adsense')
@include('layouts.common.footer')
