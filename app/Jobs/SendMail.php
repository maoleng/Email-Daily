<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $body_mail;
    private $email;
    private $type;

    public function __construct($body_mail, $email, $type)
    {
        $this->body_mail = $body_mail;
        $this->email = $email;
        $this->type = $type;
    }

    public function handle()
    {
        Mail::mailer($this->type)
        ->to($this->email)->send($this->body_mail);
    }
}
