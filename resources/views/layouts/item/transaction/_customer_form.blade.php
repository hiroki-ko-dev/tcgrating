<form method="POST"  id="payment-form" action="/item/transaction">
  @csrf

  <div class="box mb-3">
    <div class="row justify-content-center p-2">
      <div class="col-sm-6">
        Twitterログインを行うと既に入力済みの項目が自動入力されます
      </div>
    </div>
    <div class="row justify-content-center p-2">
      @if(Auth::check())
        ログイン済みです
      @else
        <button type="submit" class="btn bg-twitter text-white w-50 p-3" onclick="location.href='/auth/twitter/login'">Twitterログイン</button>
      @endif
    </div>
  </div>

  <div class="box mb-3">
    <div class="row justify-content-center">
      <h5>お客様情報</h5>
    </div>

    <div class="row justify-content-center p-2">
      <div class="col-sm-4 text-left p-2">
        <span class="bg-danger text-white mr-1 p-1">必須</span>苗字
      </div>
      <div class="col-sm-6">
        <input id="last_name" type="text" class="form-control w-100 @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name',$user->last_name) }}" required autocomplete="last_name" autofocus>
        @error('last_name')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>
    <div class="row justify-content-center p-2">
      <div class="col-sm-4 text-left p-2">
        <span class="bg-danger text-white mr-1 p-1">必須</span>名前
      </div>
      <div class="col-sm-6">
        <input id="first_name" type="text" class="form-control w-100 @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name',$user->first_name) }}" required autocomplete="first_name" autofocus>
        @error('first_name')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
    </div>

    <div class="row justify-content-center p-2">
      <div class="col-sm-4 text-left p-2">
        <span class="bg-danger text-white mr-1 p-1">必須</span>郵便番号（ハイフン無し）
      </div>
      <div class="col-sm-6">
        <input id="post_code" type="text" class="form-control w-100 @error('post_code') is-invalid @enderror" name="post_code" value="{{ old('post_code',$user->post_code) }}" required autocomplete="post_code" autofocus>
        @error('post_code')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>

    <div class="row justify-content-center p-2">
      <div class="col-sm-4 text-left p-2">
        <span class="bg-danger text-white mr-1 p-1">必須</span>都道府県
      </div>
      <div class="col-sm-6">
        <select name="prefecture_id" class="form-control">
          @foreach(config('assets.prefectures') as $key => $prefecture)
            <option value="{{$key}}" @if($key == old('quantity',$user->quantity)) selected @endif>{{$prefecture}}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="row justify-content-center p-2">
      <div class="col-sm-4 text-left p-2">
        <span class="bg-danger text-white mr-1 p-1">必須</span>市区町村郡
      </div>
      <div class="col-sm-6">
        <input id="address1" type="text" class="form-control w-100 @error('address1') is-invalid @enderror" name="address1" value="{{ old('address1',$user->address1) }}" required autocomplete="address1" autofocus>
        @error('address1')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
    </div>

    <div class="row justify-content-center p-1">
      <div class="col-sm-4 text-left p-2">
        <span class="bg-danger text-white mr-1 p-1">必須</span>町名・番地
      </div>
      <div class="col-sm-6">
        <input id="address2" type="text" class="form-control w-100 @error('address2') is-invalid @enderror" name="address2" value="{{ old('address2',$user->address2) }}" required autocomplete="address2" autofocus>
        @error('address2')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
    </div>

    <div class="row justify-content-center p-1">
      <div class="col-sm-4 text-left p-2">
        <span class="bg-white mr-1 p-1">　　</span>マンション・ビル名・部屋番号
      </div>
      <div class="col-sm-6">
        <input id="address3" type="text" class="form-control w-100 @error('address3') is-invalid @enderror" name="address3" value="{{ old('address3',$user->address3) }}">
        @error('address3')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
    </div>

    <div class="row justify-content-center p-1">
      <div class="col-sm-4 text-left p-2">
        <span class="bg-danger text-white mr-1 p-1">必須</span>電話番号（ハイフン無し）
      </div>
      <div class="col-sm-6">
        <input id="tel" type="text" class="form-control w-100 @error('tel') is-invalid @enderror" name="tel" value="{{ old('tel',$user->tel) }}" required autocomplete="tel" autofocus>
        @error('tel')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
    </div>

    <div class="row justify-content-center p-1">
      <div class="col-sm-4 text-left p-2">
        <span class="bg-danger text-white mr-1 p-1">必須</span>メールアドレス
      </div>
      <div class="col-sm-6">
        <input id="email" type="text" class="form-control w-100 @error('email') is-invalid @enderror" name="email" value="{{ old('email',$user->email) }}" required autocomplete="email" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>
    <div class="row justify-content-center p-1">
      <div class="col-sm-4 text-left p-2">
        <span class="bg-danger text-white mr-1 p-1">必須</span>メールアドレス(確認用)
      </div>
      <div class="col-sm-6">
        <input id="email_confirmation" type="text" class="form-control w-100 @error('email_confirmation') is-invalid @enderror" name="email_confirmation" value="{{ old('email_confirmation',$user->email) }}" required autocomplete="email_confirmation" autofocus>
        @error('email_confirmation')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
    </div>
  </div>


  <div class="box">
    <div class="row justify-content-center pb-3">
      <div class="col-md-12">
        <button type="submit" class="btn bg-primary text-white w-50">レジに進む</button>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-12">
        <button type="submit" class="btn bg-secondary text-white w-50" onclick="location.href='/item/cart'">戻る</button>
      </div>
    </div>
  </div>

</form>
