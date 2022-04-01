<div class="row justify-content-center">
  <div class="col-12">
    <div class="box">
      <div class="box-header text-left">{{ __('対戦相手募集範囲') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <div class="text-left ml-5">
            <div>
              {{ Form::radio('is_tweeted', 1, true, ['id' => 'radio-one', 'class' => 'form-check-input']) }}
              {{ Form::label('radio-one', 'web全体から相手を募集する', ['class' => 'form-check-label']) }}
            </div>
            <div>
              {{ Form::radio('is_tweeted', 0, false, ['id' => 'radio-two', 'class' => 'form-check-input']) }}
              {{ Form::label('radio-two', '対戦URLを直接相手に教える', ['class' => 'form-check-label']) }}
              <br>※すでに相手が決まっているならこちら
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
