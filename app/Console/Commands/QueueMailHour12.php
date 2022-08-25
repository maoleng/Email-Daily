<?php

namespace App\Console\Commands;

use App\Http\Controllers\ScheduleController;
use Illuminate\Console\Command;

class QueueMailHour12 extends Command
{
    public const CRON_TIME = '0 */12 * * *';
    public const COMMAND = 'command:queue_mail_12_hours';

    protected $signature = self::COMMAND;
    protected $description = 'Tự động gửi mail mỗi 12 tiếng';


    public function handle(): void
    {
        (new ScheduleController)->queueMail(self::CRON_TIME);
    }
}
