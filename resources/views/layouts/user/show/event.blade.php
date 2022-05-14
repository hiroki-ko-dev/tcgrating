<div class="box text-left">
  <div class="box-header">{{ __('参加中イベント') }}</div>
  @foreach($events as $event)
    @if($event->event_category_id == \App\Models\EventCategory::CATEGORY_SINGLE)
      @if(isset(Auth::user()->selected_game_id) && $event->game_id == Auth::user()->selected_game_id)
        @if($event->status == \App\Models\Event::STATUS_RECRUIT)
          <div type="body"><a href="/duel/instant/{{$event->eventDuels[0]->duel_id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(対戦相手受付中)</a></div>
        @elseif($event->status == \App\Models\Event::STATUS_READY)
          <div type="body"><a href="/duel/instant/{{$event->eventDuels[0]->duel_id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(マッチング済)</a></div>
        @endif
      @elseif(session('selected_game_id') && $user->gameUsers->where('game_id', session('selected_game_id'))->isNotEmpty() && $event->game_id == $user->gameUsers->where('game_id', session('selected_game_id'))->first()->game_id)
        @if($event->status == \App\Models\Event::STATUS_RECRUIT)
          <div type="body"><a href="/duel/instant/{{$event->eventDuels[0]->duel_id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(対戦相手受付中)</a></div>
        @elseif($event->status == \App\Models\Event::STATUS_READY)
          <div type="body"><a href="/duel/instant/{{$event->eventDuels[0]->duel_id}}">・{{$event->title}} 対戦日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}(マッチング済)</a></div>
        @endif
      @endif
    @endif
  @endforeach
</div>
