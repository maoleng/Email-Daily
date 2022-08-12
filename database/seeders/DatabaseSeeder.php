<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Config;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Config::query()->insert([
            [
                'key' => 'register_title',
                'value' => 'XÁC NHẬN ĐĂNG KÝ',
            ],
            [
                'key' => 'facebook_url',
                'value' => 'https://www.facebook.com/maolengg',
            ],
            [
                'key' => 'github_url',
                'value' => 'https://github.com/apps/maoleng',
            ],
            [
                'key' => 'gitlab_url',
                'value' => 'https://gitlab.com/maoleng',
            ],
            [
                'key' => 'google_url',
                'value' => 'feature451@gmail.com',
            ],
            [
                'key' => 'linkedin_url',
                'value' => 'https://www.linkedin.com/company/maoleng',
            ],
        ]);
    }
}
