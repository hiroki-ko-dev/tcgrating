@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">
                  <div class="text-left">プライバシーポリシー</div>
                  <div class="text-right">記事更新日: 2022/09/26</div>
                </div>

                <div class="card-body pt-3">
                  本ページはTcgRatingサイトのプライバシーポリシーです。<br>
                  TcgRatingはトレーディングカードゲームのリモート対戦を支援するサイトです。<br>
                  ユーザー間の問題等については関与できませんので、当事者同士で解決をお願いいたしますので、ご同意の上、サイトをご利用ください。<br>
                </div>

              <div class="card-header">
                <div class="text-left">個人情報の利用目的</div>
              </div>
              <div class="card-body pt-3">
                当サイトでは、メールでのお問い合わせなどの際に、名前（ハンドルネーム）、メールアドレス等の個人情報をご登録いただく場合がございます。
                これらの個人情報は質問に対する回答や必要な情報を電子メールなどをでご連絡する場合に利用させていただくものであり、個人情報をご提供いただく際の目的以外では利用いたしません。<br>
              </div>

              <div class="card-header">
                <div class="text-left">個人情報の第三者への開示</div>
              </div>
              <div class="card-body pt-3">
                当サイトでは、個人情報は適切に管理し、以下に該当する場合を除いて第三者に開示することはありません。<br>
                ・本人のご了解がある場合<br>
                ・法令等への協力のため、開示が必要となる場合<br>
                ご本人からの個人データの開示、訂正、追加、削除、利用停止のご希望の場合には、ご本人であることを確認させていただいた上、速やかに対応させていただきます。<br>
              </div>

              <div class="card-header">
                <div class="text-left">広告の配信について</div>
              </div>
              <div class="card-body pt-3">
                当サイトは第三者配信の広告サービス（Google Adsense グーグルアドセンス、もしもアフィリエイト、バリューコマース アフィリエイト）を利用しています。<br>
                広告配信事業者は、ユーザーの興味に応じた広告を表示するためにCookie（クッキー）を使用することがあります。<br>
                Cookie（クッキー）を無効にする設定およびGoogleアドセンスに関する詳細は「広告 – ポリシーと規約 – Google」をご覧ください。<br>
                第三者がコンテンツおよび宣伝を提供し、訪問者から直接情報を収集し、訪問者のブラウザにCookie（クッキー）を設定したりこれを認識したりする場合があります。<br>
              </div>

              <div class="card-header">
                <div class="text-left">Amazonアソシエイト</div>
              </div>
              <div class="card-body pt-3">
                当サイトは、Amazon.co.jpを宣伝しリンクすることによってサイトが紹介料を獲得できる手段を提供することを目的に設定されたアフィリエイトプログラムである、Amazonアソシエイト・プログラムの参加者です。
                Amazonのアソシエイトとして、当サイト管理者は適格販売により収入を得ています。<br>
              </div>

              <div class="card-header">
                <div class="text-left">免責事項</div>
              </div>
              <div class="card-body pt-3">
                当サイトで掲載している画像の著作権・肖像権等は各権利所有者に帰属致します。権利を侵害する目的ではございません。記事の内容や掲載画像等に問題がございましたら、各権利所有者様本人が直接メールでご連絡下さい。確認後、対応させて頂きます。

                当サイトからリンクやバナーなどによって他のサイトに移動された場合、移動先サイトで提供される情報、サービス等について一切の責任を負いません。

                当サイトのコンテンツ・情報につきまして、可能な限り正確な情報を掲載するよう努めておりますが、誤情報が入り込んだり、情報が古くなっていることもございます。

                当サイトに掲載された内容によって生じた損害等の一切の責任を負いかねますのでご了承ください。<br>
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
