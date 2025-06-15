<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'image'];

    public function exhibitions()
    {
        return $this->morphedByMany(Exhibition::class, 'taggable');
    }

    public function newsArticles()
    {
        return $this->morphedByMany(NewsArticle::class, 'taggable');
    }
}
