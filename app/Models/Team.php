<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'photo'];

    public function aboutUs()
    {
        return $this->belongsToMany(AboutUs::class)
                    ->withPivot('team_id', 'about_us_id');
    }
}
