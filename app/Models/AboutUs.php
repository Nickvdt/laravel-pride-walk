<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us';
    protected $fillable = ['description', 'email', 'image'];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'about_us_team', 'about_us_id', 'team_id');
    }

    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'about_us_partner', 'about_us_id', 'partner_id');
    }
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
