<div class="text-left p-1 font-weight-bold">{{ __('対戦回数') }}</div>
<div class="row justify-content-center mb-3">
  <div class="col-12">
    <div class="box">
      <div class="form-group row">
        <div class="col-md-12">
          <input type="number" id="number_of_match" class="form-control w-100
            @error('number_of_match') is-invalid @enderror" name="number_of_match"
                 value="{{ old('number_of_match', 3) }}" required autocomplete="number_of_match" autofocus readonly>
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
