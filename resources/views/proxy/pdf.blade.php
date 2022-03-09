<!DOCTYPE html>
<html class="no-js no-svg" lang="ja">
<head>
  <meta charset="utf-8">
  <title>プロキシ画像表示</title>
  {{--メタタグ--}}
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
</head>
<style>
  body {
    margin: 0px;
    padding: 0px;
  }
  @page {
    margin-top: 67px;
    margin-bottom: 0px;
    margin-left: 0px;
    margin-right: 0px;
  }
</style>

<body style="margin:0;padding:0;">
  <div>
  <!--
    @foreach($viewImages as $viewImage)
      --><img src="{{$viewImage}}" style="width:63mm;height:88mm;margin:0;padding:0;" alt="画像URLが正しくありません"/><!--
    @endforeach
      -->
  </div>
</body>
</html>



