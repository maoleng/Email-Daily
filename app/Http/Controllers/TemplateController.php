<?php

namespace App\Http\Controllers;

use App\Http\Requests\Template\StoreRequest;
use App\Jobs\JobSendMails;
use App\Mail\TemplateMail;
use App\Models\Template;
use Illuminate\Contracts\View\View;

class TemplateController extends Controller
{
    public function index(): View
    {
        return view('app.template.index');
    }

    public function create(): View
    {
        return view('app.template.create');
    }

    public function edit(): View
    {
        return view('app.template.edit');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->all();

        Template::query()->create([
            'title' => $data['title'],
            'content' => $data['content'],
            'sender' => $data['sender'],
            'cron_time' => $data['repeat_time'] ?? null,
            'date' => $data['date'] ?? null,
            'time' => $data['time'] ?? null,
            'user_id' => authed()->id,
        ]);

    }

    public function queueMail($cron): void
    {
        $templates = Template::query()
            ->where('cron_time', $cron)
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

}







