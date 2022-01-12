<div class="row justify-content-center row-eq-height mb-4">
  <div class="col-12">
    <div class="box">
      <div class="form-group row">
        <div class="col-md-12">
          <form method="POST" action="/event/user" onClick="return requestConfirm();">
            @csrf
            <table class="table">
              <tr>
                <th>ID</th>
                <th>名前</th>
                <th>レート</th>
                <th>参加ステータス</th>
              </tr>
              @foreach($event->eventUsers as $eventUser)
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
                </tr>
              @endforeach
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
