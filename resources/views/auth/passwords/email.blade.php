@extends('layouts.organizer.auth')

@section('content')
<h2>パスワード再設定</h2>
<p>メールにてパスワードを再設定するURLをお送りします。</p>

@if (session('status'))
<div class="box success">
    {{ session('status') }}
</div>
@endif

<form method="post" action="/organizer/password/email">
	{{ csrf_field() }}
	<label for="email">メールアドレス</label>
	<span class="error">{{ $errors->first('email') }}</span>
	<input type="text" name="email" id="email" @if($errors->has('email')) class="error" @endif value="{{ old('email') }}" placeholder="" />
	<input type="submit" value="送信" class="special" />
</form>
@endsection
