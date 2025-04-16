<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitionSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'exhibition_id',
        'date',
        'start_time',
        'end_time',
        'recurrence_rule',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'start_time' => 'string',
        'end_time' => 'string',
    ];

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }
}
