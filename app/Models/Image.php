<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Base
{
    use HasFactory;

    protected $fillable = [
        'source', 'path', 'size', 'active', 'template_id',
    ];
    public $timestamps = false;

    protected $casts = [
        'active' => 'bool',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class, 'template_id', 'id');
    }
}
