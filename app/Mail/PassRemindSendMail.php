<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PassRemindSendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($auth_key)
    {
        $this->auth_key = $auth_key;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('info@info.com') // 送信元
            ->subject('【パスワード再発行】認証キー送付') // メールタイトル
            ->view('mail.passRemindSendMail') // どのテンプレートを呼び出すか
            ->with([ 'auth_key' => $this->auth_key]); // withオプションでセットしたデータをテンプレートへ受け渡す
    }
}
