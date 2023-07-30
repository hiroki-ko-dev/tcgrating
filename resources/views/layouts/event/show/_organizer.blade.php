@can('eventRole',$event->id)
  <div class="row justify-content-center row-eq-height mb-4">
    <div class="col-12">
      <div class="box">
        <div class="row justify-content-center">
          @if($event->status == \App\Enums\EventStatus::READY->value)
            <div class="col-sm-2">
              <form method="POST" action="/event/swiss/{{$event->id}}">
                @csrf
                @method('PUT')
                <input type="submit" name="start_attendance" class="btn site-color text-white w-100 m-1" value="出欠をとる" onClick="return requestConfirm();">
              </form>
            </div>
            <div class="col-sm-2">
              <form method="POST" action="/event/swiss/{{$event->id}}">
                @csrf
                @method('PUT')
                <input type="submit" name="end_attendance" class="btn site-color text-white w-100 m-1" value="出欠を終える" onClick="return requestConfirm();">
              </form>
            </div>
            <div class="col-sm-2">
              <form method="POST" action="/duel/swiss">
                @csrf
                <input type="hidden" name="event_id" value="{{$event->id}}">
                <input type="submit" name="make_duel" class="btn btn-primary w-100 m-1" value="対戦を作成する" onClick="return requestConfirm();">
              </form>
            </div>
            <div class="col-sm-2">
              <form method="POST" action="/event/swiss/{{$event->id}}">
                @csrf
                @method('PUT')
                <input type="submit" name="finish" class="btn site-color text-white w-100 m-1" value="イベント完了する" onClick="return requestConfirm();">
              </form>
            </div>
          @else
            大会運営用の主催者操作ボタン
          @endif
        </div>
      </div>
    </div>
  </div>
@endcan
