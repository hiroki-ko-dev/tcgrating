@section('footer')

<footer class="footer pt-3" id="footer">
    <div class="footer-bottom">
        <div class="container">
            <ul>
                <li><a href="/administrator">管理人について</a></li>
                <li><a href="">お問い合わせ</a></li>
            </ul>
            <div class="footer-copyright">Copyright (C) 2021 Hashimu All Rights Reserved.</div>
        </div>
    </div>
</footer>
<script src="{{ asset('js/jquery.slim.min.js')}}"></script>
<script src="{{ asset('js/popper.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/jquery.home.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/assets/pages/index.js')}}"></script>

<script>
    //カレンダー機能の実装
    $("#datepicker").datepicker({
        dateFormat: 'yy/mm/dd',
    });

    $(document).ready( function(){

        var today = new Date();

        var year   = today.getFullYear();
        var month  = today.getMonth()+1
        var day    = today.getDate();

        //日・時・分を取得
        var hour   = today.getHours();
        var minute = today.getMinutes();

        document.getElementById( "datepicker" ).value = year + "/" + month + "/" + day ;
        document.getElementById( 'time' ).value = hour + ":" + minute ;
    });
</script>

@endsection
