<?php

namespace App\Console;

use App\Console\Commands\QueueMailHour12;
use App\Console\Commands\QueueMailDay1;
use App\Console\Commands\QueueMailDay2;
use App\Console\Commands\QueueMailHour2;
use App\Console\Commands\QueueMailDay3;
use App\Console\Commands\QueueMailHour3;
use App\Console\Commands\QueueMailDay4;
use App\Console\Commands\QueueMailHour4;
use App\Console\Commands\QueueMailDay5;
use App\Console\Commands\QueueMailDay6;
use App\Console\Commands\QueueMailHour6;
use App\Console\Commands\QueueMailDay7;
use App\Console\Commands\QueueMailHour8;
use App\Jobs\JobSendMails;
use App\Mail\TemplateMail;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\LoopSendMail::class,
        Commands\LoopSendMailVen::class,
        Commands\QueueMailHour2::class,
        Commands\QueueMailHour3::class,
        Commands\QueueMailHour4::class,
        Commands\QueueMailHour6::class,
        Commands\QueueMailHour8::class,
        Commands\QueueMailHour12::class,
        Commands\QueueMailDay1::class,
        Commands\QueueMailDay2::class,
        Commands\QueueMailDay3::class,
        Commands\QueueMailDay4::class,
        Commands\QueueMailDay5::class,
        Commands\QueueMailDay6::class,
        Commands\QueueMailDay7::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:send_mail')->everyThirtyMinutes();
        $schedule->command('command:send_mail_ven')->everyTwoHours();
        $schedule->command(QueueMailHour2::COMMAND)->cron(QueueMailHour2::CRON_TIME);
        $schedule->command(QueueMailHour3::COMMAND)->cron(QueueMailHour3::CRON_TIME);
        $schedule->command(QueueMailHour4::COMMAND)->cron(QueueMailHour4::CRON_TIME);
        $schedule->command(QueueMailHour6::COMMAND)->cron(QueueMailHour6::CRON_TIME);
        $schedule->command(QueueMailHour8::COMMAND)->cron(QueueMailHour8::CRON_TIME);
        $schedule->command(QueueMailHour12::COMMAND)->cron(QueueMailHour12::CRON_TIME);
        $schedule->command(QueueMailDay1::COMMAND)->cron(QueueMailDay1::CRON_TIME);
        $schedule->command(QueueMailDay2::COMMAND)->cron(QueueMailDay2::CRON_TIME);
        $schedule->command(QueueMailDay3::COMMAND)->cron(QueueMailDay3::CRON_TIME);
        $schedule->command(QueueMailDay4::COMMAND)->cron(QueueMailDay4::CRON_TIME);
        $schedule->command(QueueMailDay5::COMMAND)->cron(QueueMailDay5::CRON_TIME);
        $schedule->command(QueueMailDay6::COMMAND)->cron(QueueMailDay6::CRON_TIME);
        $schedule->command(QueueMailDay7::COMMAND)->cron(QueueMailDay7::CRON_TIME);


        $templates = Template::query()->whereNull('cron_time')->where('active', true)
            ->with('user')->get();
        foreach ($templates as $template) {
            $time = Carbon::create($template->date . ' ' . $template->time);
            $schedule->call(static function () use ($template) {
                $template_mail = new TemplateMail($template);
                $domain = explode('@', $template->user->email)[1];
                if ($domain === 'student.tdtu.edu.vn') {
                    $job_send_mail = new JobSendMails($template_mail, 'school', $template);
                } else {
                    $job_send_mail = new JobSendMails($template_mail, 'normal', $template);
                }
                dispatch($job_send_mail);
            })->when(function () use ($time) {
                return $time->toDateTimeString() === now()->seconds(0)->toDateTimeString();
            });
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
