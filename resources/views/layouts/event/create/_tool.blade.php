<div class="row justify-content-center mb-4">
  <div class="col-12">
    <div class="box">
      <div class="box-header text-left">{{ __('対戦ツール') }}</div>
      <div class="d-flex flex-row mb-3">
        <div class="w-30">{{ __('ツール名') }}</div>
        <div class="w-70">
          <select id="tool_id" name="tool_id" class="form-control">
            @foreach(config('assets.duel.tool') as $key => $tool)
              <option value="{{$key}}"
                      @if(old('tool_id', $event->tool_id) == $key)
                      selected
                @endif
              >{{$tool}}</option>
            @endforeach
          </select>
          @error('tool_id')
          <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
          @enderror
        </div>
      </div>
      <div class="d-flex flex-row mb-3">
        <div class="w-30">{{ __('対戦コード') }}</div>
        <div class="w-70">
          <input id="tool_code" type="text" placeholder="※ユーザー名等の連絡がとれるもの" class="form-control w-100 @error('tool_code') is-invalid @enderror" name="tool_code" value="{{ old('tool_code', $event->tool_code) }}" autofocus>
          @error('tool_code')
          <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
          @enderror
        </div>
      </div>
    </div>
  </div>
</div>
