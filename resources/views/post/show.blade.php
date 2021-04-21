@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="text-center alert-danger rounded p-3 mb-3 col-md-7Z">
                {{ session('flash_message') }}
            </div>
        @endif
    </div>
    @include('layouts.post.post_and_comment')
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.adsense')
@include('layouts.common.footer')
