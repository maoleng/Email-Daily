<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Base
{
    use HasFactory;

    public const BANNER = 'https://i.pinimg.com/564x/13/b2/c5/13b2c5d0b06b2ee135ce911dbe37144e.jpg';

    protected $fillable = [
        'title', 'content', 'sender', 'cron_time', 'date', 'time', 'active', 'banner', 'user_id',
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'template_id', 'id');
    }

    public function getBeautifulCronTimeAttribute(): string
    {
        return match($this->cron_time) {
            '0 */2 * * *' => 'Mỗi 2 giờ',
            '0 */3 * * *' => 'Mỗi 3 giờ',
            '0 */4 * * *' => 'Mỗi 4 giờ',
            '0 */6 * * *' => 'Mỗi 6 giờ',
            '0 */8 * * *' => 'Mỗi 8 giờ',
            '0 */12 * * *' => 'Mỗi 12 giờ',
            '0 0 */1 * *' => 'Mỗi 1 ngày',
            '0 0 */2 * *' => 'Mỗi 2 ngày',
            '0 0 */3 * *' => 'Mỗi 3 ngày',
            '0 0 */4 * *' => 'Mỗi 4 ngày',
            '0 0 */5 * *' => 'Mỗi 5 ngày',
            '0 0 */6 * *' => 'Mỗi 6 ngày',
            '0 0 */7 * *' => 'Mỗi 7 ngày',
        };
    }
}
