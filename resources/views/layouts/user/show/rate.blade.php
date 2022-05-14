<div class="box text-left">
  <div class="box-header">{{ __('レート') }}</div>
  <div class="body">
    @if(isset(Auth::user()->selected_game_id) && !is_null($user->gameUsers->where('game_id', Auth::user()->selected_game_id)->first()))
      {{number_format($user->gameUsers->where('game_id', Auth::user()->selected_game_id)->first()->rate)}}
    @elseif(session('selected_game_id') && $user->gameUsers->where('game_id', session('selected_game_id'))->isNotEmpty())
      {{number_format($user->gameUsers->where('game_id', session('selected_game_id'))->first()->rate)}}
    @else
      0
    @endif
  </div>
</div>
