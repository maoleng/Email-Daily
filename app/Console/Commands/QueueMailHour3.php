<?php

namespace App\Console\Commands;

use App\Http\Controllers\TemplateController;
use Illuminate\Console\Command;

class QueueMailHour3 extends Command
{
    public const CRON_TIME = '0 */3 * * *';
    public const COMMAND = 'command:queue_mail_3_hours';

    protected $signature = self::COMMAND;
    protected $description = 'Tự động gửi mail mỗi 3 tiếng';


    public function handle(): void
    {
        (new TemplateController)->queueMail(self::CRON_TIME);
    }
}
