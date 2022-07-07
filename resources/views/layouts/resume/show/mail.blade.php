<div class="box text-left">
  <div class="box-header">{{ __('メールアドレス') }}</div>
  @if($user->id === Auth::id())
    <div class="body">{{$user->email}}</div>
  @else
    <div class="body">{{ __('※本人にのみ表示されます') }}</div>
  @endif
</div>
