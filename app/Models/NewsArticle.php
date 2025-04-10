<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'tags',
        'description',
        'image',
        'image_alt',
        'is_active',
    ];

    protected $casts = [
        'tags' => 'array',
        'date' => 'date',
    ];
}
