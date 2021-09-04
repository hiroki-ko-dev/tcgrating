@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="bg-site-black text-white rounded p-3 mb-3">
        <h5>{{ __('ランキング') }}</h5>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-md-8">
        <div class="text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
        </div>
      </div>
    @endif
  </div>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{ __('1vs1 レートランキング') }}</div>
                <div class="card-body">
                    <div class="card-text border-bottom p-2">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">順位</th>
                                <th scope="col">id</th>
                                <th scope="col">name</th>
                                <th scope="col">rate</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rates as $i => $rate)
                                <tr>
                                    <td scope="col">{{$rates->firstItem()+$i}}</td>
                                    <td scope="col">{{$rate->user->id}}</td>
                                    <td scope="col">{{$rate->user->name}}</td>
                                    <td scope="col">{{$rate->rate}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
