<?php

namespace Zoe\Infrastructure;

use Mail;

class MailModel
{
    protected $mailInstance = null;

    protected $fromEmail = null;

    protected $fromName = null;

    protected $subject = '';

    protected $raw_content = '';

    protected $view = null;

    protected $receiver = [
        'email' => '',
        'name' => ''
    ];

    protected $cc = [];

    protected $bcc = [];

    public function __construct($fromEmail = null, $fromName = null)
    {

    }

    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    public function setReceiver($email, $name)
    {
        $this->receiver['email'] = $email;

        $this->receiver['name'] = $name;

        return $this;
    }

    public function setCC(array $list)
    {
        $this->cc = $list;

        return $this;
    }

    public function setBCC(array $list)
    {
        $this->bcc = $list;

        return $this;
    }

    public function send($data)
    {
        $receiver = $this->receiver;
        $subject = $this->subject;
        $bcc = $this->bcc;
        try {
            Mail::send($this->view, $data, function ($message) use ($receiver, $subject, $bcc) {
                $message->subject($subject);
                $message->to($receiver['email'], $receiver['name']);
                if (!is_null($bcc)) {
                    $message->bcc($bcc);
                }
            });
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function sendRaw($message)
    {

    }

    public function sendByAfter($data, $second)
    {

    }

    public function sendByQueue($data)
    {

    }
}