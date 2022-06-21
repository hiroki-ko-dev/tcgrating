<div class="row justify-content-center mb-4">
  <div class="col-12">
    <div class="box">
      <div class="box-header text-left">{{ __('商品名') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="text" id="name" class="form-control w-100 @error('name') is-invalid @enderror" name="name" value="{{ old('name', $item->name) }}">
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

<div class="row justify-content-center mb-4">
  <div class="col-12">
    <div class="box">
      <div class="box-header text-left">{{ __('イベント概要文') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <textarea id="body" class="form-control w-100 @error('body') is-invalid @enderror" name="body" >{{ old('body',$item->body) }}</textarea>
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

<div class="row justify-content-center mb-4">
  <div class="col-12">
    <div class="box">
      <div class="box-header text-left">{{ __('商品画像URL') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="text" id="image_url" class="form-control w-100 @error('image_url') is-invalid @enderror" name="image_url" value="{{ old('image_url', $item->image_url) }}">
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

<div class="row justify-content-center mb-4">
  <div class="col-12">
    <div class="box">
      <div class="d-flex flex-row mb-3">
        <div class="w-30">{{ __('公開設定') }}</div>
        <div class="w-70">
          <select id="is_released" name="is_released" class="form-control">
              <option value="0"
                @if(old('is_released', $item->is_released))
                  selected
                @endif
              >非公開</option>
            <option value="1"
              @if(old('is_released', $item->is_released))
                selected
              @endif
            >公開</option>
          </select>
          @error('is_released')
          <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
          @enderror
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row justify-content-center  mb-0">
    <input type="submit" name="save" class="btn site-color text-white rounded-pill btn-outline-secondary text-center pl-4 pr-4" value="対戦を作成・編集" onClick="return requestConfirm();">
</div>
