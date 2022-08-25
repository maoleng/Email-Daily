<?php

namespace App\Console\Commands;

use App\Http\Controllers\ScheduleController;
use Illuminate\Console\Command;

class QueueMailDay2 extends Command
{
    public const CRON_TIME = '0 0 */2 * *';
    public const COMMAND = 'command:queue_mail_2_day';

    protected $signature = self::COMMAND;
    protected $description = 'Tự động gửi mail mỗi 2 ngày';


    public function handle(): void
    {
        (new ScheduleController)->queueMail(self::CRON_TIME);
    }
}
