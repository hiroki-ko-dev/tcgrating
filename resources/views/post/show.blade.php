@extends('layouts.common.common')

@section('content')
<div class="container">
    @include('layouts.post.post_and_comment')
</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.adsense')
@include('layouts.common.footer')
