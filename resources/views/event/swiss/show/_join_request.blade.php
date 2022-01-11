
<form method="POST" action="/event/user/join/request" onClick="return requestConfirm();">
  @csrf
  <input type="hidden" name="event_id" value="{{$event->id}}">
  <div class="row justify-content-center mb-4">
    <div class="col-12">
      <div class="box">
        <div class="form-group row">
          <div class="col-md-12">
            <input type="submit" name="group_id_0" value="参加申込" class="btn site-color text-white rounded-pill btn-outline-secondary text-center">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-12">
      <div class="box">
        <div class="form-group row">
          <div class="col-md-12">
            <button type="submit" name="group_id_1" value="1" class="btn site-color text-white rounded-pill btn-outline-secondary text-center">
              {{ __('参加申込') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
