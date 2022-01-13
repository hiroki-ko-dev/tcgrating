<div class="row justify-content-center">
  <div class="col-12">
    <div class="box">
      <div class="box-header text-left">{{ __('対戦回数') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="number" id="number_of_match" class="form-control w-100 @error('number_of_match') is-invalid @enderror" name="number_of_match" value="{{ old('number_of_match') }}" required autocomplete="number_of_match" autofocus>
          @error('number_of_match')
          <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
          @enderror
        </div>
      </div>
    </div>
  </div>
</div>
