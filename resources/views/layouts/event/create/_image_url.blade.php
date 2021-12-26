<div class="row justify-content-center mb-4">
  <div class="col-12">
    <div class="box">
      <div class="box-header text-left">{{ __('イベント画像URL') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="text" id="image_url" class="form-control w-100 @error('image_url') is-invalid @enderror" name="image_url" value="{{ old('image_url') }}">
          @error('image_url')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
    </div>
  </div>
</div>
