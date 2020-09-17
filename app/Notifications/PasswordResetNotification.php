<?php

namespace App\Notifications;

use App\Mail\BareMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    // PasswordResetNotificationクラスに$tokenプロパティを$mailプロパティを定義
    public $token;
    public $mail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

     // コンストラクタで、$tokenと$mailをそれぞれ先のプロパティに代入
    public function __construct(string $token, BareMail $mail)
    {
        $this->token = $token;
        $this->mail = $mail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    // toMailメソッド内でメールの具体的な設定を行っていく
    public function toMail($notifiable)
    {
        return $this->mail
            // fromメソッドの第一引数には送信元のメールアドレス、メールの送信者(省略可)
            -> from(config('mail.from.address'), config('mail.from.name'))

            // toメソッドには送信先のメールアドレスを渡す
            -> to($notifiable->email)

            // subjectメソッドにはメールの件名を渡す
            -> subject('[memo]パスワード再設定')

            // textメソッドは、テキスト形式のメールを送る場合に使う
            // 引数で、メールのテンプレートを指定する
            -> text('emails.password_reset')

            // テンプレートとなるbladeに渡す変数を、withメソッド内に連想配列形式で渡す
            -> with([
                'url' => route('password.reset', [
                    'token' => $this->token,
                    'email' => $notifiable->email,
                ]),
                'count' => config(
                    'auth.passwords'.
                    config('auth.defaults.passwords').
                    '.expire'
                ),
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
