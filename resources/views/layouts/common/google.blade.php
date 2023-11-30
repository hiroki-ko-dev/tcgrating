@section('tag_manager_head')
{{--    <!-- Google Tag Manager -->--}}
{{--    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':--}}
{{--                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],--}}
{{--            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=--}}
{{--            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);--}}
{{--        })(window,document,'script','dataLayer','GTM-PMHCL93');</script>--}}
{{--    <!-- End Google Tag Manager -->--}}
@endsection

@section('analitics')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XFDXK7PGHL"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        @if(Auth::check())
            gtag('config', 'G-XFDXK7PGHL', {
                'user_id': '{{Auth::id()}}'
            });
        @else
            gtag('config', 'G-XFDXK7PGHL', {
                'user_id': '0'
            });
        @endif

    </script>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-108878672-4"></script>
    <script>
        //トラッキングコード
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-108878672-4');

        //user-idコード
        @if(Auth::check())
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)
                    [0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-108878672-4', 'auto');
            ga('set', '&uid', '{{Auth::id()}}'); // ログインしている user_id を使用してUser-ID を設定します。
            ga('send', 'pageview');
        @endif

    </script> --}}
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7BB8S0QLFQ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-7BB8S0QLFQ');
    </script>

@endsection


@section('tag_manager_body')
{{--    <!-- Google Tag Manager (noscript) -->--}}
{{--    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PMHCL93"--}}
{{--                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>--}}
{{--    <!-- End Google Tag Manager (noscript) -->--}}
@endsection

@section('adsense')
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    {{--    <ins class="adsbygoogle"--}}
    {{--         style="display:block; text-align:center;"--}}
    {{--         data-ad-layout="in-article"--}}
    {{--         data-ad-format="fluid"--}}
    {{--         data-ad-client="ca-pub-9125683895360901"--}}
    {{--         data-ad-slot="6401800863"></ins>--}}

    {{--広告の自動適用--}}
    {{--    <script data-ad-client="ca-pub-9125683895360901" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>--}}
    {{--画面上部のアンカー広告を無効にする処理--}}
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-9246343628014182",
            enable_page_level_ads: true,
            overlays: {bottom: true}
        });
    </script>
@endsection
