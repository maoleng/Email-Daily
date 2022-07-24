<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use App\Mail\BodyMail;

class SendMailController extends Controller
{
    public function sendMail(): void
    {
        $body_mail = new BodyMail("HÃY CODE ĐI ANH !!");
        $send_mail = new SendMail($body_mail, '521h0504@student.tdtu.edu.vn');
        dispatch($send_mail);
    }
}
//52000724
