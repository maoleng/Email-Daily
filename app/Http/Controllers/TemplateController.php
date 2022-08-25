<?php

namespace App\Http\Controllers;

use App\Http\Requests\Template\StoreRequest;
use App\Jobs\JobSendMails;
use App\Mail\TemplateMail;
use App\Models\Image;
use App\Models\Schedule;
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
        $templates = Template::query()
            ->where('user_id', authed()->id)
            ->where('active', true)
            ->with('schedule')
            ->orderBy('created_at', 'DESC')->get();

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

        $template = Template::query()->create([
            'title' => $data['title'],
            'sender' => $data['sender'],
            'banner' => Template::BANNER,
            'user_id' => authed()->id,
        ]);
        if (isset($data['date'], $data['time'])) {
            $date = Carbon::make($data['date'])->toDateString();
            $time = Carbon::make($data['time'])->toTimeString();
        }
        Schedule::query()->create([
            'cron_time' => $data['cron_time'] ?? null,
            'date' => $date ?? null,
            'time' => $time ?? null,
            'template_id' => $template->id,
        ]);

        $mail_content = $this->handleImage($data['content'], $template);
        $template->update(['content' => $mail_content]);

        return redirect()->route('template.index');
    }

    public function handleImage($mail_content, $template)
    {
        preg_match_all('/data:image\/[A-Za-z-]+;base64.[A-Za-z+\/0-9=]+/', $mail_content, $matches, PREG_OFFSET_CAPTURE);
        $images = $matches[0];
        if (isset($images)) {
            foreach ($images as $image) {
                $content = base64_decode(explode(';base64,', $image[0])[1]);
                $mime = $this->getMimeType($image[0]);
                if (empty($mime)) {
                    Session::flash('message', 'Sai thể loại ảnh');
                    return redirect()->back();
                }
                $path = 'user-' . authed()->id . '/template-' . $template->id . '/'. Str::random(15) . '.' . $mime;
                Storage::disk('google')->put($path, $content);
                $source = Storage::disk('google')->url($path);
                Image::query()->create([
                    'source' => $source,
                    'size' => strlen($image[0]),
                    'path' => $path,
                    'template_id' => $template->id,
                ]);
                $mail_content = str_replace($image[0], $source, $mail_content);
            }
        }

        return $mail_content;
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
            $date = Carbon::make($data['date'])->toDateString();
            $time = Carbon::make($data['time'])->toTimeString();
        }
        $template->title = $data['title'];
        $template->sender = $data['sender'];
        $template->schedule->update([
            'cron_time' => $data['cron_time'] ?? null,
            'date' => $date ?? null,
            'time' => $time ?? null,
            'template_id' => $template->id,
        ]);
        $mail_content = $this->handleImage($data['content'], $template);
        $template->content = $mail_content;
        $template->save();

        preg_match_all('/https:\/\/drive\.google\.com\/uc\?id=[A-Za-z0-9_\-&;]+export=media/', $mail_content, $matches);
        $urls = collect($matches[0])->map(static function ($url) {
            return str_replace('&amp;', '&', $url);
        })->toArray();
        $old_urls = $template->images->pluck('source', 'id')->toArray();
        $remove_images = [];
        foreach ($old_urls as $id => $old_url) {
            if (!in_array($old_url, $urls, true)) {
                $remove_images[] = $id;
            }
        }
        Image::query()->whereIn('id', $remove_images)->update(['active' => false]);

        return redirect()->route('template.index');
    }

    public function destroy(Template $template): RedirectResponse
    {
        $template->schedule->delete();
        $template->update(['active' => false]);
        $image_ids = $template->images->pluck('id');
        Image::query()->whereIn('id', $image_ids)->update(['active' => false]);

        return redirect()->route('template.index');
    }

}
