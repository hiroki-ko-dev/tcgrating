<input type="hidden" name="tool_id" value="{{\App\Models\Duel::TOOL_TCG_DISCORD}}">
<input type="hidden" name="tool_code" value="{{config('assets.duel.discordPokemonCardServerUrl')}}">


<div class="box mb-4">
  <div class="text-left site-color text-white p-2 mb-3">{{ __('対戦ツール') }}</div>
  <div class="row">
    <div class="col-12 text-left">
      以下Discordを利用しての対戦になります。未参加の方は参加ボタンを押してください。
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4">
      <a href="{{config('assets.duel.discordPokemonCardServerUrl')}}">
          <img class="img-fluid" src="{{ asset('/images/site/discord.png') }}" alt="hashimu-icon"></a>
    </div>
  </div>
</div>
