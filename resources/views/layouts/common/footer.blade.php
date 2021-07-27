@section('footer')

<footer class="footer pt-3" id="footer">
    <div class="footer-bottom">
        <div class="container">
            <ul>
                <li><a href="/site/administrator">管理人について</a></li>
                <li><a href="/site/inquiry">お問い合わせ</a></li>
            </ul>
            <div class="footer-copyright">Copyright (C) 2021 Hashimu All Rights Reserved.</div>
        </div>
    </div>
</footer>
{{--<script src="{{ asset('js/jquery.slim.min.js')}}"></script>--}}
{{--<script src="{{ asset('js/popper.min.js')}}"></script>--}}
{{--<script src="{{ asset('js/bootstrap.min.js')}}"></script>--}}
{{--<script src="{{ asset('js/jquery.home.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('js/assets/pages/index.js')}}"></script>--}}

{{--//submitのボタン連打防止--}}
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
    var start_hour   = ('00' + today.getHours()).slice( -2 );
    var start_minute = ('00' + today.getMinutes()).slice( -2 );

    //日・時・分を取得
    var end_hour   = ('00' + today.getHours() + 1).slice( -2 );
    var end_minute = ('00' + today.getMinutes()).slice( -2 );

    console.log(start_hour);
    console.log(start_minute);

    document.getElementById( "datepicker" ).value = year + "/" + month + "/" + day ;
    document.getElementById( 'start_time' ).value = start_hour + ":" + start_minute ;
    document.getElementById( 'end_time' ).value   = end_hour + ":" + end_minute ;
  });

  //submitのボタン連打防止
  $('form').on('submit', function () {
  $('button').prop('disabled', true);
});

$('#selected_game_id').change(function() {
  $("#selected_game_form").submit();
});

</script>

@endsection
