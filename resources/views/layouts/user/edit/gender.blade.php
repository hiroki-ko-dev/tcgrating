<div class="col-sm-6 mb-4">
  <div class="box text-left">
    <div class="box-header">{{ __('性別') }}</div>
    <div class="form-group row">
      <div class="col-md-12">
        <label class="radio-button">
          {{ Form::radio('gender', 1, (old('gender',$user->gender)== 1 ? true : false), ['class' => 'radio-button__input']) }}
          <span class="radio-button__icon">男</span>
        </label>
        <label class="radio-button">
          {{ Form::radio('gender', 2,  (old('gender',$user->gender)== 2 ? true : false), ['class' => 'radio-button__input']) }}
          <span class="radio-button__icon">女</span>
        </label>
        <label class="radio-button">
          {{ Form::radio('gender', 0, (old('gender',$user->gender)== 0 ? true : false), ['class' => 'radio-button__input']) }}
          <span class="radio-button__icon">回答しない</span>
        </label>
      </div>
    </div>
  </div>
</div>
