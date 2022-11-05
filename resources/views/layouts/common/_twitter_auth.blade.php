<div class="text-left p-1 font-weight-bold">{{ __('Twitterログイン') }}</div>
<div class="row justify-content-center mb-3">
  <div class="col-12">
    <div class="box">
      @if(Auth::check())
        <div class="font-weight-bold text-left">{{ __('Twitterログイン済です。') }}</div>
      @else
        <div class="font-weight-bold text-left">{{ __('Twitterログインできていません。以下ボタンからログインしてください') }}</div>
        <div class="col-sm-4">
          <a href="/auth/twitter/login"><img class="img-fluid" src="{{ asset('/images/site/twitter/relation.png') }}" alt="hashimu-icon"></a>
        </div>
      @endif
    </div>
  </div>
</div>
