<div class="row justify-content-center mb-4">
  <div class="col-12">
    <div class="box">
      <div class="box-header text-left">{{ __('イベント概要文') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <textarea id="body" class="form-control w-100 @error('body') is-invalid @enderror" name="body" >{{ old('body') }}</textarea>
          @error('body')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
    </div>
  </div>
</div>