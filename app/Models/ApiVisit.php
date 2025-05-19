<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiVisit extends Model
{
    protected $fillable = ['endpoint', 'ip_address', 'visit_count', 'visited_at'];

    protected $casts = [
        'visited_at' => 'datetime',
    ];
}