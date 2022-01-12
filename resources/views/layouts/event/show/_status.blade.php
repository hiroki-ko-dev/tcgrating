<div class="row justify-content-center row-eq-height">
  <div class="col-12 mb-4">
    <div class="box">
      <div class="d-flex flex-row mb-3">
        <div class="w-30 font-weight-bold">イベントステータス</div>
        @if($event->status == \APP\Models\Event::STATUS_RECRUIT )
          <span class="post-user w-70">{{ __('参加申込受付中') }}</span>
        @elseif($event->status == \APP\Models\Event::STATUS_READY )
          <span class="post-user w-70">{{ __('参加締切済') }}</span>
        @elseif($event->status == \APP\Models\Event::STATUS_FINISH )
          <span class="post-user w-70">{{ __('イベント終了') }}</span>
        @elseif($event->status == \APP\Models\Event::STATUS_CANCEL )
          <span class="post-user w-70">{{ __('イベントキャンセル') }}</span>
        @elseif($event->status == \APP\Models\Event::STATUS_INVALID )
          <span class="post-user w-70">{{ __('イベント無効') }}</span>
        @endif
      </div>
      {{-- 対戦相手を募集している段階ではキャンセルができる --}}
      @if($event->status == \APP\Models\Event::STATUS_RECRUIT && Auth::id() == $event->user_id)
        {{--1vs1対戦の時のボタン--}}
        @if($event->event_category_id == \App\Models\EventCategory::CATEGORY_SINGLE)
          <form method="POST" action="/event/single/{{$event->id}}" onClick="return requestConfirm();">
            @csrf
            @method('PUT')
            {{--  なぜかputだとsubmitに値を持たせられないので判定用にhidden--}}
            <input type="hidden" name="event_cancel" value="1" >
            <button type="submit" class="btn btn-secondary rounded-pill pl-4 pr-4">
              {{ __('キャンセル') }}
            </button>
          </form>
        {{--スイスドローの時のボタン--}}
        @elseif($event->event_category_id == \App\Models\EventCategory::CATEGORY_SWISS)
          <form method="POST" action="/event/swiss/{{$event->id}}" onClick="return requestConfirm();">
            @csrf
            @method('PUT')
            {{--  なぜかputだとsubmitに値を持たせられないので判定用にhidden--}}
            <input type="submit" name="ready" class="btn btn-secondary rounded-pill pl-4 pr-4" value="参加締切">
            <input type="submit" name="cancel" class="btn btn-secondary rounded-pill pl-4 pr-4" value="キャンセル">
          </form>
        @endif
      @endif
    </div>
  </div>
</div>
