<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use App\Mail\BodyMail;

class SendMailController extends Controller
{
    public function sendMail(): void
    {
        $body_mail = new BodyMail("HÃY CODE ĐI ANH !!", 'welcome');
        $send_mail = new SendMail($body_mail, '52000724@student.tdtu.edu.vn', 'school');
        dispatch($send_mail);
    }

    public function sendMail2(): void
    {
        $body_mail = new BodyMail("NHANH GỌN LẸ 😊 tệ quá tệ- LẾT CÁI Đ*T ĐI HỌC BÀI LẸ LÊN", 'ven');
        $send_mail = new SendMail($body_mail, 'venn.dev15@gmail.com', 'normal');
        dispatch($send_mail);
    }

}
