<div class="d-flex flex-row align-items-center p-2">
  @if(session('selected_game_id') == null || session('selected_game_id') == config('assets.site.game_ids.pokemon_card'))
    <div class="header-font">
      {{ __('ポケカ履歴書') }}
    </div>
    <div class="ml-auto">
      @if($user->id === Auth::id())
        <button class="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                onclick="location.href='/user/{{$user->id}}/edit'">
          {{ __('編集する') }}
        </button>
      @endif
    </div>
  @else
    <div>
      {{ __('マイページ') }}
    </div>
    <div class="ml-auto">
      @if($user->id === Auth::id())
        <button class="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                onclick="location.href='/user/{{$user->id}}/edit'">
          {{ __('編集する') }}
        </button>
      @endif
    </div>
  @endif
</div>

