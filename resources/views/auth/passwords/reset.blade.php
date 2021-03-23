@extends('layouts.organizer.auth')

@section('content')
<h2>パスワード再設定</h2>

@if (session('status'))
<div class="box success">
    {{ session('status') }}
</div>
@endif

<form method="post" action="/organizer/password/reset">
	{{ csrf_field() }}
	<input type="hidden" name="token" value="{{ $token }}">

	<label for="email">メールアドレス</label>
	<span class="error">{{ $errors->first('email') }}</span>
	<input type="text" name="email" id="email" @if($errors->has('email')) class="error" @endif value="{{ old('email', $email) }}" placeholder="" />

	<label for="email">新しいパスワード</label>
	<span class="error">{{ $errors->first('password') }}</span>
	<input type="password" name="password" id="password" @if($errors->has('password')) class="error" @endif value="{{ old('password') }}" />

	<label for="email">新しいパスワードの確認</label>
	<span class="error">{{ $errors->first('password_confirmation') }}</span>
	<input type="password" name="password_confirmation" id="password_confirmation" @if($errors->has('password_confirmation')) class="error" @endif value="{{ old('password_confirmation') }}" />

	<input type="submit" value="パスワードを再設定する" class="special" />
</form>
@endsection
