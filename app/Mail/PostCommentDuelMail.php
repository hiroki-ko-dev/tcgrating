<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostCommentDuelMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $emails;
    protected $post;
    protected $comment;

    /**
     * PostCommentEventMail constructor.
     * @param $emails
     * @param $post
     * @param $comment
     */
    public function __construct($emails, $post, $comment)
    {
        $this->emails  = $emails;
        $this->post    = $post;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //メールアドレスの取得
        return $this->bcc($this->emails)  // 送信先アドレス
        ->subject('【カードゲーム対戦サイト】あなたの参加している決闘掲示板に返信が来ました')// 件名
        ->text('emails.post.comment.duel')  // 本文
        ->with([
            'post'    => $this->post,
            'comment' => $this->comment,
        ]);    // 本文に送る値
    }
}
