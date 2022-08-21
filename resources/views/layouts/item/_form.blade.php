<div class="row justify-content-center mb-2">
  <div class="col-12">
    <div class="box">
      <input type="text" id="name" placeholder="商品名を入力" class="form-control w-100 @error('name') is-invalid @enderror" name="name" value="{{ old('name', $item->name) }}"  required>
      @error('name')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
  </div>
</div>

<div class="row justify-content-center mb-2">
  <div class="col-12">
    <div class="box">
        <textarea id="body" placeholder="商品説明を入力" style="height: 150px;" class="form-control w-100 @error('body') is-invalid @enderror" name="body"  required>{{ old('body',$item->body) }}</textarea>
        @error('body')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
    </div>
  </div>
</div>

<div class="row justify-content-center mb-2">
  <div class="col-12">
    <div class="box">
      <input type="text" id="image_url" placeholder="商品画像URLを入力" class="form-control w-100 @error('image_url') is-invalid @enderror" name="image_url" value="{{ old('image_url', $item->image_url) }}"  required>
      @error('image_url')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
  </div>
</div>

<div class="row justify-content-center mb-2">
  <div class="col-12">
    <div class="box">
      <div class="text-left">売値</div>
      <input type="number" id="price" placeholder="値段を入力" class="form-control w-100 @error('price') is-invalid @enderror" name="price" value="{{ old('price', $item->price) }}" required>
      @error('price')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
</div>

<div class="row justify-content-center mb-2">
  <div class="col-12">
    <div class="box">
      <div class="text-left">原価</div>
      <input type="number" id="cost" placeholder="値段を入力" class="form-control w-100 @error('cost') is-invalid @enderror" name="cost" value="{{ old('cost', 0) }}" required>
      @error('cost')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
</div>

<div class="row justify-content-center mb-2">
  <div class="col-12">
    <div class="box">
      <div class="text-left">入荷数</div>
      <input type="number" id="quantity" placeholder="在庫数を入力" class="form-control w-100 @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $item->quantity) }}" required>
      @error('price')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
</div>

<div class="row justify-content-center mb-2">
  <div class="col-12">
    <div class="box">
      <div class="d-flex flex-row mb-3">
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

<div class="row justify-content-center  mb-0">
  <input type="submit" name="save" class="btn site-color text-white rounded-pill btn-outline-secondary text-center pl-4 pr-4" value="商品を作成" onClick="return requestConfirm();">
</div>
