<?php

namespace Zoe\Services;

use Zoe\Infrastructure\MailModel;

class MailService
{
    protected $mail = null;

    public function __construct(MailModel $mailModel)
    {
        $this->mail = $mailModel;
    }

    public function sendRegisterConfirmEmail($user)
    {
        $this->mail->setSubject('會員註冊信件');
        $this->mail->setReceiver($user->email, $user->name);
        $this->mail->setView('emails.register');

        return $this->mail->send(['user' => $user]);
    }

    public function sendForgotPasswordEmail($user)
    {
        $this->mail->setSubject('忘記密碼確認信');
        $this->mail->setReceiver($user->email, $user->name);
        $this->mail->setView('emails.forgot');

        return $this->mail->send(['user' => $user]);
    }
}