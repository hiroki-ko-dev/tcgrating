@if($event->status == \App\Models\Event::STATUS_FINISH)
  <div class="row justify-content-center mb-4">
    <div class="col-md-12">
      <div class="box">
        <div class="card-text border-bottom p-2">
          <table class="table">
            <thead>
            <tr>
              <th colspan="3" scope="col" class="align-middle">最終順位</th>
            </tr>
            <tr>
              <th scope="col">順位</th>
              <th scope="col" class="align-middle">name</th>
              <th scope="col" class="align-middle">増減レート</th>
            </tr>
            </thead>
            <tbody>
            @foreach($event->eventUsers->sortByDesc(function($query){return $query->event_rate;}) as $i => $eventUser)
              <tr>
                <td scope="col" class="align-middle">{{1+$loop->index}}</td>
                <td scope="col" class="align-middle">{{$eventUser->user->name}}</td>
                <td scope="col" class="align-middle">{{$eventUser->event_rate}}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endif
