@section('footer')
      </div>
    </main>
    <footer class="footer" id="footer">
      <div class="footer-top">
        <div class="container">
          <div class="footer-top--wrap"><a href="/">{{config('origin.site.title')}}</a>
            <div class="footer-top-link"><ul>
<li><a href="/administrator">管理者について</a></li>
<li><a href="/organizer/login">ログイン</a></li>
<li><a href="/organizer/help">ヘルプ</a></li>
<li><a href="mailto:support@mice-platform.com">お問い合わせ</a></li>
</ul>
<ul>
<li><a href="/organizer/home/#rankingArea">ランキング</a></li>
<li><a href="/organizer/home/#featureArea">特集記事一覧</a></li>
<li><a href="/organizer/home/#formArea">会場検索</a></li>
<li><a href="/organizer/terms" target="_blank">利用規約</a></li>
</ul>
<ul>
<li><a href="/organizer/company/">会社概要</a></li>
<li><a href="/organizer/topmessage">トップメッセージ</a></li>
<li><a href="/organizer/partnership">パートナーシッププログラム</a></li>
</ul>
            </div><a href="/venue/introduction/"><img src="images/lp1/footer.png" alt="会場のご担当者さま 会場リアルタイム予約の「MICE Platform」で高い稼働率を実現しませんか？"></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container"><ul>
<li><a href="https://www.mice-platform.com/organizer/company/">運営会社</a></li>
<li><a href="http://www.softbank.jp/corp/group/sbiv/security/">情報セキュリティポリシー</a></li>
<li><a href="http://www.softbank.jp/corp/group/sbiv/privacy/">個人情報の取り扱いについて</a></li>
<li><a href="/organizer/law">特定商取引法に基づく表示</a></li>
<li>メディア掲載</li>
<li>利用企業</li>
</ul>
          <div class="footer-copyright">Copyright (C) 2018 MICE Platform. All Rights Reserved.</div>
        </div>
      </div>
    </footer>
    <script src="{{ asset('js/jquery.slim.min.js')}}"></script>
    <script src="{{ asset('js/popper.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/jquery.home.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/assets/pages/index.js')}}"></script></body>
</html>
@endsection
