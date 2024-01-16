<div class="box">
  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="text-left">{{ __('デッキID') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          {{$deck->id}}
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="text-left">{{ __('コード') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="text" id="code" class="form-control w-100 @error('code') is-invalid @enderror" name="code" value="{{ old('code', $deck->code) }}" required autocomplete="deck" autofocus>
          @error('deck')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <div class="col-md-12">
          <img class="deck-image" src="{{$deck->imageUrl}}" alt="hashimu-icon">
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="text-left">{{ __('イベント名') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="text" id="name" class="form-control w-100 @error('name') is-invalid @enderror" name="name" value="{{ old('name', $deck->name) }}" required autocomplete="name" autofocus>
          @error('name')
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
      <div class="text-left">{{ __('主催者名') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="text" class="form-control w-100 @error('organizer_name') is-invalid @enderror" name="organizer_name" value="{{ old('organizer_name', $deck->organizer_name) }}">
          @error('organizer_name')
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
      <div class="text-left">{{ __('日付') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="date" class="form-control w-100 @error('date') is-invalid @enderror" name="date" value="{{ old('date', $deck->date) }}">
          @error('date')
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
      <div class="text-left">{{ __('順位') }}</div>
      <div class="form-group row">
        <div class="col-md-12">
          <input type="number" class="form-control w-100 @error('rank') is-invalid @enderror" name="rank" value="{{ old('rank', $deck->rank) }}">
          @error('rank')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
    </div>
  </div>

  @foreach($deck->tags as $tag)
    <form method="POST" action="/decks/deck-tag-deck/{{$deck->id}}/{{$tag->id}}">
      @csrf
      @method('PUT')
      <div class="row justify-content-center mb-4">
        <div class="col-2">{{$tag->id}}</div>
        <div class="col-3">{{$tag->name}}</div>
        <div class="col-5">
          <select name="deck_tag_id" class="form-control">
            @foreach($deckTags as $deckTag)
              <option value="{{ $deckTag->id }}" {{ $tag->id == $deckTag->id ? 'selected' : '' }}>{{ $deckTag->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-2">
          <button type="submit" class="btn site-color btn-outline-secondary text-light w-40">
            {{ __('保存する') }}
          </button>
        </div>
      </div>
    </form>
  @endforeach

  <form method="POST" action="/decks/deck-tag-deck">
    @csrf
    <input type="hidden" name="deck_id" value="{{$deck->id}}">
    <div class="row justify-content-center mb-4">
      <div class="col-5">新規でリレーションを追加</div>
      <div class="col-5">
        <select name="deck_tag_id" class="form-control">
          @foreach($deckTags as $deckTag)
            <option value="{{ $deckTag->id }}" {{ $tag->id == $deckTag->id ? 'selected' : '' }}>{{ $deckTag->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-2">
        <button type="submit" class="btn site-color btn-outline-secondary text-light w-40">
          {{ __('保存する') }}
        </button>
      </div>
    </div>
  </form>

  <div class="row justify-content-center  mb-0">
    <button type="submit" class="btn site-color btn-outline-secondary text-light w-40" onClick="return requestConfirm();">
      {{ __('保存する') }}
    </button>
  </div>
</div>
