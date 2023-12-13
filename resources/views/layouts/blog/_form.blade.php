<div class="box">
  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="text-left">{{ __('タイトル') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="text" id="title" class="form-control w-100 @error('title') is-invalid @enderror" name="title" value="{{ old('title',$blog->title) }}" required autocomplete="title" autofocus>
          @error('title')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="text-left">{{ __('サムネイル画像URL') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="text" class="form-control w-100 @error('thumbnail_image_url') is-invalid @enderror" name="thumbnail_image_url" value="{{ old('thumbnail_image_url',$blog->thumbnail_image_url) }}" required autocomplete="thumbnail_image_url" autofocus>
          @error('thumbnail_image_url')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="text-left">{{ __('アフェリエイトURL') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="text" class="form-control w-100 @error('affiliate_url') is-invalid @enderror" name="affiliate_url" value="{{ old('affiliate_url',$blog->affiliate_url) }}">
          @error('affiliate_url')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="text-left">{{ __('内容') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <textarea id="editor" class="ckeditor form-control w-100 @error('body') is-invalid @enderror" name="body" >{{ old('body',$blog->body) }}</textarea>
          @error('body')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="form-group row">
        <div class="col-md-12">
          <input type="radio" name="is_released" value="0" @if(!($blog->is_released))checked @endif>非公開
          <input type="radio" name="is_released" value="1" @if($blog->is_released)checked @endif>公開
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="form-group row">
        <div class="col-md-12">
          <input type="radio" name="is_tweeted" value="0" checked>ツイートしない
          <input type="radio" name="is_tweeted" value="1">ツイートする
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="form-group row">
        <div class="col-md-12">
          <input type="radio" name="is_affiliate" value="0" @if(!old("is_affiliate")) checked @endif>通常記事
          <input type="radio" name="is_affiliate" value="1" @if(old("is_affiliate")) checked @endif>商品紹介
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center  mb-0">
    @if(Auth::check())
      <button type="submit" class="btn site-color btn-outline-secondary text-light w-40" onClick="return requestConfirm();">
        {{ __('保存する') }}
      </button>
    @else
      <div>
        <h5>Twitterログインしていないため対戦の作成ができません。</h5>
        <h5 class="font-weight-bold text-danger">「Twitterと連携」 からログインしくてださい。</h5>
      </div>
    @endif
  </div>
</div>
