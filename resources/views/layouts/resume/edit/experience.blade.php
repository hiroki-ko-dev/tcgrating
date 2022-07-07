<div class="col-sm-6 mb-4">
  <div class="box text-left">
    <div class="box-header">{{ __('ポケカ歴') }}</div>
    <div class="form-group row">
      <div class="col-md-12">
        <input id="experience" type="text" class="form-control w-100 @error('experience') is-invalid @enderror" name="experience" value="{{ old('experience',$gameUser->experience) }}" required autocomplete="experience" autofocus>
        @error('experience')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
    </div>
  </div>
</div>
