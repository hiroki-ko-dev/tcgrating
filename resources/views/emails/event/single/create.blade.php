こんにちは！
カードゲーム対戦サイト自動送信メールです。

新規の1vs1対戦が作成されました。
もしよろしければ以下のURLから対戦を申し込んでください！
{{env('APP_URL')}}/event/single/{{$event->id}}

■対戦ゲーム：{{$event->game->name}}
■主催者；{{$event->eventUsers[0]->user->name}}さん
■開催日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}


引き続き、カードゲーム対戦サイトをよろしくお願いいたします。
