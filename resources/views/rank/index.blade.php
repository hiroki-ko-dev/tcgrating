@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="bg-links-blue text-white rounded p-3 mb-3">
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
                            @foreach($users as $i => $user)
                                <tr>
                                    <td scope="col">{{$users->firstItem()+$i}}</td>
                                    <td scope="col">{{$user->id}}</td>
                                    <td scope="col">{{$user->name}}</td>
                                    <td scope="col">{{$user->rate_yugioh_links}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{$users->links('pagination::bootstrap-4')}}
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
