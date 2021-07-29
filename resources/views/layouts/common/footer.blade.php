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

$(document).ready( function() {
  //submitのボタン連打防止
  $('form').on('submit', function () {
    $('button').prop('disabled', true);
  });
});


</script>

@endsection
