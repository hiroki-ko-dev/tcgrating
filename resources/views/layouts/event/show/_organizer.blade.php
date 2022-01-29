@can('eventRole',$event->id)
  @if($event->status == \App\Models\Event::STATUS_READY)
      <div class="row justify-content-center row-eq-height mb-4">
        <div class="col-12">
          <div class="box">
            <div class="form-group row">
              <div class="col-md-12">
              {{--参加募集していない場合--}}
                <div class="d-flex flex-row justify-content-center">
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  @endif
@endcan
