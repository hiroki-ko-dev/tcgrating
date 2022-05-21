<div class="col-12 mb-4">
  <div class="box text-left">
    <div class="box-header">{{ __('フリースペース') }}</div>
    <div class="form-group row">
      <div class="col-md-12">
        <textarea id="body" class="form-control w-100 @error('body') is-invalid @enderror" name="body" >{{ old('body',$user->body) }}</textarea>
        @error('body')
        <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
        @enderror
      </div>
    </div>
  </div>
</div>
