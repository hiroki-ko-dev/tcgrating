
<div class="box mb-2">
  <div class="row justify-content-center mb-4">
    <div class="col-sm-12">
      <h3 class="text-left">{{$item->name}}</h3>
    </div>
  </div>

  <div class="row justify-content-center p-2">
    <div class="col-sm-6 p-1">
      <img class="img-fluid" src="{{ $item->image_url }}" alt="hashimu-icon">
    </div>
    <div class="col-sm-6 p-2">
      <div class="row justify-content-center mb-2">
        <div class="col-4 text-right">値段</div>
        <div class="col-8">{{number_format($item->price)}}円</div>
      </div>
      <div class="row justify-content-center visible_{{$item->id}} mb-2">
        <div class="col-4 text-right">在庫</div>
        <div class="col-8">{{$item->quantity}}個</div>
      </div>
      <div class="after_visible_{{$item->id}}"></div>
      <div class="row justify-content-start p-3">
        <div type="body" class="blog-body text-left">{!! $item->body !!}</div>
      </div>
    </div>
  </div>
</div>



<div class="row justify-content-center mb-2">
  <div class="col-12">
    <div class="box">
      <div class="text-left">原価</div>
      <input type="number" id="cost" placeholder="値段を入力" class="form-control w-100 @error('cost') is-invalid @enderror" name="cost" value="{{ old('cost', $itemStock->cost) }}" required>
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
      <input type="number" id="quantity" placeholder="在庫数を入力" class="form-control w-100 @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $itemStock->quantity) }}" required>
      @error('price')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>
</div>
