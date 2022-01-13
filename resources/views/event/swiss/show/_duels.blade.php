<div class="row justify-content-center">
  <div class="col-12 mb-4">
    <div class="box">
      <div class="d-flex flex-row mb-3">
        @for($i=1;$i<$event->now_match_number+1;$i++)
          <div>
            <button type=“button” onclick="location.href='/duel/swiss/{{$event->id}}?match_number={{$i}}'"
                    class="btn site-color text-white rounded-pill btn-outline-secondary text-center">
              第{{$i}}試合
            </button>
          </div>
        @endfor
      </div>
    </div>
  </div>
</div>
