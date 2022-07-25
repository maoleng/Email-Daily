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

    public function __construct($body_mail, $email)
    {
        $this->body_mail = $body_mail;
        $this->email = $email;
    }

    public function handle()
    {
        Mail::mailer('normal')
        ->to($this->email)->send($this->body_mail);
    }
}
