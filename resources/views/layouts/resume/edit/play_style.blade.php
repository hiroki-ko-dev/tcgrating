<div class="col-sm-6 mb-4">
  <div class="box text-left">
    <div class="box-header">{{ __('プレイスタイル') }}</div>
    <div class="form-group row">
      <div class="col-md-12">
        @foreach(\App\Models\GameUserCheck::ITEM_ID_PLAY_STYLES as $play_style)
          <div>
            <input type="checkbox" name="item_ids[{{$play_style}}]" value="{{$play_style}}"
               @if($gameUser->gameUserChecks->where('item_id',$play_style)->first()) checked @endif>
            <label for="splay_styles">
              {{\App\Models\GameUserCheck::ITEM_ID_PLAY_STYLES_NAME[$play_style]}}
            </label>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
