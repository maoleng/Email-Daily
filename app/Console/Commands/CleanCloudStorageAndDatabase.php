<?php

namespace App\Console\Commands;

use App\Models\Image;
use App\Models\Template;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanCloudStorageAndDatabase extends Command
{
    public const COMMAND = 'cloud_storage_and_database:clean';

    protected $signature = self::COMMAND;
    protected $description = 'Làm sạch bộ nhớ đám mây và cơ sở dữ liệu';

    public function handle(): void
    {
        $images = Image::query()->where('active', false)->get();
        if ($images->isNotEmpty()) {
            $image_paths = $images->pluck('path')->toArray();
            Storage::disk('google')->delete($image_paths);
            Image::destroy($images->pluck('id')->toArray());
        }
        Template::query()->where('active', false)->delete();
    }
}
