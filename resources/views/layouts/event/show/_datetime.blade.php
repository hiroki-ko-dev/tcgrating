<div class="row justify-content-center row-eq-height mb-4">
  <div class="col-sm-12">
    <div class="box">
      <div class="d-flex flex-row">
        <div class="w-30 font-weight-bold">イベント日時</div>
        <div class="w-70"><span class="post-user">{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}} ~ {{date('H:i', strtotime($event->start_time))}}</span></div>
      </div>
    </div>
  </div>
</div>
