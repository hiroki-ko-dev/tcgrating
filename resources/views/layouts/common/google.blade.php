@section('tag_manager_head')
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PMHCL93');</script>
    <!-- End Google Tag Manager -->
@endsection

@section('analitics')
{{--    <!-- Global site tag (gtag.js) - Google Analytics -->--}}
{{--    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XFDXK7PGHL"></script>--}}
{{--    <script>--}}
{{--        window.dataLayer = window.dataLayer || [];--}}
{{--        function gtag(){dataLayer.push(arguments);}--}}
{{--        gtag('js', new Date());--}}

{{--        gtag('config', 'G-XFDXK7PGHL');--}}

{{--        ga('create', 'UA-xxxxxxx-1', 'auto');--}}
{{--        ga('set', '&uid', 'User-ID');--}}
{{--        ga('send', 'pageview');--}}
{{--    </script>--}}


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-108878672-4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-108878672-4');
    </script>

@endsection


@section('tag_manager_body')
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PMHCL93"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
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
            google_ad_client: "ca-pub-9125683895360901",
            enable_page_level_ads: true,
            overlays: {bottom: true}
        });
    </script>
@endsection
