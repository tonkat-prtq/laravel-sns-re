<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BareMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    // buildメソッドは、メソッド内にメールの宛先や件名、使用するテンプレート(Blade)などを設定するコードを追加した上で自分自身を返す
    // 今回作成したBareMailクラスでは、メールの種類ごとの細かい設定は持たせず、その名の通り「空っぽ」の設定のメールとして使用
    // そのため、buildメソッドでは何も設定せず、そのまま自分自身を返すようにしてある
    public function build()
    {
        return $this;
    }
}
