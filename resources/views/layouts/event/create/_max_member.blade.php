<div class="row justify-content-center">
  <div class="col-12">
    <div class="box">
      <div class="box-header text-left">{{ __('最大参加人数') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="number" id="max_member" class="form-control w-100 @error('max_member') is-invalid @enderror" name="max_member" value="{{ old('max_member') }}" required autocomplete="max_member" autofocus>
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
