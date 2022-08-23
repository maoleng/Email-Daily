<?php

namespace App\Http\Controllers;

use App\Http\Requests\Template\StoreRequest;
use App\Jobs\JobSendMails;
use App\Mail\TemplateMail;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Contracts\View\View as ViewReturn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    public function __construct()
    {
        View::share('menu', 'Mẫu tin nhắn');
        View::share('route', 'template.index');
    }

    public function index(): ViewReturn
    {
        $templates = Template::query()->where('user_id', authed()->id)->orderBy('created_at', 'DESC')->get();

        return view('app.template.index', [
            'templates' => $templates,
            'breadcrumb' => 'Trang chủ'
        ]);
    }

    public function create(): ViewReturn
    {
        return view('app.template.create', [
            'breadcrumb' => 'Thêm',
        ]);
    }

    public function edit(Template $template): ViewReturn
    {
        return view('app.template.edit', [
            'template' => $template,
            'breadcrumb' => 'Chỉnh sửa'
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $mail_content = $data['content'];
        preg_match_all('/data:image\/[A-Za-z-]+;base64.[A-Za-z+\/0-9=]+/', $data['content'], $matches, PREG_OFFSET_CAPTURE);
        $images = $matches[0];
        foreach ($images as $image) {
            $content = base64_decode(explode(';base64,', $image[0])[1]);
            $mime = $this->getMimeType($image[0]);
            if (empty($mime)) {
                Session::flash('message', 'Sai thể loại ảnh');
                return redirect()->back();
            }
            $file_name = Str::random(15) . '.' . $mime;
            Storage::disk('google')->put($file_name, $content);
            $path = Storage::disk('google')->url($file_name);
            $mail_content = str_replace($image[0], $path, $mail_content);
        }

        if (isset($data['date'], $data['time'])) {
            $date = Carbon::make($data['date'])->toDateString();
            $time = Carbon::make($data['time'])->toTimeString();
        }
        Template::query()->create([
            'title' => $data['title'],
            'content' => $mail_content,
            'sender' => $data['sender'],
            'cron_time' => $data['cron_time'] ?? null,
            'date' => $date ?? null,
            'time' => $time ?? null,
            'banner' => Template::BANNER,
            'user_id' => authed()->id,
        ]);

        return redirect()->route('template.index');
    }

    public function getMimeType($base64): ?string
    {
        if (str_starts_with($base64, 'data:image/bmp')) {
            return 'bmp';
        }
        if (str_starts_with($base64, 'data:image/jpeg')) {
            return 'jpg';
        }
        if (str_starts_with($base64, 'data:image/png')) {
            return 'png';
        }
        if (str_starts_with($base64, 'data:image/x-icon')) {
            return 'ico';
        }
        if (str_starts_with($base64, 'data:image/webp')) {
            return 'webp';
        }
        if (str_starts_with($base64, 'data:image/gif')) {
            return 'gif';
        }


        return null;
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
