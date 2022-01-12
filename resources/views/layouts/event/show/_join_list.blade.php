<div class="row justify-content-center row-eq-height mb-4">
  <div class="col-12">
    <div class="box">
      <div class="form-group row">
        <div class="col-md-12">
          <table class="table">
            <tr>
              <th>ID</th>
              <th>名前</th>
              <th>レート</th>
              <th>参加ステータス</th>
              @if(Auth::check()
                 && Auth::user()->eventUsers->where('event_id', $event->id)->isNotEmpty()
                 && Auth::user()->eventUsers->where('event_id', $event->id)->first()->status == \App\Models\EventUser::STATUS_MASTER)
                <th>主催者ボタン</th>
              @endif
            </tr>
            @foreach($event->eventUsers as $eventUser)
              <form method="POST" action="/event/user/{{$event->id}}" onClick="return requestConfirm();">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{$eventUser->user_id}}">
                <tr>
                  <td>{{$eventUser->user_id}}</td>
                  <td>{{$eventUser->user->name}}</td>
                  @if($eventUser->user->gameUsers->where('game_id',$event->game_id)->isEmpty())
                    <td>0</td>
                  @else
                    <td>{{$eventUser->user->gameUsers->where('game_id',$event->game_id)->first()->rate}}</td>
                  @endif
                  @if($eventUser->status == \App\Models\EventUser::STATUS_REQUEST)
                    <td>参加申込中</td>
                  @elseif($eventUser->status == \App\Models\EventUser::STATUS_APPROVAL)
                    <td>参加確定</td>
                  @elseif($eventUser->status == \App\Models\EventUser::STATUS_REJECT)
                    <td>キャンセル</td>
                  @elseif($eventUser->status == \App\Models\EventUser::STATUS_MASTER)
                    <td>主催者</td>
                  @endif
                  <td>
                  @if(Auth::check()
                     && Auth::user()->eventUsers->where('event_id', $event->id)->isNotEmpty()
                     && Auth::user()->eventUsers->where('event_id', $event->id)->first()->status == \App\Models\EventUser::STATUS_MASTER)
                      <input type="hidden" name="user_id" value="{{$eventUser->user_id}}">
                      <input type="submit" name="approval" class="btn btn-primary rounded-pill pl-4 pr-4" value="承認">
                      <input type="submit" name="reject" class="btn btn-secondary rounded-pill pl-4 pr-4" value="却下">
                  @endif
                </tr>
              </form>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
