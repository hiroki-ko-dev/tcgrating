<div class="col-sm-6 mb-4">
  <div class="box text-left">
    <div class="box-header">{{ __('性別') }}</div>
    <div class="form-group row">
      <div class="col-md-12">
        <label class="radio-button">
          <input type="radio" name="gender" value="1" class="radio-button__input"
                 @if(old('gender',$user->gender)== 1 ? true : false) checked @endif
          >
          <span class="radio-button__icon">男</span>
        </label>
        <label class="radio-button">
          <input type="radio" name="gender" value="2" class="radio-button__input"
                 @if(old('gender',$user->gender)== 2 ? true : false) checked @endif
          >
          <span class="radio-button__icon">女</span>
        </label>
        <label class="radio-button">
          <input type="radio" name="gender" value="0" class="radio-button__input"
                 @if(old('gender',$user->gender)== 0 ? true : false) checked @endif
          >
          <span class="radio-button__icon">回答しない</span>
        </label>
      </div>
    </div>
  </div>
</div>
