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

  <div class="row justify-content-center">
    {{--    <div class="col-sm-6 mb-4">--}}
    {{--      @include('layouts.user.show.mail')--}}
    {{--    </div>--}}
    @include('layouts.user.show.twitter')
  </div>


  <div class="box mb-3">
    <div class="row justify-content-center m-1 mb-3">
      <div class="col-12">
        <a href="/item/transaction/">購入履歴</a>
      </div>
    </div>
  </div>

  <div class="box mb-3">
    <div class="row justify-content-center m-1 mb-3">
      <div class="col-12">
        <a href="/item/cart/">カート一覧</a>
      </div>
    </div>
  </div>
{{--    <div class="row justify-content-center">--}}
{{--      <div class="col-6 mb-4">--}}
{{--        @include('layouts.user.show.image')--}}
{{--      </div>--}}
{{--      <div class="col-6">--}}
{{--        <div class="row justify-content-center">--}}
{{--          <div class="col-12 mb-4">--}}
{{--            @include('layouts.user.show.name')--}}
{{--          </div>--}}
{{--          <div class="col-12 mb-4">--}}
{{--            @include('layouts.user.show.rate')--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}

{{--    <div class="row justify-content-center">--}}
{{--      <div class="col-12 mb-4">--}}
{{--        @include('layouts.user.show.body')--}}
{{--      </div>--}}
{{--    </div>--}}

    <div class="row justify-content-center">
      <div class="col-12 mb-4">
        @include('layouts.user.show.event')
      </div>
    </div>

</div>

@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
