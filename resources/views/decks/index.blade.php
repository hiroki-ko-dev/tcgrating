@extends('layouts.common.common')

@section('title','デッキ一覧')

@section('description')
  <meta name="description" content="ポケモンカードのデッキ構築一覧です。最新環境の構築をまとめています。"/>
@endsection

@section('addCss')
  @vite(['resources/scss/decks/deck-index.scss'])
@endsection

@section('content')
  <div class="container">

    <div class="row justify-content-center m-1 mb-3">
      <div class="col-12 page-header">
        <div class="d-flex flex-row">
          <div class="col-6">
            @if ($tagName)
              <h3>{{$tagName}}のデッキ構築</h1>
            @else
              <h3>{{ __('デッキ一覧') }}</h1>
            @endif
          </div>
          @if(Auth::check() && Auth::id() == 1)
            <div class="col-6">
              <button class="btn site-color text-white btn-outline-secondary text-center w-100"
                onclick="location.href='/decks/create'">
                {{ __('+ 新規作成') }}
              </button>
            </div>
          @endif
        </div>
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

    @foreach($decks as $deck)
      <div class="card">
        <div class="row justify-content-center">
          <div class="col-sm-10">
            <div class="deck-title">{{$deck->date}} {{$deck->name}} {{$deck->rank}}位</div>
            <div class=deck-tag-box>
              @foreach($deck->tags as $tag)
                <span class="deck-tag" onClick="location.href='/decks/?deck_tag_id={{$tag->id}}'">{{$tag->name}}</span>
              @endforeach
            </div>
            <div class="deck-image-box">
              <img class="deck-image" src="{{$deck->imageUrl}}" alt="hashimu-icon">
            </div>
            <div class="deck-code">デッキコード：　<a target="brank" href="https://www.pokemon-card.com/deck/confirm.html/deckID/{{$deck->code}}">{{$deck->code}}</a></div>
          </div>
        </div>
      </div>
    @endforeach

    <div class="d-flex justify-content-center mb-4">
      {{$decks->links('pagination::bootstrap-4')}}
    </div>
  </div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')