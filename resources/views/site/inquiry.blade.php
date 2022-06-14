@extends('layouts.common.common')

@section('title','お問合せ')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

@section('content')
    <div class="container border">
        <div class="row pt-10 pb-5">
            <div class="col-md-2">
            </div>
            <div class="col-md-6">
                お問い合わせ・バグ修正依頼はこちらの動画のコメント欄まで<br><br>
                <a class="navbar-brand" href="https://youtu.be/rC7oJXnaqLQ">お問い合わせ用動画</a><br>
            </div>
        </div>
    </div>
@endsection


@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
