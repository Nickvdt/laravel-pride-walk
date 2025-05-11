<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist_name',
        'venue_name',
        'description',
        'image',
        'location',
        'is_active',
        'image_alt',
    ];


    protected $casts = [
        'is_active' => 'boolean',
        'location' => 'array',
        'artist_name' => 'array',
    ];

    public function schedules()
    {
        return $this->hasMany(ExhibitionSchedule::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
