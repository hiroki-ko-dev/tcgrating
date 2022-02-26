@can('eventRole',$event->id)
  <div class="row justify-content-center row-eq-height mb-4">
    <div class="col-12">
      <div class="box">
        <div class="form-group row">
          <div class="col-md-12">
          {{--参加募集していない場合--}}
            <div class="d-flex flex-row justify-content-center">
              <button type="button" class="btn site-color text-white rounded-pill btn-outline-secondary text-center" onclick="location.href='/event/swiss/{{$event->id}}/edit'">編集する</button>

              @if($event->status == \App\Models\Event::STATUS_READY)
                <form method="POST" action="/event/swiss/{{$event->id}}">
                  @csrf
                  @method('PUT')
                  <input type="submit" name="start_attendance" class="btn site-color text-white rounded-pill pl-4 pr-4" value="出欠をとる" onClick="return requestConfirm();">
                </form>
                <form method="POST" action="/event/swiss/{{$event->id}}">
                  @csrf
                  @method('PUT')
                  <input type="submit" name="end_attendance" class="btn site-color text-white rounded-pill pl-4 pr-4" value="出欠を終える" onClick="return requestConfirm();">
                </form>
                <form method="POST" action="/duel/swiss">
                  @csrf
                  <input type="hidden" name="event_id" value="{{$event->id}}">
                  <input type="submit" name="make_duel" class="btn btn-primary rounded-pill pl-4 pr-4" value="対戦を作成する" onClick="return requestConfirm();">
                </form>
                <form method="POST" action="/event/swiss/{{$event->id}}">
                  @csrf
                  @method('PUT')
                  <input type="submit" name="finish" class="btn site-color text-white rounded-pill pl-4 pr-4" value="イベントを完了する" onClick="return requestConfirm();">
                </form>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endcan
