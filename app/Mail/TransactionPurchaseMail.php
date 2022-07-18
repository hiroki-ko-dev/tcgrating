<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionPurchaseMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $transaction;

    /**
     * TransactionPurchaseMail constructor.
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //メールアドレスの取得
        return $this->to($this->transaction->transactionUsers[0]->email)  // 送信先アドレス
                    ->bcc(env('MAIL_FROM_ADDRESS'))
                    ->subject('商品のご購入頂きありがとうございます')// 件名
                    ->text('emails.item.transaction.purchase')  // 本文
                    ->with([
                        'transaction' => $this->transaction,
                        'transactionUser' => $this->transaction->transactionUsers[0],
                    ]);    // 本文に送る値
    }
}
