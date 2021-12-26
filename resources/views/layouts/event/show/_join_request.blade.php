<div class="row justify-content-center row-eq-height mb-4">
  <div class="col-12">
    <div class="box">
      <div class="form-group row">
        <div class="col-md-12">
          <form method="POST" action="/event/user" onClick="return requestConfirm();">
            @csrf
            <input type="hidden" name="event_id" value="{{$event->id}}">
            <button type="submit" name="event_add_user" value="1" class="btn site-color text-white rounded-pill btn-outline-secondary text-center">
              {{ __('イベント申込') }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
