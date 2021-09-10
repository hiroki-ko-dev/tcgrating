@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('マイページ') }}
    </div>
  </div>

  <form method="POST" action="/user/{{$user->id}}">
    @csrf
    @method('PUT')
    <div class="row justify-content-cente ">
      <div class="col-sm-6 mb-4">
        <div class="box text-left">
          <input type="hidden" name="id" value="{{$user->id}}">
            <div class="box-header">{{ __('メールアドレス') }}</div>
            <div class="form-group row">
              <div class="col-md-12">
                <input id="email" type="text" class="form-control w-100 @error('email') is-invalid @enderror" name="email" value="{{ old('email',$user->email) }}" required autocomplete="email" autofocus>
                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
        </div>
      </div>
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
    </div>

    <div class="row justify-content-center">
      <div class="col-12 mb-4">
        <div class="box text-left">
          <div class="card-header">{{ __('プロフィール文') }}</div>
          <div class="card-body">
            <div class="form-group row">
              <div class="col-md-12">
                <textarea id="body" class="form-control w-100 @error('body') is-invalid @enderror" name="body" >{{ old('body',$user->body) }}</textarea>
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
    </div>

    <div class="form-group row mb-3">
      <div class="col-md-6 offset-md-5">
        <button type="submit" class="btn btn-dark rounded-pill btn-outline-secondary text-light text-center pl-5 pr-5">
          {{ __('保存') }}
        </button>
      </div>
    </div>
  </form>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
