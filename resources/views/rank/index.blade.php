@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('ランキング') }}
    </div>
  </div>

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-md-12">
        <div class="text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
        </div>
      </div>
    @endif
  </div>

  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="box">
        <div class="card-text border-bottom p-2">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">順位</th>
                    <th scope="col"></th>
                    <th scope="col" class="text-left">name</th>
                    <th scope="col">rate</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rates as $i => $rate)
                    <tr>
                        <td scope="col" class="align-middle">
                          @if($i < 4)
                            <img style="width:50px;" src="/images/icon/rank/{{$rates->firstItem()+$i}}.png">
                          @else
                            {{$rates->firstItem()+$i}}
                          @endif
                        </td>
                        <td scope="col" class="align-middle"><img src="{{$rate->user->twitter_simple_image_url}}" class="rounded-circle"></td>
                      <td scope="col" class="text-left align-middle">
                        <a href="/user/{{$rate->user->id}}">{{$rate->user->name}}</a>
                      </td>
                        <td scope="col" class="align-middle">{{$rate->rate}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
      </div>
      {{$rates->links('pagination::bootstrap-4')}}
    </div>
  </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
