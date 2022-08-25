<?php

namespace App\Models;

use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Base
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'cron_time', 'date', 'time', 'count', 'active', 'template_id'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class, 'template_id', 'id');
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
    public function getDateTimeAttribute(): string
    {
        return Carbon::make($this->date . ' ' . $this->time)->format('d-m-Y H:i:s');
    }

    public function getNextQueueTimeAttribute(): string
    {
        Carbon::setLocale('vi');

        if (isset($this->cron_time)) {
            $cron = new CronExpression($this->cron_time);
            $next_queue_time = $cron->getNextRunDate()->format('Y-m-d H:i:s');
            $next_queue = Carbon::make($next_queue_time);
        } else {
            $next_queue = Carbon::make($this->date . ' ' . $this->time);
            if ($next_queue->lt(now())) {
                return 'Đã gửi';
            }
        }

        if ($this->active === false) {
            return 'Không hoạt động';
        }

        return 'Sẽ gửi trong ' . $next_queue->longRelativeDiffForHumans(now()->format('Y'));
    }
}
