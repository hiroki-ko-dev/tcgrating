<div class="row justify-content-center row-eq-height mb-4">
  <div class="col-12">
    <div class="box">
      <div class="form-group row">
        <div class="col-md-12">
          <table class="table">
            <tr>
              <th class="w-10">ID</th>
              <th>名前</th>
              <th>ステータス</th>
              @can('eventRole',$event->id)
                <th>主催者用</th>
              @endif
              <th class="w-20">出欠</th>
            </tr>
            @foreach($event->eventUsers as $eventUser)
              <form method="POST" action="/event/user/{{$event->id}}" onClick="return requestConfirm();">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{$eventUser->user_id}}">
                <tr>
                  <td>{{$eventUser->user_id}}</td>
                  <td>{{$eventUser->user->name}}</td>
                  @if($eventUser->status == \App\Enums\EventUser::REQUEST->value)
                    <td>参加申込中</td>
                  @elseif($eventUser->status == \App\Enums\EventUser::APPROVAL->value)
                    <td>参加確定</td>
                  @elseif($eventUser->status == \App\Enums\EventUser::REJECT->value)
                    <td>キャンセル</td>
                  @elseif($eventUser->status == \App\Enums\EventUser::MASTER->value)
                    <td>主催者</td>
                  @endif
                  @can('eventRole',$event->id)
                    <td>
                        <input type="hidden" name="user_id" value="{{$eventUser->user_id}}">
                        <input type="submit" name="approval" class="btn btn-primary m-1" value="承認">
                        <input type="submit" name="reject" class="btn btn-secondary m-1" value="却下">
                    </td>
                  @endcan
                  <td>
                    @if($eventUser->attendance == \App\Enums\EventUserAttendance::READY->value)
                      @if(Auth::check() && (Auth::user()->can('eventRole',$event->id) || Auth::id() == $eventUser->user_id))
                        <input type="hidden" name="event_user_id" value="{{$eventUser->id}}">
                        <input type="submit" name="attended" class="btn btn-primary" value="出席">
                      @endif
                    @elseif($eventUser->attendance == \App\Enums\EventUserAttendance::ATTENDED->value)
                      出席
                    @elseif($eventUser->attendance == \App\Enums\EventUserAttendance::ABSENT->value)
                      欠席
                    @else
                    @endif
                  </td>
                </tr>
              </form>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
