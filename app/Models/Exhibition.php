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
        'image_caption',
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

public function getFormattedScheduleAttribute(): string
{
    if ($this->schedules->isEmpty()) {
        return 'Geen data';
    }

    return $this->schedules->map(function ($schedule) {
        $line = $schedule->date->format('Y-m-d') . ': ' . $schedule->start_time . ' - ' . $schedule->end_time;

        if ($schedule->is_special_event && $schedule->special_event_description) {
            $line .= " (Special: {$schedule->special_event_description})";
        }

        return $line;
    })->implode("\r\n\r\n");
}

}
