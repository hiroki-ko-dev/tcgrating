<div class="row justify-content-center row-eq-height mb-4">
  <div class="col-12">
    <div class="box">
      <div class="form-group row">
        <div class="col-md-12">
          @if(!(Auth::check()))
            参加にはログインが必要です
          @elseif($event->eventUsers->where('user_id',Auth::id())->isEmpty())
            <form method="POST" action="/event/user" onClick="return requestConfirm();">
              @csrf
                <input type="hidden" name="event_id" value="{{$event->id}}">
                <button type="submit" name="event_add_user" value="1" class="btn site-color text-white rounded-pill btn-outline-secondary text-center">
                  {{ __('イベント申込') }}
                </button>
            </form>
          @else
            すでに申込済です
            <form method="POST" action="/event/user/{{$event->id}}" onClick="return requestConfirm();">
              @csrf
              @method('PUT')
                <input type="hidden" name="user_id" value="{{Auth::id()}}">
                <input type="submit" name="cancel" class="btn btn-secondary rounded-pill pl-4 pr-4" value="参加をキャンセルする">
            </form>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
