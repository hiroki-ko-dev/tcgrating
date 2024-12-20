<div class="row justify-content-center row-eq-height mb-4">
  <div class="col-12">
    <div class="box">
      <div class="form-group row">
        <div class="col-md-12">
         {{--まだ参加募集している場合--}}
          @if(!(Auth::check()))
            参加にはログインが必要です
          @elseif($event->status == \App\Enums\EventStatus::RECRUIT->value)
            @if($event->eventUsers->where('user_id',Auth::id())->isEmpty())
              <form method="POST" action="/event/user">
                @csrf
                  <input type="hidden" name="event_id" value="{{$event->id}}">

                  <div class="d-flex flex-row mb-3">
                    <div class="w-30">{{ __('Discordでの名前') }}</div>
                    <div class="w-70">
                      @if(Auth::user()->gameUsers->where('game_id', $event->game_id)->first())
                        <input type="text" placeholder="#と数字まで入れる" class="form-control w-100 @error('discord_name') is-invalid @enderror" name="discord_name" value="{{ old('discord_name', Auth::user()->gameUsers->where('game_id', $event->game_id)->first()->discord_name) }}" required>
                      @else
                        <input type="text" placeholder="#と数字まで入れる" class="form-control w-100 @error('discord_name') is-invalid @enderror" name="discord_name" value="{{ old('discord_name') }}" required>
                      @endif
                      @error('discord_name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>

                  <button type="submit" name="event_add_user" value="1" class="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                          onClick="return requestConfirm();">
                    {{ __('イベント申込') }}
                  </button>
              </form>
            @else
              @if($event->eventUsers->where('user_id',Auth::id())->first()->status == \App\Enums\EventUserStatus::REJECT->value)
                キャンセル済です
              @else
                @if($event->eventUsers->where('user_id',Auth::id())->first()->status == \App\Enums\EventUserStatus::REQUEST->value)
                  すでに申込済です
                @elseif($event->eventUsers->where('user_id',Auth::id())->first()->status == \App\Enums\EventUserStatus::APPROVAL->value)
                  参加確定しました
                @elseif($event->eventUsers->where('user_id',Auth::id())->first()->status == \App\Enums\EventUserStatus::MASTER->value)
                  主催者モード
                @endif
                  <form method="POST" action="/event/user/{{$event->id}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{Auth::id()}}">
                    <input type="submit" name="reject" class="btn btn-secondary rounded-pill pl-4 pr-4" value="ドロップする" onClick="return requestConfirm();">
                  </form>
              @endif
            @endif
          {{--参加募集していない場合--}}
          @else
            @if($event->eventUsers->where('user_id',Auth::id())->first()->status == \App\Enums\EventUserStatus::REJECT->value)
              キャンセル済です
            @else
              既に参加を締め切っています。
              @if(Auth::check() && $event->eventUsers->where('user_id',Auth::id())->isNotEmpty()))
                <form method="POST" action="/event/user/{{$event->id}}">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="user_id" value="{{Auth::id()}}">
                  <input type="submit" name="reject" class="btn btn-secondary pl-4 pr-4" value="ドロップする" onClick="return requestConfirm();">
                </form>
              @endif
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
