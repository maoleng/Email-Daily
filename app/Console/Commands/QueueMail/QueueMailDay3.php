<?php

namespace App\Console\Commands\QueueMail;

use App\Http\Controllers\ScheduleController;
use Illuminate\Console\Command;

class QueueMailDay3 extends Command
{
    public const CRON_TIME = '0 0 */3 * *';
    public const COMMAND = 'command:queue_mail_3_day';

    protected $signature = self::COMMAND;
    protected $description = 'Tự động gửi mail mỗi 3 ngày';


    public function handle(): void
    {
        (new ScheduleController)->queueMail(self::CRON_TIME);
    }
}
