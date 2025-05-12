<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiVisit extends Model
{
    protected $fillable = ['endpoint', 'visit_count', 'visited_at'];
}