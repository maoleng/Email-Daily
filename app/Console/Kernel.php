<?php

namespace App\Console;

use App\Console\Commands\CleanCloudStorageAndDatabase;
use App\Console\Commands\QueueMail\QueueMailDay1;
use App\Console\Commands\QueueMail\QueueMailDay2;
use App\Console\Commands\QueueMail\QueueMailDay3;
use App\Console\Commands\QueueMail\QueueMailDay4;
use App\Console\Commands\QueueMail\QueueMailDay5;
use App\Console\Commands\QueueMail\QueueMailDay6;
use App\Console\Commands\QueueMail\QueueMailDay7;
use App\Console\Commands\QueueMail\QueueMailHour12;
use App\Console\Commands\QueueMail\QueueMailHour2;
use App\Console\Commands\QueueMail\QueueMailHour3;
use App\Console\Commands\QueueMail\QueueMailHour4;
use App\Console\Commands\QueueMail\QueueMailHour6;
use App\Console\Commands\QueueMail\QueueMailHour8;
use App\Console\Commands\ResetCounterSystemMail;
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
        Commands\QueueMail\QueueMailHour2::class,
        Commands\QueueMail\QueueMailHour3::class,
        Commands\QueueMail\QueueMailHour4::class,
        Commands\QueueMail\QueueMailHour6::class,
        Commands\QueueMail\QueueMailHour8::class,
        Commands\QueueMail\QueueMailHour12::class,
        Commands\QueueMail\QueueMailDay1::class,
        Commands\QueueMail\QueueMailDay2::class,
        Commands\QueueMail\QueueMailDay3::class,
        Commands\QueueMail\QueueMailDay4::class,
        Commands\QueueMail\QueueMailDay5::class,
        Commands\QueueMail\QueueMailDay6::class,
        Commands\QueueMail\QueueMailDay7::class,
        Commands\ResetCounterSystemMail::class,
        Commands\CleanCloudStorageAndDatabase::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $this->executeMailCronTime($schedule);
        $this->executeMailDateTime($schedule);
        $schedule->command(ResetCounterSystemMail::COMMAND)->daily();
        $schedule->command(CleanCloudStorageAndDatabase::COMMAND)->daily();
    }

    public function executeMailDateTime($schedule):void
    {
        $templates = Template::query()
            ->whereHas('schedule', static function ($q) {
                $q->whereNull('cron_time')->where('active', true);
            })
            ->with('user')->get();
        foreach ($templates as $template) {
            $time = Carbon::create($template->schedule->date . ' ' . $template->schedule->time);
            $schedule->call(static function () use ($template) {
                $template_mail = new TemplateMail($template);
                $domain = explode('@', $template->user->email)[1];
                if ($domain === 'student.tdtu.edu.vn') {
                    $job_send_mail = new JobSendMails($template_mail, 'school', $template);
                } else {
                    $job_send_mail = new JobSendMails($template_mail, 'normal', $template);
                }
                dispatch($job_send_mail);
                $template->update(['active' => false]);
            })->when(function () use ($time) {
                return $time->toDateTimeString() === now()->seconds(0)->toDateTimeString();
            });
        }
    }

    public function executeMailCronTime($schedule): void
    {
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
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
