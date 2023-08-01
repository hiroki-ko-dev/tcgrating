<div class="row justify-content-center">
  <div class="col-12">
    <div class="box">

      <div class="box-header text-left">{{ __('対戦相手募集範囲') }}</div>
      <div class="form-group row mb-4">
        <div class="col-md-12">
          <div class="text-left ml-5">
            <div>
              <input type="radio" name="is_tweeted" value="1" checked>
              <label>web全体から相手を募集する</label>
            </div>
            <div>
              <input type="radio" name="is_tweeted" value="0">
              <label>対戦URLを直接相手に教える</label>
              <br>※すでに相手が決まっているならこちら
            </div>
          </div>
        </div>
      </div>

      <div class="box-header text-left">{{ __('レギュレーション') }}</div>
      <select name="regulation_type" class="form-control mb-4">
        <option value="{{\App\Enums\EventRegulationType::STANDARD->value}}" >{{\App\Enums\EventRegulationType::STANDARD->description()}}</option>
        <option value="{{\App\Enums\EventRegulationType::EXTRA->value}}" >{{\App\Enums\EventRegulationType::EXTRA->description()}}</option>
      </select>

      <div class="box-header text-left">{{ __('プロキシ') }}</div>
      <select name="card_type" class="form-control mb-4">
        <option value="{{\App\Enums\EventCardType::NORMAL->value}}">{{\App\Enums\EventCardType::NORMAL->description()}}</option>
        <option value="{{\App\Enums\EventCardType::PROXY->value}}">{{\App\Enums\EventCardType::PROXY->description()}}</option>
      </select>

    </div>
  </div>
</div>
