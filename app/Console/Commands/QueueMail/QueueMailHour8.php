<?php

namespace App\Console\Commands\QueueMail;

use App\Http\Controllers\ScheduleController;
use Illuminate\Console\Command;

class QueueMailHour8 extends Command
{
    public const CRON_TIME = '0 */8 * * *';
    public const COMMAND = 'command:queue_mail_8_hours';

    protected $signature = self::COMMAND;
    protected $description = 'Tự động gửi mail mỗi 8 tiếng';


    public function handle(): void
    {
        (new ScheduleController)->queueMail(self::CRON_TIME);
    }
}
