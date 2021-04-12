@section('adsense')

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle"
         style="display:block; text-align:center;"
         data-ad-layout="in-article"
         data-ad-format="fluid"
         data-ad-client="ca-pub-9125683895360901"
         data-ad-slot="6401800863"></ins>
{{--    <script>--}}
{{--        (adsbygoogle = window.adsbygoogle || []).push({});--}}
{{--    </script>--}}
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

    <!-- Global site tag (gtag.js) - Google Analytics -->
{{--    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XFDXK7PGHL"></script>--}}
{{--    <script>--}}
{{--        window.dataLayer = window.dataLayer || [];--}}
{{--        function gtag(){dataLayer.push(arguments);}--}}
{{--        gtag('js', new Date());--}}

{{--        gtag('config', 'G-XFDXK7PGHL');--}}
{{--    </script>--}}
@endsection
