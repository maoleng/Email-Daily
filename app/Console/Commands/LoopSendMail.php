<?php

namespace App\Console\Commands;

use App\Http\Controllers\SendMailController;
use Illuminate\Console\Command;

class LoopSendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tự động gửi mail';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new SendMailController())->sendMail();
        return 0;
    }
}
