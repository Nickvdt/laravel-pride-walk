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
        'latitude',
        'longitude',
        'description',
        'tags',
        'special_event',
        'image',
        'image_alt',
    ];


    protected $casts = [
        'tags' => 'array',
        'special_event' => 'boolean',
        'location' => 'array',
    ];
   
}
