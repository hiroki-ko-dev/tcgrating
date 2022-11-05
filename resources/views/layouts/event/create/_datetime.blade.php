<div class="text-left p-1 font-weight-bold">{{ __('大会日時') }}</div>
<div class="row justify-content-center mb-3">
  <div class="col-12">
    <div class="box">
      <div class="form-group row">
        <div class="col-sm-4">
          <div class="d-flex flex-row mb-3 align-items-center">
            <div class="w-30 font-weight-bold">日程</div>
            <div class="w-70">
              <input type="text" id="datepicker" class="form-control w-100 @error('date') is-invalid @enderror" name="date" value="{{ old('date', $event->date)}}">
              @error('date')
              <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="d-flex flex-row mb-3 align-items-center">
            <div class="w-30 font-weight-bold">開始時間</div>
            <div class="w-70">
              <input type="time" id="start_time" class="form-control w-100 @error('start_time') is-invalid @enderror" name="start_time" value="{{ old('start_time', $event->start_time) }}">
              @error('start_time')
              <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="d-flex flex-row mb-3 align-items-center">
            <div class="w-30 font-weight-bold">終了時間</div>
            <div class="w-70">
              <input type="time" id="end_time" class="form-control w-100 @error('end_time') is-invalid @enderror" name="end_time" value="{{ old('end_time', $event->end_time) }}">
              @error('end_time')
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
</div>
