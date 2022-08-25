<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Template extends Base
{
    use HasFactory;

    public const BANNER = 'https://i.pinimg.com/564x/13/b2/c5/13b2c5d0b06b2ee135ce911dbe37144e.jpg';

    protected $fillable = [
        'title', 'content', 'sender', 'banner', 'active', 'user_id'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class, 'template_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'template_id', 'id');
    }

    public function getId2Attribute(): string
    {
        return substr($this->id, 0, 5);
    }

}
