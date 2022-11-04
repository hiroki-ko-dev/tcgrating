<input type="hidden" name="tool_id" value="{{\App\Models\Duel::TOOL_TCG_DISCORD}}">
<input type="hidden" name="tool_code" value="{{config('assets.duel.discordPokemonCardServerUrl')}}">

<div class="text-left font-weight-bold p-1">{{ __('対戦ツール') }}</div>
<div class="box mb-4">
  <div class="row">
    <div class="col-12 text-left">
      以下Discordで対戦です。未参加の方は参加してください。
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4">
      <a href="{{config('assets.duel.discordPokemonCardServerUrl')}}">
          <img class="img-fluid" src="{{ asset('/images/site/discord.png') }}" alt="hashimu-icon"></a>
    </div>
  </div>
</div>
