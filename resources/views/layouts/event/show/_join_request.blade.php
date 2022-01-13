<div class="row justify-content-center row-eq-height mb-4">
  <div class="col-12">
    <div class="box">
      <div class="form-group row">
        <div class="col-md-12">
         {{--まだ参加募集している場合--}}
          @if($event->status == \App\Models\Event::STATUS_RECRUIT)
            @if(!(Auth::check()))
              参加にはログインが必要です
            @elseif($event->eventUsers->where('user_id',Auth::id())->isEmpty())
              <form method="POST" action="/event/user">
                @csrf
                  <input type="hidden" name="event_id" value="{{$event->id}}">
                  <button type="submit" name="event_add_user" value="1" class="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                          onClick="return requestConfirm();">
                    {{ __('イベント申込') }}
                  </button>
              </form>
            @else
              @if($event->eventUsers->where('user_id',Auth::id())->first()->status == \App\Models\EventUser::STATUS_REQUEST)
                すでに申込済です
                <form method="POST" action="/event/user/{{$event->id}}">
                  @csrf
                  @method('PUT')
                    <input type="hidden" name="user_id" value="{{Auth::id()}}">
                    <input type="submit" name="reject" class="btn btn-secondary rounded-pill pl-4 pr-4" value="参加をキャンセルする" onClick="return requestConfirm();">
                </form>
              @elseif($event->eventUsers->where('user_id',Auth::id())->first()->status == \App\Models\EventUser::STATUS_APPROVAL)
                参加確定しました
              @elseif($event->eventUsers->where('user_id',Auth::id())->first()->status == \App\Models\EventUser::STATUS_REJECT)
                キャンセル済です
              @elseif($event->eventUsers->where('user_id',Auth::id())->first()->status == \App\Models\EventUser::STATUS_MASTER)
                主催者モード
              @endif
            @endif
          {{--参加募集していない場合--}}
          @else
            参加を締め切っています
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
