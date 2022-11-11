@if($event->now_match_number > 0)
  <div class="box mb-4">
    <div class="row justify-content-center">
      @for($i=1;$i<$event->now_match_number+1;$i++)
        <div class="col-sm-2">
          <button type="button" onclick="location.href='/duel/swiss/{{$event->id}}?match_number={{$i}}'"
                  class="btn site-color text-white btn-outline-secondary text-center w-100 m-1">
            第{{$i}}試合
          </button>
        </div>
      @endfor
    </div>
  </div>
@endif
