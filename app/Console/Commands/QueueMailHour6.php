<?php

namespace App\Console\Commands;

use App\Http\Controllers\TemplateController;
use Illuminate\Console\Command;

class QueueMailHour6 extends Command
{
    public const CRON_TIME = '0 */6 * * *';
    public const COMMAND = 'command:queue_mail_6_hours';

    protected $signature = self::COMMAND;
    protected $description = 'Tự động gửi mail mỗi 6 tiếng';


    public function handle(): void
    {
        (new TemplateController)->queueMail(self::CRON_TIME);
    }
}
