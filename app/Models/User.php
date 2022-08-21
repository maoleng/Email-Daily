<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Base
{
    use HasFactory;

    public const TIME_VERIFY = 180; //minutes
    public const MAX_SYSTEM_MAIL_PER_DAY = 3;

    protected $fillable = [
        'name', 'email', 'avatar', 'password', 'role', 'email_verified_at', 'token_verify',
        'active', 'count_system_mail_daily',
        'facebook_id', 'google_id', 'github_id', 'gitlab_id', 'twitter_id', 'linkedin_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_BCRYPT);
    }

    public function verify($password): bool
    {
        return password_verify($password, $this->password);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'user_id', 'id');
    }

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class, 'user_id', 'id');
    }

    protected static function boot(): void
    {
        parent::boot();

        self::created(static function ($model) {
            Setting::query()->create([
                'key' => 'theme',
                'value' => 'light',
                'user_id' => $model->id,
            ]);
        });

    }
}
