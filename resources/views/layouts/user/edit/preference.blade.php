<div class="col-sm-6 mb-4">
  <div class="box text-left">
    <div class="box-header">{{ __('好きなポケモン') }}</div>
    <div class="form-group row">
      <div class="col-md-12">
        <input id="preference" type="text" class="form-control w-100 @error('preference') is-invalid @enderror" name="preference" value="{{ old('preference',$gameUser->preference) }}" required autocomplete="preference" autofocus>
        @error('preference')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
    </div>
  </div>
</div>
