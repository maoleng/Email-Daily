<?php

namespace App\Console\Commands\QueueMail;

use App\Http\Controllers\ScheduleController;
use Illuminate\Console\Command;

class QueueMailDay4 extends Command
{
    public const CRON_TIME = '0 0 */4 * *';
    public const COMMAND = 'command:queue_mail_4_day';

    protected $signature = self::COMMAND;
    protected $description = 'Tự động gửi mail mỗi 4 ngày';


    public function handle(): void
    {
        (new ScheduleController)->queueMail(self::CRON_TIME);
    }
}
