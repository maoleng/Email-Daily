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

    public function __construct($title, $view)
    {
        $this->title = $title;
        $this->view = $view;
    }

    public function build()
    {
        return $this
            ->from('napoleon_dai_de@tanthe.com', 'Lời thì thầm của Chúa')
            ->subject($this->title)
            ->view($this->view);
    }
}
