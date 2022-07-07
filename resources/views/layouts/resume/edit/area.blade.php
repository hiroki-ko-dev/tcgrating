<div class="col-sm-6 mb-4">
  <div class="box text-left">
    <div class="box-header">{{ __('活動地域') }}</div>
    <div class="form-group row">
      <div class="col-md-12">
        <input id="name" type="text" class="form-control w-100 @error('area') is-invalid @enderror" name="area" value="{{ old('area',$gameUser->area) }}" required autocomplete="area" autofocus>
        @error('area')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
    </div>
  </div>
</div>
