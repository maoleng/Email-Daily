<?php

namespace App\Console\Commands\QueueMail;

use App\Http\Controllers\ScheduleController;
use Illuminate\Console\Command;

class QueueMailDay5 extends Command
{
    public const CRON_TIME = '0 0 */5 * *';
    public const COMMAND = 'command:queue_mail_5_day';

    protected $signature = self::COMMAND;
    protected $description = 'Tự động gửi mail mỗi 5 ngày';


    public function handle(): void
    {
        (new ScheduleController)->queueMail(self::CRON_TIME);
    }
}
