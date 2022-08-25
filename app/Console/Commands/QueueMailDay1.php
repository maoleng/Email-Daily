<?php

namespace App\Console\Commands;

use App\Http\Controllers\ScheduleController;
use Illuminate\Console\Command;

class QueueMailDay1 extends Command
{
    public const CRON_TIME = '0 0 */1 * *';
    public const COMMAND = 'command:queue_mail_1_day';

    protected $signature = self::COMMAND;
    protected $description = 'Tự động gửi mail mỗi 1 ngày';


    public function handle(): void
    {
        (new ScheduleController)->queueMail(self::CRON_TIME);
    }
}
