@section('tag_manager_head')
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K9V6S2S3');</script>
  <!-- End Google Tag Manager -->
@endsection

@section('analitics')
    {{-- <!-- Global site tag (gtag.js) - Google Analytics -->
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

    </script> --}}
  
@endsection


@section('tag_manager_body')
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K9V6S2S3"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
@endsection

@section('adsense')
    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9246343628014182"
        crossorigin="anonymous"></script>

    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
@endsection
