<div class="text-left p-1 font-weight-bold">{{ __('大会名') }}</div>
<div class="row justify-content-center mb-3">
  <div class="col-12">
    <div class="box">
      <div class="form-group row">
        <div class="col-md-12">
          <input type="text" id="title" class="form-control w-100 @error('title') is-invalid @enderror" name="title" value="{{ old('title', $event->title) }}">
          @error('title')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
    </div>
  </div>
</div>
