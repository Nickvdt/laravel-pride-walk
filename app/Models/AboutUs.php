<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us';
    protected $fillable = ['description', 'email'];

    // Relaties zonder pivot tabel
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'about_us_team', 'about_us_id', 'team_id');
    }

    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'about_us_partner', 'about_us_id', 'partner_id');
    }
}
