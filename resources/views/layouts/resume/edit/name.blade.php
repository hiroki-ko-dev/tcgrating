<div class="col-sm-6 mb-4">
  <div class="box text-left">
    <div class="box-header">{{ __('名前') }}</div>
    <div class="form-group row">
      <div class="col-md-12">
        <input id="name" type="text" class="form-control w-100 @error('name') is-invalid @enderror" name="name" value="{{ old('name',$user->name) }}" required autocomplete="name" autofocus>
        @error('name')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
    </div>
  </div>
</div>
