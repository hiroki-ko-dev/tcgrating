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
        return $this->to($this->event->eventUser[0]->user->email)  // 送信先アドレス
        ->subject('【遊戯王レーティング】あなたの作成した1vs1決闘がマッチングしました')// 件名
        ->text('emails.event.single.join_request')  // 本文
        ->with([
            'event' => $this->event
        ]);    // 本文に送る値
    }
}