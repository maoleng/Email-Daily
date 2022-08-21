<?php

namespace App\Http\Controllers;

use App\Http\Requests\Template\StoreRequest;
use App\Http\Requests\Template\UpdateRequest;
use App\Jobs\JobSendMails;
use App\Mail\TemplateMail;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;

class TemplateController extends Controller
{
    public function index(): View
    {
        $templates = Template::query()->where('user_id', authed()->id)->get();

        return view('app.template.index', [
            'templates' => $templates
        ]);
    }

    public function create(): View
    {
        return view('app.template.create');
    }

    public function edit(Template $template): View
    {
        return view('app.template.edit', [
            'template' => $template
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->all();
        dd($data);
        if (isset($data['date'], $data['time'])) {
            $date = Carbon::make($data['date'])->toDateString();
            $time = Carbon::make($data['time'])->toTimeString();
        }
        Template::query()->create([
            'title' => $data['title'],
            'content' => $data['content'],
            'sender' => $data['sender'],
            'cron_time' => $data['repeat_time'] ?? null,
            'date' => $date ?? null,
            'time' => $time ?? null,
            'banner' => Template::BANNER,
            'user_id' => authed()->id,
        ]);

        return redirect()->route('template.index');
    }

    public function update(StoreRequest $request, Template $template): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['date'], $data['time'])) {
            $data['date'] = Carbon::make($data['date'])->toDateString();
            $data['time'] = Carbon::make($data['time'])->toTimeString();
        }
        $template->update($data);

        return redirect()->route('template.index');
    }

    public function queueMail($cron): void
    {
        $templates = Template::query()
            ->where('cron_time', $cron)
            ->where('active', true)
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

    public function destroy(Template $template): RedirectResponse
    {
        $template->delete();

        return redirect()->route('template.index');
    }

}
