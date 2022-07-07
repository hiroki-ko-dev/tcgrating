{{--<div class="col-sm-6 mb-4">--}}
{{--  <div class="box text-left">--}}
{{--    <input type="hidden" name="id" value="{{$resume->id}}">--}}
{{--    <div class="box-header">{{ __('メールアドレス') }}</div>--}}
{{--    <div class="form-group row">--}}
{{--      <div class="col-md-12">--}}
{{--        <input id="email" type="text" class="form-control w-100 @error('email') is-invalid @enderror" name="email" value="{{ old('email',$resume->email) }}" required autocomplete="email" autofocus>--}}
{{--        @error('email')--}}
{{--        <span class="invalid-feedback" role="alert">--}}
{{--                    <strong>{{ $message }}</strong>--}}
{{--                  </span>--}}
{{--        @enderror--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--</div>--}}

<input type="hidden" name="email" value="{{$user->email}}">
