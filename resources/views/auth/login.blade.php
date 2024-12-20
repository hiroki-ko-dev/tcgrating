@extends('layouts.common.common')

@section('content')
<div class="container">

  <div class="row justify-content-center m-1 mb-3">
    <div class="col-8 page-header">
      {{ __('Login') }}
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-md-8">
      <div class="box">
        <div class="box-header">{{ __('twitter') }}</div>
        <a href="/auth/twitter/login"><img class="img-fluid" src="{{ asset('/images/site/twitter/login.png') }}" alt="hashimu-icon"></a>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="box">
              <div class="box-header">{{ __('email') }}</div>

              <div class="card-body">
                  <form method="POST" action="{{ route('login') }}">
                      @csrf

                      <div class="form-group row">
                          <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                          <div class="col-md-6">
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                              @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                          <div class="col-md-6">
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <div class="col-md-6 offset-md-4">
                              <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                  <label class="form-check-label" for="remember">
                                      {{ __('パスワードを記憶する') }}
                                  </label>
                              </div>
                          </div>
                      </div>

                      <div class="form-group row mb-2">
                          <div class="col-md-8 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Login') }}
                              </button>

                              @if (Route::has('password.request'))
                                  <a class="btn btn-link" href="{{ route('password.request') }}">
                                      {{ __('パスワードを忘れた方はこちら') }}
                                  </a>
                              @endif
                          </div>
                      </div>

                    <div class="form-group row mb-0">
                      <div class="col-md-12">
                        {{ __('※アカウント新規作成はTwitterログインによっておこなってください') }}
                      </div>
                    </div>


                     {{-- <div class="form-group row mb-0">
                         <div class="col-md-8 offset-md-4">
                             <a class="btn btn-link" href="{{ route('register')}}">
                                 {{ __('アカウント新規作成') }}
                             </a>
                         </div>
                     </div> --}}



                  </form>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
