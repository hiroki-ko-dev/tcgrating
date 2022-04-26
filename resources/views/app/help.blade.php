@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">
                  <div class="text-left">【ヘルプ】TcgRatingアプリについて</div>
                  <div class="text-right">記事更新日: 2022/04/25</div>
                </div>

                <div class="card-body pt-3">
                  本ページはTcgRatingアプリ版のヘルプページです。<br>
                  TcgRatingはトレーディングカードゲームのリモート対戦を支援するアプリです。<br>
                  ユーザー間の問題等については関与できませんので、当事者同士で解決をお願いいたしますので、ご同意の上、アプリをご利用ください。<br>
                </div>

              <div class="card-header">
                <div class="text-left">収集する情報</div>
              </div>
              <div class="card-body pt-3">
                当方が配信するアプリでは、広告配信のためにGoogle AdMob を使用する場合がございます。
                広告配信のために広告IDを取得していますが、個人を特定するためなどには使用しておりません。
                取得する情報、利用目的、第三者への提供等の詳細につきましては、以下のプライバシーポリシーのリンクよりご確認ください。<br>
                <br>
                <a href="https://policies.google.com/technologies/ads?hl=ja">AdMob（Google Inc.）</a><br>
              </div>

              <div class="card-header">
                <div class="text-left">免責事項</div>
              </div>
              <div class="card-body pt-3">
                本アプリがユーザーの特定の目的に適合すること、期待する機能・商品的価値・正確性・有用性を有すること、および不具合が生じないことについて、何ら保証するものではありません。
                当方の都合によりアプリの仕様を変更できます。私たちは、本アプリの提供の終了、変更、または利用不能、本アプリの利用によるデータの消失または機械の故障もしくは損傷、その他本アプリに関してユーザーが被った損害につき、賠償する責任を一切負わないものとします。<br>
              </div>

              <div class="card-header">
                <div class="text-left">著作権・知的財産権等</div>
              </div>
              <div class="card-body pt-3">
                著作権その他一切の権利は、当方又は権利を有する第三者に帰属します。<br>
              </div>

              <div class="card-header">
                <div class="text-left">お問合せ</div>
              </div>
              <div class="card-body pt-3">
                バグ等発生いたしましたら申し訳ございません。。。<br>
                以下のTwitterアカウントまでご連絡ください。<br>
                <br>
                バグの報告についてはエラー画面のスクリーンショットを頂いたり、可能な限り詳細に発生状況を教えて頂けるとスムーズに修正が行える可能性がございます<br>
                <br>
                <a href="https://twitter.com/remotoPokeka">運営用Twitterアカウント</a><br>
                <br>
                必ず解決するとは限りませんが、対応余裕があれば対応させて頂きます。<br>
                （返事が返せるとは限りませんので予めご了承ください。<br>
                <br>

              </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
