<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventSingleCreateMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $event;
    protected $users;

    /**
     * EventSingleCreateMail constructor.
     * @param $event
     * @param $users
     */
    public function __construct($event, $users)
    {
        $this->event = $event;
        $this->users = $users;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //メールアドレスの取得
        $emails = $this->users->pluck('email')->toArray();

        return $this->bcc($emails)  // 送信先アドレス
        ->subject('【遊戯王レーティング】1vs1対戦が作成されました')// 件名
        ->text('emails.event.single.create')  // 本文
        ->with([
            'event' => $this->event
        ]);    // 本文に送る値
    }
}
