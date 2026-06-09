<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'highlights',
        'process_content',
        'icon_path',
        'image_path',
        'secondary_image_path',
        'tertiary_image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'highlight_list',
    ];

    public function getHighlightListAttribute(): array
    {
        return collect(explode("\n", (string) $this->highlights))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
