<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class JobSendMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private mixed $template_mail;
    private mixed $email;
    private mixed $type;

    public function __construct($template_mail, $type, $template)
    {
        $this->template_mail = $template_mail;
        $this->type = $type;
        $this->email = $template->user->email;
    }

    public function handle(): void
    {
        Mail::mailer($this->type)
            ->to($this->email)->send($this->template_mail);
    }
}
