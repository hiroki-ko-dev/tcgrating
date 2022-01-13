@if(Auth::check()
         && Auth::user()->eventUsers->where('event_id', $event->id)->isNotEmpty()
         && Auth::user()->eventUsers->where('event_id', $event->id)->first()->status == \App\Models\EventUser::STATUS_MASTER)
  <div class="row justify-content-center row-eq-height mb-4">
    <div class="col-12">
      <div class="box">
        <div class="form-group row">
          <div class="col-md-12">
            {{--参加募集していない場合--}}
            @if($event->status == \App\Models\Event::STATUS_READY)
              <form method="POST" action="/duel/swiss">
                @csrf
                <input type="hidden" name="event_id" value="{{$event->id}}">
                <input type="submit" name="make_duel" class="btn btn-primary rounded-pill pl-4 pr-4" value="対戦を作成する" onClick="return requestConfirm();">
              </form>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endif
