@extends('layouts.common.common')

@section('content')
    <div class="container border pt-3">
        <div class="row pt-10 pb-5">
            <div class="col-md-6">
                以下の動画にて当サイトの使い方説明をご視聴ください。<br>質問やバグ報告は動画のコメント欄にしてもらって大丈夫です！<br>
            </div>
        </div>
        <div class="row pt-10 pb-5">
            <div class="col-md-6">
                <a href="https://youtu.be/rC7oJXnaqLQ">アカウント作成・フリー掲示板の使い方動画</a><br>
            </div>
        </div>

        <div class="row pt-10 pb-5">
            <div class="col-md-6">
                <a href="https://youtu.be/AIGXd5wprpo">チーム作成・チームメンバー募集掲示板の使い方</a><br>
            </div>
        </div>

        <div class="row pt-10 pb-5">
            <div class="col-md-6">
                <a href="https://youtu.be/PJ8rJ5rwuhg">1vs1対戦の使い方動画</a><br>
            </div>
        </div>
    </div>
@endsection


@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
