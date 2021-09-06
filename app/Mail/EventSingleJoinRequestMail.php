<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventSingleJoinRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $event;
    protected $users;

    /**
     * EventSingleCreateMail constructor.
     * @param $event
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //メールアドレスの取得
        return $this->to($this->event->eventUsers[0]->user->email)  // 送信先アドレス
        ->subject('【カードゲーム対戦サイト】あなたの作成した1vs1対戦がマッチングしました')// 件名
        ->text('emails.event.single.join_request')  // 本文
        ->with([
            'event' => $this->event
        ]);    // 本文に送る値
    }
}
