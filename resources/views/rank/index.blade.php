@extends('layouts.common.common')

@section('title','ランキング')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

@section('twitterHeader')
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@pokekaInfo" />
  <meta name="twitter:title" content="ポケカ掲示板" />
  <meta name="twitter:description" content="ポケカのデッキ相談・ルール質問・雑談などを掲示板で話しましょう！" />
  <meta name="twitter:image" content="{{env('APP_URL')}}/images/duel/twitter_thumb.png" />
@endsection

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
                  @if(isset($rate->user))
                    <tr>
                      <td scope="col" class="align-middle">
                        @if($rates->firstItem()+$i <= 4)
                          <img style="width:50px;" src="/images/icon/rank/{{$rates->firstItem()+$i}}.png">
                        @else
                          {{$rates->firstItem()+$i}}
                        @endif
                      </td>
                      <td scope="col" class="align-middle">
                          <img src="{{$rate->user->twitter_simple_image_url}}" class="rounded-circle"
                               onerror="this.src='{{ asset('/images/icon/default-account.png') }}'"
                          >
                      </td>
                      <td scope="col" class="text-left align-middle">
                        <a href="/user/{{$rate->user->id}}">{{$rate->user->name}}</a>
                      </td>
                      <td scope="col" class="align-middle">{{$rate->rate}}</td>
                    </tr>
                  @endif
                @endforeach
                </tbody>
            </table>
        </div>
      </div>
      {{$rates->links('layouts.common.pagination.bootstrap-4')}}
    </div>
  </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
