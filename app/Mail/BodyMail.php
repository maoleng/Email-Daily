<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class BodyMail extends Mailable
{
    use Queueable, SerializesModels;

    private $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function build()
    {
        return $this
            ->subject($this->title)
            ->view('welcome');
    }
}
