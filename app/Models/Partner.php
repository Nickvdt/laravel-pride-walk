<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = ['name', 'logo'];

    public function aboutUs()
    {
        return $this->belongsToMany(AboutUs::class)
                    ->withPivot('partner_id', 'about_us_id');
    }
}
