<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNoticeCreateEventSingleMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;

    /**
     * AdminNoticeCreateEventSingleMail constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = env('APP_URL').$url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(env('MAIL_FROM_ADDRESS'))  // 送信先アドレス
        ->subject('【遊戯王レーティング】イベントが作成されました')// 件名
        ->text('emails.admin_notice.create_event_single')  // 本文
        ->with(['url' => $this->url]);    // 本文に送る値
    }
}
