<?php

namespace App\Http\Controllers;

use App\Jobs\JobSendMails;
use App\Mail\TemplateMail;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;

class ScheduleController extends Controller
{

    public function queueMail($cron): void
    {
        $templates = Template::query()
            ->whereHas('schedule', static function ($q) use ($cron) {
                $q->where('cron_time', $cron)->where('active', true);
            })
            ->with('user')
            ->get();

        foreach ($templates as $template) {
            $template_mail = new TemplateMail($template);
            $domain = explode('@', $template->user->email)[1];
            if ($domain === 'student.tdtu.edu.vn') {
                $job_send_mail = new JobSendMails($template_mail, 'school', $template);
            } else {
                $job_send_mail = new JobSendMails($template_mail, 'normal', $template);
            }
            dispatch($job_send_mail);
        }
    }

    public function toggleActive(Template $template): RedirectResponse
    {
        if ($template->active === true) {
            $template->update(['active' => false]);
        } else {
            $template->update(['active' => true]);
        }

        return redirect()->route('template.index');
    }

}
