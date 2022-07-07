<div class="col-sm-6 mb-4">
  <div class="box text-left">
    <div class="box-header">{{ __('レギュレーション') }}</div>
    <div class="form-group row">
      <div class="col-md-12">
        @foreach(\App\Models\GameUserCheck::ITEM_ID_REGULATIONS as $regulation)
          <div>
            <input type="checkbox" name="item_ids[{{$regulation}}]" value="{{$regulation}}"
               @if($gameUser->gameUserChecks->where('item_id',$regulation)->first()) checked @endif>
            <label for="regulations">
              {{\App\Models\GameUserCheck::ITEM_ID_REGULATIONS_NAME[$regulation]}}
            </label>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
