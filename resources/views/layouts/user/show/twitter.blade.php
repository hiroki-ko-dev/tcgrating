@if($user->twitter_id == null)
  <div class="col-sm-6 mb-4">
    <div class="box text-left">
      @if($user->id === Auth::id())
        <div class="box-header">{{ __('Twitter連携') }}</div>
        <a href="/auth/twitter/login"><img class="img-fluid" src="{{ asset('/images/site/twitter/relation.png') }}" alt="hashimu-icon"></a>
      @else
        ※このユーザーはTwitter未連携です
      @endif
    </div>
  </div>
@else
  @if(Auth::id() == 1)
    <div class="col-sm-6 mb-4">
      <div class="box text-left">
        <div class="box-header">{{ __('Twitterアカウント') }}</div>
        <a href="https://twitter.com/{{$user->twitter_nickname}}"><div type="body">＠{{$user->twitter_nickname}}</div></a>
      </div>
    </div>
  @endif
@endif
