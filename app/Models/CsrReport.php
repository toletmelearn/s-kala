<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CsrReport extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'report_period',
        'summary',
        'highlights',
        'challenges',
        'future_plan',
        'report_file',
        'cover_image',
        'is_featured',
        'is_published',
        'published_at',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'sort_order' => 'integer',
        ];
    }
}
