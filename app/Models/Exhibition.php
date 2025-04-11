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
        'address',
        'description',
        'tags',
        'special_event',
        'image',
        'location',
        'is_active',
        'image_alt',
    ];


    protected $casts = [
        'tags' => 'array',
        'special_event' => 'boolean',
        'is_active' => 'boolean',
        'location' => 'array',
    ];

    public function schedules()
    {
        return $this->hasMany(ExhibitionSchedule::class);
    }
}
