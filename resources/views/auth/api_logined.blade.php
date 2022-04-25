<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TcgRating</title>
</head>
<body>
</body>

<script type="text/javascript">
  @if(Auth::check())
    window.ReactNativeWebView.postMessage(0);
  @else
    window.ReactNativeWebView.postMessage({{Auth::id()}});
  @endif
</script>

</html>
