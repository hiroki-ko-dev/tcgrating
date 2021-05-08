こんにちは！
遊戯王レーティング自動送信メールです。

あなたの作成した1vs1決闘に対戦相手が現れました。
もしよろしければ以下のURLから確認してください。
{{env('APP_URL')}}/event/single/{{$event->id}}

■対戦相手；{{$event->eventUser[1]->user->name}}さん
■開催日時：{{date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time))}}

引き続き、遊戯王レーティングサイトをよろしくお願いいたします。
