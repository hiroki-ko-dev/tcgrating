@if(Auth::check())
  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="box">
        <div class="d-flex flex-row mb-3">
          <div class="w-30">{{ __('Discordでの名前') }}</div>
          <div class="w-70">
            @if(Auth::user()->gameUsers->where('game_id', Auth::user()->selected_game_id)->first())
              <input type="text" placeholder="#以下は不要" class="form-control w-100 @error('discord_name') is-invalid @enderror" name="discord_name" value="{{ old('discord_name', Auth::user()->gameUsers->where('game_id', Auth::user()->selected_game_id)->first()->discord_name) }}" required>
            @else
              <input type="text" placeholder="#以下は不要" class="form-control w-100 @error('discord_name') is-invalid @enderror" name="discord_name" value="{{ old('discord_name') }}" required>>
            @endif
            @error('discord_name')
            <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
            @enderror
          </div>
        </div>
      </div>
    </div>
  </div>
@endif
