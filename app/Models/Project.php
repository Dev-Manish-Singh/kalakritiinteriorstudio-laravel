<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'summary',
        'description',
        'challenge_title',
        'challenge_content',
        'quote_text',
        'quote_author',
        'final_title',
        'final_content',
        'image_path',
        'secondary_image_path',
        'tertiary_image_path',
        'overlay_image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
